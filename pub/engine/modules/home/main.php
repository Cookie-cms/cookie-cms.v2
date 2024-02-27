<?php
// error_reporting(E_ALL);  
// ini_set('display_errors', true);
// session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";



function getUsernameByUUID($conn, $uuid) {
    try {
        $stmt = $conn->prepare("SELECT username FROM users_profiles WHERE uuid = :uuid");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->execute();
        $fetchedUser = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($fetchedUser) ? $fetchedUser['username'] : null;
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        return null;
    } catch (Exception $e) {
        error_log("General Error: " . $e->getMessage());
        return null;
    }
}

?>