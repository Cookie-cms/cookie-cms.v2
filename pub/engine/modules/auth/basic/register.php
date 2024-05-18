<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
// $yamlFilePath = __CM__ . 'configs/config.inc.yml';
require_once __CI__ . "yamlReader.php";
require __CM__ . "auth/ip_module.php";

$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);
$AccountsPerIP = $yaml_data['basic']['AccountsPerIP'];
$BlockLocalhost = $yaml_data['basic']['BlockLocalhost'];
$registrationstatus = $yaml_data['basic']['registration'];


if ($registrationstatus === false) {
    header('Content-Type: application/json');
        $responseData = array(
            'error' => true,
            'msg' => "Registration is disabled."
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
}


$ip = $_SERVER['REMOTE_ADDR'];

if ($BlockLocalhost){
    $isLocal = isLocalIp($ip);
    if ($isLocal) {
        header('Content-Type: application/json');
        $responseData = array(
            'error' => true,
            'msg' => "The IP address {$userIpAddress} is in the local range (192.168.0.0 to 192.168.225.255)."
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    }
}


require __CM__ . "inc/mysql.php";


function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE ip = :ip");
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die("error: You already registered.");
    }


    if (isset($_POST['password']) && isset($_POST['re_password'])) {
        $pass = validate($_POST['password']);
        $re_pass = validate($_POST['re_password']);

        if (empty($pass) || empty($re_pass) || $pass !== $re_pass) {
            echo "error: Passwords empty or do not match.";
            exit();
        }

        $id = mt_rand(000000000000000000, 999999999999999999);


        $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (id, ip, password) VALUES (:id, :ip, :pass)");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':pass', $hashed_password);
            $stmt->bindParam(':ip', $ip);
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
            echo "success";
            // header("Location: /settings");
        } catch (PDOException $e) {
            echo "error: An error occurred during registration. error: " . $e->getMessage();   
            error_log("error: PDOException: " . $e->getMessage(), 0);
            exit();
        }
    } else {
        echo "ERROR: Form data incomplete.";
        // exit();
    }
} catch (PDOException $e) {
    // echo "error: An error occurred during registration. Please try again later.";
    echo "error: An error occurred during registration. error: " . $e->getMessage();   
    error_log("error: PDOException: " . $e->getMessage(), 0);
    exit();
}
?>
