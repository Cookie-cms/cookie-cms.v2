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
ini_set('session.cookie_lifetime', 86400);
session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require __CM__ . "inc/mysql.php";
require __CM__ . "inc/discordlink.php";

if (!isset($_SESSION['user_data']['id'])) {
    $url = generate_url();
    header("Location: $url");
    exit;
}

$dsid = $_SESSION['user_data']['id'];

try {
    $stmt = $conn->prepare("SELECT id FROM users WHERE dsid = :dsid");
    $stmt->bindParam(':dsid', $dsid);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['id'] = $user['id'];
        // $_SESSION['uuid'] = $user['uuid'];
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /");
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
