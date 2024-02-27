<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);
require_once __DEF__;
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require __CM__ . "inc/mysql.php";

require __CM__ . "home/main.php";

$loggeds = "";
$avatarUrlDS = "";

// $a = $_SESSION['uuid'];

if (isset($_SESSION['uuid'])) {
    
    $f = $_SESSION['uuid'];
    $avatarUrl = "http://192.168.1.85/api?module=skin&type=extra&uuid=$f&size=100&mode=3";

}
if (isset($_SESSION['user_data'])) {
    $loggeds = "true";
    $userData = $_SESSION['user_data'];
    $avatarUrlDS = "https://cdn.discordapp.com/avatars/{$userData['id']}/{$userData['avatar']}.png";
    // echo($avatarUrl);
}
if (isset($_GET['user'])) {
    $uuid = $_GET['user'];
    $owner = $_SESSION['id'];

    // Select the row where owner matches and username is equal to the provided user
    $stmt = $conn->prepare("SELECT username, uuid, `default`, owner FROM users_profiles WHERE BINARY owner = :owner AND BINARY uuid = :uuid");
    $stmt->bindParam(':owner', $owner);
    $stmt->bindParam(':uuid', $uuid);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($result);
    if (!$result) {

        // The user provided in 'user' doesn't match the owner in the database
        // Redirect the user to another page
        header("Location: /home");
        exit();
    }
    $a = $result['uuid']; 

    $playername = getUsernameByUUID($conn, $a);     
} else {
    $owner = $_SESSION['id'];

    // Select the row where default is 1 and owner matches the session ID
    $stmt = $conn->prepare("SELECT username, uuid, `default`, owner FROM users_profiles WHERE `default` = 1 AND BINARY owner = :owner");
    $stmt->bindParam(':owner', $owner);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($result);
    $a = $result['uuid'];
    $playername = getUsernameByUUID($conn, $a);   
}

// echo($uuid);

// if (isset($_SESSION['id'])) {
//     // $logged = "true";
// }else{
//     header("Location: /");
//      exit();

// }
// exit();

$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . 'assets/cookie.png',
    'bootstrapCssPath' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
    'jqueryPath' => 'https://code.jquery.com/jquery-3.5.1.slim.min.js',
    'popperPath' => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js',
    'bootstrapJsPath' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
    'buttonplay' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
    'assets' => __TDS__ . 'assets/background.jpg',
    'description' => 'Minecraft project with launcher x)',
    'maincss' => __CSS__ . 'main.css',
    'avatarUrlds' => "$avatarUrlDS",
    // 'avatarUrl' => "$avatarUrl",
    'test' => "$a",
    'skinjs' => __TDS__ . "js/skinview3d.bundle.js",
    'uuid' => "$a",
    'Username' => "$playername",
    // 'logged' => "$logged",
    
];



?>
