<?php
# This file is part of CookieCMS Open.
#
# CookieCMS Open is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# CookieCMS Open is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with CookieCMS Open. If not, see <http://www.gnu.org/licenses/>.
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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // var_dump($result);

        header('Content-Type: application/json');
        $responseData = array(
            'discord' => $result["dsid"],
        );

        echo json_encode($responseData, JSON_PRETTY_PRINT);

        
    } else {
        $error = "Error executing query: " . $conn->errorInfo()[2];
        $response = json_encode(['error' => $error]);
        echo $response;
    }
}
