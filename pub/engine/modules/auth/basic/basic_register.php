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


// ss
require __CM__ . "inc/mysql.php";
// function isPrivateIP($ip) {
//     // Convert IP address to long integer
//     $ipLong = ip2long($ip);

//     // Check if the IP is in the private range 192.168.0.0/12
//     $privateStart = ip2long('192.168.0.0');
//     $privateEnd = ip2long('192.168.255.255');

//     if ($ipLong >= $privateStart && $ipLong <= $privateEnd) {
//         return true;
//     } else {
//         return false;
//     }
// }

// $ip = $_SERVER['REMOTE_ADDR'];

// if (isPrivateIP($ip)) {
//     die('Private IP address detected');
// }

// // Rest of your code...
// $url = "http://ip-api.com/json/$ip";
// $jsonData = file_get_contents($url);

// if ($jsonData === false) {
//     // Handle error, e.g., connection issue
//     die('Error fetching data from the URL');
// }

// Decode the JSON data
// $data = json_decode($jsonData, true);

// if ($data === null) {
//     // Handle JSON decoding error
//     die('Error decoding JSON data');
// }

// // Now you can work with the $data array
// print_r($data);

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
