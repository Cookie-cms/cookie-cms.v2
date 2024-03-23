<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
// $yamlFilePath = __CM__ . 'configs/config.inc.yml';
require_once __CI__ . "yamlReader.php";

$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);


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


    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (id, password) VALUES (:id, :pass)");
        $stmt->bindParam(':id', $id);
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
        setcookie('show', 'true', time() + 3600, '/');
        header("Location: /settings");
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
