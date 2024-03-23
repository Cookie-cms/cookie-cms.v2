<?php

if (isset($_GET['code'])) {
    // Получение кода авторизации от Discord

    // Обработка авторизации и получение информации о пользователе (подставьте свои данные)
    $client_id = '1181148727826722816';
    $client_secret = '5YaScJyKq0pDQxO_B5YlhUwcBnlkr37P';
    $redirect_uri = 'http://cookiecms.local/api/discord'; // Укажите ваш редирект URI

    // Запрос на обмен кода авторизации на токен доступа
    $code = $_GET['code'];
    $token_url = 'https://discord.com/api/oauth2/token';

    $data = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirect_uri,
    );

    $options = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ),
    );

    $context = stream_context_create($options);
    $response = file_get_contents($token_url, false, $context);
    $token_data = json_decode($response, true);

    // Получение информации о пользователе из Discord API
    $access_token = $token_data['access_token'];

    // Получение информации о пользователе
    $user_url = 'https://discord.com/api/users/@me';

    $user_headers = array(
        'Authorization: Bearer ' . $access_token,
    );

    $user_context = stream_context_create(array(
        'http' => array(
            'header' => $user_headers,
        ),
    ));

    $user_response = file_get_contents($user_url, false, $user_context);
    $user_data = json_decode($user_response, true);

    // Передача информации в другой файл (например, process_user.php)
    $_SESSION['user_data'] = $user_data;
    // var_dump($user_data);
    header('Location: /engine/modules/auth/discord/login.php');
};
?>