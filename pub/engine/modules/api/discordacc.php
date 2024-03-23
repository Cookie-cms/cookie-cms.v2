<?php

error_reporting(E_ALL);
ini_set('display_errors', true);// Функции с плащами пока вырезаны
require_once __CI__ . "yamlReader.php";

$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);
$domain = $yaml_data['basic']['domain'];



if (__URL__[2] == "discord") {

    $dsid = __URL__[3];

    // Select user IDs where discord is equal to dsid
    $query = "SELECT id FROM users WHERE dsid = :dsid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':dsid', $dsid);
    $stmt->execute();

    if ($stmt) {
        // Fetch the user IDs
        $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Select usernames from users_profiles where owner is equal to owner
        $usernames = [];
        foreach ($userIds as $userId) {
            $query = "SELECT username, uuid FROM users_profiles WHERE owner = :userId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $usernames[] = $row['username'];
                $uuid[] = $row['uuid'];
            }
        }
        header('Content-Type: application/json');

        if (empty($result)) {
            $response = "[" . json_encode(['error' => 'No usernames found for this discord ID']) . "]";
        } else {
            $response = json_encode($result);
        }
        // Use the usernames as needed
        // $response = ;
        echo $response;
    } else {
        $error = "Error executing query: " . $conn->errorInfo()[2];
        $response = json_encode(['error' => $error]);
        echo $response;
    }
}

if (__URL__[2] == "minecraft") {

    $minecraft = __URL__[3];

    // Select user IDs where discord is equal to dsid
    $query = "SELECT owner, uuid FROM users_profiles WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $minecraft);
    $stmt->execute();

    if ($stmt) {
        // Fetch the user IDs
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Select dsid from users where owner is equal to owner
        $query = "SELECT dsid FROM users WHERE id = :owner";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':owner', $result[0]['owner']);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $value) {
            $result[$key]['discord'] = $value['dsid'];
            unset($result[$key]['dsid']);
        }
        header('Content-Type: application/json');

        // Use the dsid as needed
        $response = json_encode($result);
    echo $response;


        
    } else {
        $error = "Error executing query: " . $conn->errorInfo()[2];
        $response = json_encode(['error' => $error]);
        echo $response;
    }
}
