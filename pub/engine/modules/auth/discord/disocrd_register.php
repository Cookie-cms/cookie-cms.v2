<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();

if (isset($_SESSION['user_data']['id'])) {
    $user_id = $_SESSION['user_data']['id'];
    echo "User ID: " . $user_id;
} else {
    echo "User ID not found in session data.";
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";
require __CM__ . "mail/sendmail.php";
require __CM__ . "mail/gencode.php";

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['password']) && isset($_POST['re_password'])) {
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);

    if ($pass !== $re_pass) {
        echo "Passwords do not match.";
        exit();
    }

    $id = mt_rand(000000000000000000, 999999999999999999);
    $dsid = $_SESSION['user_data']['id'];

    
    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);
    if ($_SESSION['user_data']['email']) {
        $email = $_SESSION['user_data']['email'];
        $username = $_SESSION['user_data']['username'];
        // function send welcome email
        
        // function send verifi cation email
        try {
            $stmt = $conn->prepare("INSERT INTO users (id, dsid,password, mail) VALUES (:id, :dsid, :pass, :mail)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':dsid', $id);
            $stmt->bindParam(':pass', $hashed_password);
            $stmt->bindParam(':mail', $email);
            $stmt->execute();

            $_SESSION['id'] = $id;
        } catch (PDOException $e) {
            echo "An error occurred during registration. Please try again later.";
            error_log("PDOException: " . $e->getMessage(), 0);
            exit();
        }
        welcomemsg($email, $id, time(), $username);
        $code = generatecode($userid);
        verificationmsg($email, $code, $username);
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO users (id, dsid,password) VALUES (:id, :dsid, :pass)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':dsid', $id);
            $stmt->bindParam(':pass', $hashed_password);
            $stmt->execute();

            $_SESSION['id'] = $id;
        } catch (PDOException $e) {
            echo "An error occurred during registration. Please try again later.";
            error_log("PDOException: " . $e->getMessage(), 0);
            exit();
        }
    }
    
} else {
    echo "Form data incomplete.";
    exit();
}
?>
