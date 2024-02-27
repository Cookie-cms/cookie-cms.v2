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
    'icon' => __TDS__ . 'assets/cookie.png',
    'pageDescription' => 'Это пример использования TLP с передачей данных.',
    'header' => "$headerContent",
    'assets' => __TDS__ . 'assets/background.jpg',
    'description' => 'Minecraft project with launcher x)',
    'maincss' => __CSS__ . 'main.css',
    'authcss' => __CSS__ . 'auth.css',
    'avatarUrl' => "$avatarUrl",
    'loginform' => __CML__ . 'auth/login.php',
    'registerform' => __CML__ . 'auth/register/basic_register.php',
    'registerds' => __CM__ . 'auth/registerds.php',
    'discordlink' => 'https://discord.com/',
    'genusername' => 'false',
 
];


?>
