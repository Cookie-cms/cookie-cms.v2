<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
require_once __DEF__;

$avatarUrl = "";


if (isset($_SESSION['user_data'])) {
    $userData = $_SESSION['user_data'];
    $avatarUrl = "https://cdn.discordapp.com/avatars/{$userData['id']}/{$userData['avatar']}.png";
    // echo($avatarUrl);
}



$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . "$icon",
    'bootstrapcss' => "$bootstrapcss",
    'bootstrapjs' => "$bootstrapjs",
    'bootstrapicons' => "$bootstrapicons",
    'maincss' => __CSS__ . 'main.css',
    'assets' => __TDS__ . 'assets/background.jpg',
    'authcss' => __CSS__ . 'auth.css',
    'avatarUrl' => "$avatarUrl",
    'loginform' => __CML__ . 'auth/login.php',
    'registerform' => __CML__ . 'auth/basic/register.php',
    'registerds' => __CM__ . 'auth/registerds.php',
    'discordlink' => 'https://discord.com/',
    'genusername' => 'false',
 
];

?>
