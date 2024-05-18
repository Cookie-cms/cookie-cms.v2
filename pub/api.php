<?php

error_reporting(E_ALL);
ini_set('display_errors', true);// Функции с плащами пока вырезаны
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once __CD__. "modules/api/verifytoken_profile.php";
$requestUri = $_SERVER['REQUEST_URI'];
$uriSegments = explode('/', trim($requestUri, '/'));
require_once __CM__ . "inc/mysql.php";
require_once __CI__ . "yamlReader.php";
$api_path = __CM__ . 'configs/api.yaml';
$yaml_data = read_yaml($api_path);
define('__URI__', strstr($_SERVER['REQUEST_URI'], '?', true) ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI']);
define('__URL__', array_slice(explode('/', substr(__URI__, 1)), 0, 7));
$requestedModule = __URL__[1];
if (isset($yaml_data[$requestedModule])) {
    $uriParameters = http_build_query($_GET);
    $data = $yaml_data[$requestedModule];
    $moduleFilePath = __CD__ . "modules/api/{$data['dir']}/main.php";

    if (file_exists($moduleFilePath)) {
        include $moduleFilePath;
    } else {
        http_response_code(404);
        die($errorContent);
    }
} else {
    http_response_code(404);
    die("Module not found");
}
?>
