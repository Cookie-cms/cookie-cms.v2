<?php

function generatecode($userid){
    require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

    require __CM__ . "inc/mysql.php";

    $length = 3;
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $randomString = '';

    $max = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $max)];
    }

    $randomString .= '-';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $max)];
    }

    $code = password_hash($randomString, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO mail_codes (userid, code) VALUES (:userid, :code, 'mail')");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':code', $code);
    $stmt->execute();
    return $randomString;
}