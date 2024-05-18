<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once __CI__ . "yamlReader.php";
$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);
$discord = $yaml_data['discord'];

$client_id = $discord['client_id'];
$client_secret = $discord['secret_id'];
$redirect_uri = $discord['redirect_url'];
$scope = $discord['scopes'];
if (isset($_GET['code'])) {
    // Запрос на обмен кода авторизации на токен доступа
    if (__URL__[2] == 'admin') {
        $redirect_uri = $redirect_uri . '/admin';
        // echo $redirect_uri;
    }
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
    if (__URL__[2] == 'admin') {
        header('Location: /engine/modules/auth/admin/login.php');
        // echo "admin";
    } else {
        // echo "default";
        header('Location: /engine/modules/auth/discord/login.php');
    }
}else{
    header('Content-Type: application/json');
	$response = json_encode(['error' => 'No modules found for this request']);
	echo $response;
}
?>