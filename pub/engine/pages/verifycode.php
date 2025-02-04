<?php
# This file is part of CookieCms.
#
# CookieCms is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# CookieCms is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with CookieCms. If not, see <http://www.gnu.org/licenses/>.
error_reporting(E_ALL);
ini_set('display_errors', true);
require_once __DEF__;

$avatarUrl = "";




$a = $_SERVER['REMOTE_ADDR'];
// $logged = true;
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
    // echo($avatarUrl);
}
$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . 'assets/cookie.png',
    'pageDescription' => 'Это пример использования TLP с передачей данных.',
    'bootstrapCssPath' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
    'jqueryPath' => 'https://code.jquery.com/jquery-3.5.1.slim.min.js',
    'popperPath' => 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js',
    'bootstrapJsPath' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
    'buttonplay' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
    'assets' => __TDS__ . 'assets/background.jpg',
    'description' => 'Minecraft project with launcher x)',
    'maincss' => __CSS__ . 'main.css',
    'avatarUrlds' => "$avatarUrlDS",
    'avatarUrl' => "$avatarUrl",
    'test' => "$a",
    'logged' => "$loggeds",
];



?>
