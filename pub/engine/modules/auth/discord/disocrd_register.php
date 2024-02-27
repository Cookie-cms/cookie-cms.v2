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

    $length = 3;
    $id = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length) . '-' . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    $dsid = $_SESSION['user_data']['id'];

    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (id, dsid,password) VALUES (:id, :dsid, :pass)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':dsid', $id);
        $stmt->bindParam(':pass', $hashed_password);
        $stmt->execute();

        // Assuming $user is fetched from somewhere in your code, adjust this part accordingly
        // if ($user) {
        //     $_SESSION['id'] = $user['id'];
        // } else {
        //     echo "Failed to fetch user data.";
        //     exit();
        // }
        // $_SESSION['id'] = $conn->lastInsertId();  // Get the last inserted ID
        // var_dump($_SESSION['id']);
        $_SESSION['id'] = $id;
    } catch (PDOException $e) {
        echo "An error occurred during registration. Please try again later.";
        error_log("PDOException: " . $e->getMessage(), 0);
        exit();
    }
} else {
    echo "Form data incomplete.";
    exit();
}
?>
