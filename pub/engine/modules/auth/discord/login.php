<?php 
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
ini_set('session.cookie_lifetime', 86400);
require __CM__ . "inc/mysql.php";


if (!isset($_SESSION['user_data']['id'])) {
    header("Location: oauth2_page.php");
    exit();
}

$dsid = $_SESSION['user_data']['id'];

try {
    $stmt = $conn->prepare("SELECT id FROM users WHERE dsid = :dsid");
    $stmt->bindParam(':dsid', $dsid);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['id'] = $user['id'];
        // $_SESSION['uuid'] = $user['uuid'];
        header("Location: /home");
        exit();
    } else {
        header("Location: /registerds");
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
