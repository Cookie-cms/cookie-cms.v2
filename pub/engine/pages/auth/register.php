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


if (isset($_SESSION['user_data'])) {
    $userData = $_SESSION['user_data'];
    $avatarUrl = "https://cdn.discordapp.com/avatars/{$userData['id']}/{$userData['avatar']}.png";
    // echo($avatarUrl);
}

$token = isset($_GET['token']) ? $_GET['token'] : '';

$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . "$icon",
    'bootstrapcss' => "$bootstrapcss",
    'bootstrapjs' => "$bootstrapjs",
    'bootstrapicons' => "$bootstrapicons",
    'maincss' => __CSS__ . 'main.css',
    'assets' => __TDS__ . 'assets/background.jpg',
    'authcss' => __CSS__ . 'auth.css',
    'avatarUrl' => "$avatarUrl",
    'loginform' => __CML__ . 'auth/login.php',
    'registerform' => __CML__ . 'auth/basic/register.php',
    'registerds' => __CM__ . 'auth/registerds.php',
    'discordlink' => 'https://discord.com/',
    'genusername' => 'false',
    'token' => $token,
 
];

?>
