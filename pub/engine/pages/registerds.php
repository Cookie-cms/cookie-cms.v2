<?php
// if (!isset($_SESSION['user_data'])) {
//     // Если данных нет, перенаправляем пользователя на страницу авторизации Discord
//     header('Location: https://discord.com/api/oauth2/authorize?client_id=1181148727826722816&response_type=code&redirect_uri=http%3A%2F%2F192.168.1.17%2F&scope=identify');
//     exit(); // Обязательно завершаем выполнение скрипта после перенаправления
// }
require_once __DEF__;

if (isset($_SESSION['user_data'])) {
    $userData = $_SESSION['user_data'];
    $avatarUrl = "https://cdn.discordapp.com/avatars/{$userData['id']}/{$userData['avatar']}.png";
    // echo($avatarUrl);
}

$username = $_SESSION['user_data']['username'];
$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . "$icon",
    'pageDescription' => 'Это пример использования TLP с передачей данных.',
    'bootstrapCssPath' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
    'jqueryPath' => 'https://code.jquery.com/jquery-3.6.0.min.js',
    'bootstrapJsPath' => 'https://code.jquery.com/jquery-3.6.0.min.js',
    'buttonplay' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
    'assets' => __TDS__ . 'assets/background.jpg',
    'maincss' => __CSS__ . 'main.css',
    'registerdscss' => __CSS__ . 'registerds.css',
    'registerform' => __RD__ . 'engine/modules/auth/discord/register.php',
    'avatarUrl' => "$avatarUrl",
    'username' => "$username",
    
];

?>