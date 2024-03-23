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
if (isset(__URL__[1])) {
    $uuid = __URL__[1];
    $owner = $_SESSION['id'];
    echo($uuid);
    // Select the row where owner matches and username is equal to the provided user
    // $stmt = $conn->prepare("SELECT username, uuid, `default`, owner FROM users_profiles WHERE BINARY owner = :owner AND BINARY uuid = :uuid");
    // $stmt->bindParam(':owner', $owner);
    // $stmt->bindParam(':uuid', $uuid);
    // $stmt->execute();

    // // Fetch the result
    // $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // // var_dump($result);
    // if (!$result) {

    //     // The user provided in 'user' doesn't match the owner in the database
    //     // Redirect the user to another page
    //     header("Location: /home");
    //     exit();
    // }
    // $a = $result['uuid']; 

    // $playername = getUsernameByUUID($conn, $a);     
} else {
    $owner = $_SESSION['id'];

    // Select the row where default is 1 and owner matches the session ID
    $stmt = $conn->prepare("SELECT username, uuid, `default`, owner, id FROM users_profiles WHERE `default` = 1 AND BINARY owner = :owner");
    $stmt->bindParam(':owner', $owner);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($resultr);
    $a = $result['uuid'];
    $playername = getUsernameByUUID($conn, $a);   
}
// echo($_SESSION['id']);



if (!isset($_SESSION['id'])) {
    header("Location: /");
     exit();
}
// exit();

$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . "$icon",
    'bootstrapcss' => "$bootstrapcss",
    'bootstrapjs' => "$bootstrapjs",
    'bootstrapicons' => "$bootstrapicons",
    'assets' => __TDS__ . 'assets/background.jpg',
    'description' => 'Minecraft project with launcher x)',
    'maincss' => __CSS__ . 'main.css',
    'avatarUrlds' => "$avatarUrlDS",
    // 'avatarUrl' => "$avatarUrl",
    'skinjs' => __TDS__ . "js/skinview3d.bundle.js",
    'uuid' => "$a",
    'username' => "$playername",
    // 'logged' => "$logged",
    
];

// $id = $result['id'];
// $stmt = $conn->prepare("SELECT * FROM cloaks WHERE uid = :id");
// $stmt->bindParam(':id', $id);
// $stmt->execute();
// $cloaks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $stmt = $conn->prepare('SELECT * FROM `cape_users` WHERE `uid` = :uid');
// $stmt->bindValue(':uid', $id);

// $stmt->execute();
// $cloak = $stmt->fetch(PDO::FETCH_ASSOC);
// // var_dump($cloak);
// ob_start(); // Start output buffering



// $listContent = ob_get_clean(); // Get the content and clear the buffer

// // Add $listContent to the $variables array
// $variables = isset($variables) && is_array($variables) ? $variables : [];
// $variables['cape'] = $listContent;