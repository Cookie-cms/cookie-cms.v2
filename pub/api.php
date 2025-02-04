<?php
# This file is part of CookieCMS Open.
#
# CookieCMS Open is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# CookieCMS Open is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with CookieCMS Open. If not, see <http://www.gnu.org/licenses/>.
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
    header('Content-Type: application/json');
    $responseData = array(
        'error' => true,
        'msg' => 'Api request not found'
    );
    die(json_encode($responseData, JSON_PRETTY_PRINT));

}
?>
