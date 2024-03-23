<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";
require __CM__ . "inc/checkperms.php";
$owner = $_SESSION['id'];

    // Select the row where default is 1 and owner matches the session ID
$stmt = $conn->prepare("SELECT username, uuid, `default`, owner FROM users_profiles WHERE `default` = 1 AND BINARY owner = :owner");
$stmt->bindParam(':owner', $owner);
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($resultr);
$uuid = $result['uuid'];

$permissions = getUserPermissionsByUUID($uuid, $conn);
var_dump($permissions);