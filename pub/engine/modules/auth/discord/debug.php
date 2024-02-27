<?php
session_start();

if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];

    // Вывод содержимого массива
    echo '<pre>';
    print_r($user_data);
    echo '</pre>';
} else {
    echo 'Ошибка: Нет данных о пользователе в сессии.';
}

$avatar_url = "https://cdn.discordapp.com/avatars/".$_SESSION['id']."/".$_SESSION['avatar'];

?>