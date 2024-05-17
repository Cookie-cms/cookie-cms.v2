<?php 
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('session.cookie_lifetime', 86400);
session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require __CM__ . "inc/mysql.php";
require __CM__ . "inc/discordlink.php";

if (!isset($_SESSION['user_data']['id'])) {
    $url = generate_url();
    echo "<a href='$url'>Login with Discord</a>";
    // header("Location: $url");
    exit;
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
        header("Location: /settings");
        exit();
    } else {
        header("Location: /oauth2");
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
