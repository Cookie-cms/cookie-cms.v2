<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();

// Define constants or variables
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once __CD__. "modules/api/verifytoken_profile.php";
$requestUri = $_SERVER['REQUEST_URI'];
$uriSegments = explode('/', trim($requestUri, '/'));
require_once __CM__ . "inc/mysql.php";

// Define URI constant
define('__URI__', strstr($_SERVER['REQUEST_URI'], '?', true) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI']);
define('__URL__', array_slice(explode('/', substr(__URI__, 1)), 0, 3));

// Validate and sanitize __URL__ if needed
// echo '<p style="font-size: 20px;">Requested URI: ' . $requestUri . '</p>';
// if (empty(__URL__[1])) {
//     http_response_code(502);
//     $errorContent = file_get_contents('../errors/502.html');
//     die($errorContent);
// }
// global $headers;
// $headers = getallheaders();
// // var_dump($headers);
// $token = trim(str_replace('Bearer', '', $headers['Authorization']));

//         $userInfo = verifyToken($token); // You need to define this function
//         var_dump($userInfo);
if (__URL__[1] == "discord") {
    $uriParameters = http_build_query($_GET);

    $moduleFilePath = __CD__ . "modules/api/main/oauth2.php";
    if (file_exists($moduleFilePath)) {
        include $moduleFilePath;
    } else {
        http_response_code(404);
        $errorContent = file_get_contents('../errors/404.html');
        die($errorContent);
    }
} elseif (__URL__[1]) {
    $module = __URL__[1];
    $uriParameters = http_build_query($_GET);

    $moduleFilePathf = __CD__ . "modules/api/service/g.php";
    // echo($moduleFilePathf);


    if (file_exists($moduleFilePathf)) {
        include $moduleFilePathf;
    } else {
        http_response_code(404);
        $errorContent = file_get_contents('../errors/404.html');
        die($errorContent);
    }
}
?>
