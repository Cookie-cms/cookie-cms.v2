<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

// if (!isset($_POST['code'])) {
    $url = $_POST['url'];
    $code = $_POST['code'];
    require __CM__ . "inc/mysql.php";

    $stmt = $conn->prepare("SELECT userid FROM verify_codes WHERE url = :url");
    $stmt->bindParam(':url', $url);
    $stmt->execute();   
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($code, $result['code'])) {
        $stmt = $conn->prepare("UPDATE users SET mail_verify = 1 WHERE id = :userid");
        $stmt->bindParam(':userid', $result['userid']);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM verify_codes WHERE url = :url");
        $stmt->bindParam(':url', $url);
        $stmt->execute();
        echo "Account verified!";
    } else {
        echo "Invalid code!";
    }   
    // } else {
        // echo "No code provided!";
    // }
    