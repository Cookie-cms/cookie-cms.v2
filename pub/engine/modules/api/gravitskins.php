<?php
	error_reporting(E_ALL);
    ini_set('display_errors', true);// Функции с плащами пока вырезаны
    require_once __CI__ . "yamlReader.php";

    $file_path = __CM__ . 'configs/config.inc.yaml';
    $yaml_data = read_yaml($file_path);
    $domain = $yaml_data['basic']['domain'];
    $skindefault = $yaml_data['basic']['skindefault']['skin'];
    $slimdefault = $yaml_data['basic']['skindefault']['slim'];
    // echo $slim;


if(__URL__[2] != null) {
    $uuid = __URL__[2];
    $sql = 'SELECT c.`cloak`, s.`slim`, s.`locked`, s.`cape`
    FROM `users_profiles` u
    LEFT JOIN `skins` s ON s.`uuid` = u.`uuid`
    LEFT JOIN `cloaks` c ON c.`id` = s.`cape`
    WHERE u.`uuid` = :uuid';

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    // Bind the parameter
    $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        http_response_code(404);
        die("Invalid UUID provided.");
    }
    // Fetch the result
    $cloakQueryResult = $stmt->fetch(PDO::FETCH_OBJ);
    $locked = isset($cloakQueryResult->locked) ? $cloakQueryResult->locked : null;
    $slim = isset($cloakQueryResult->slim) ? $cloakQueryResult->slim : null;

    $responseData = array();

    $skinData = array();

    

    if (isset($locked) && $locked == "1") {
        $skinData["url"] = "https://$domain/uploads/skins/{$uuid}.png";
        $skinData["digest"] = hash_file('sha256', $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/{$uuid}.png");
        if (isset($slim) && $slim == "1") {
            $skinData["metadata"] = array("model" => "slim");
        }
    } else {
        if (isset($skindefault) && $skindefault == "default") {
            $skinData["url"] = "https://$domain/uploads/skins/default.png";
            $skinData["digest"] = hash_file('sha256', $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/default.png");
            if (isset($slimdefault) && $slimdefault == "1") {
                $skinData["metadata"] = array("model" => "slim");
            }
        }
        
    }
    

    // Add conditions for CAPE data
    if ($cloakQueryResult !== false && isset($cloakQueryResult->cloak)) {
        $capeData = array();

        $cloakName = $cloakQueryResult->cloak;
        $cloakPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/capes/{$cloakName}.png";
        $sha256HashHexCloak = hash_file('sha256', $cloakPath);
        $cloakUrl = "https://$domain/uploads/capes/{$cloakName}.png";

        $capeData = array(
            "url" => $cloakUrl,
            "digest" => $sha256HashHexCloak
        );

        // Add metadata if $slim is set and equals "1"
        // if (isset($slim) && $slim == "1") {
        //     $capeData["metadata"] = array("model" => "slim");
        // }
    }

    // Combine SKIN and CAPE data into the response
    $responseData = array(
        "SKIN" => $skinData,
        "CAPE" => !empty($capeData) ? $capeData : []
    );

    // Set the content type to JSON
    header('Content-Type: application/json');

    // Encode the data as JSON and echo it
    echo json_encode($responseData, JSON_PRETTY_PRINT);

} else {
    http_response_code(404);
    die("Invalid UUID provided.");
}
// SQL query with a parameter placeholder
