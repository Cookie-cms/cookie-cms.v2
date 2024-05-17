<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
require_once __DEF__;
$avatarUrl = "";
require __CD__ . 'pages/global.php';




$a = $_SERVER['REMOTE_ADDR'];

$loggeds = "";
$avatarUrlDS = "";
if (isset($_SESSION['uuid'])) {
    
    $f = $_SESSION['uuid'];
    $avatarUrl = "http://192.168.1.85/api?module=skin&type=extra&uuid=$f&size=100&mode=3";

}
if (isset($_SESSION['user_data'])) {
    $loggeds = "true";
    $userData = $_SESSION['user_data'];
    $avatarUrlDS = "https://cdn.discordapp.com/avatars/{$userData['id']}/{$userData['avatar']}.png";
}
$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . "$icon",
    'bootstrapcss' => "$bootstrapcss",
    'bootstrapjs' => "$bootstrapjs",
    'bootstrapicons' => "$bootstrapicons",
    'jquery' => "$jquery",
    'jqueryPath' => 'https://code.jquery.com/jquery-3.5.1.slim.min.js',
    'buttonplay' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
    'assets' => __TDS__ . 'assets/background.jpg',
    'description' => "$indexdescription",
    'maincss' => __CSS__ . 'main.css',
    'avatarUrlds' => "$avatarUrlDS",
    'avatarUrl' => "$avatarUrl",
    't' => "$requestUri",
    'logged' => "$loggeds",
    'snow' => $snow,
];

// $id = $result['id'];
// $stmt = $conn->prepare("SELECT * FROM audit");
// $stmt->execute();
// $audit = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ob_start(); // Start output buffering



// $listContent = ob_get_clean(); // Get the content and clear the buffer

// // Add $listContent to the $variables array
// $variables = isset($variables) && is_array($variables) ? $variables : [];
// $variables['cape'] = $listContent;
?>
