<?php

require_once __CI__ . "yamlReader.php";

$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);
if (!isset($_GET['code']) || !isset($_GET['userid'])) {
    header('Content-Type: application/json');
    $responseData = array(
        'error' => true,
        'msg' => 'Invalid request.'
    );
    die(json_encode($responseData, JSON_PRETTY_PRINT));
}
$code = $_GET['code'];

$userid = $_GET['userid'];

$stmt = $conn->prepare("SELECT * FROM mail_codes WHERE userid = :userid AND code = :code"); 
$stmt->bindParam(':userid', $userid);
$stmt->bindParam(':code', $code);
$stmt->execute();   

if ($stmt->rowCount() > 0) {
    $stmt = $conn->prepare("UPDATE users SET mail_verify = 1 WHERE id = :userid");
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM mail_codes WHERE userid = :userid");
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
    header('Content-Type: application/json');
    $responseData = array(
        'error' => false,
        'msg' => 'Your account has been verified.'
    );
    echo(json_encode($responseData, JSON_PRETTY_PRINT));
    sleep(2);
    header('Location: /');
    exit();
} else {
    header('Content-Type: application/json');
    $responseData = array(
        'error' => true,
        'msg' => 'Invalid code.'
    );
    die(json_encode($responseData, JSON_PRETTY_PRINT));
}