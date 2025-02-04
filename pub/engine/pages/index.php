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
ini_set('display_errors', true);
require_once __DEF__;
$avatarUrl = "";
require __CD__ . 'pages/global.php';
require __CM__ . "inc/mysql.php";




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
    'session' => $session,
];
// $snow = "true";
// $variables['snow'] = $snow;

// $username = $_COOKIE['show'];
    // echo $username;
?>
