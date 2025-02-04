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
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";
require __CM__ . "inc/checkperms.php";
if (!isset($_SESSION['id'])) {
    header("Location: /");
     exit();
}

$owner = $_SESSION['id'];
if ($_POST['uuid']) {    // Select the row where default is 1 and owner matches the session ID
    $uuid = $_POST['uuid'];
// Remove unnecessary closing curly braces
} else {

    $stmt = $conn->prepare("SELECT id, username, uuid, `default`, owner FROM users_profiles WHERE `default` = 1 AND BINARY owner = :owner");
    $stmt->bindParam(':owner', $owner);
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($resultr);
    $uuid = $result['uuid'];
}
// $iduser = $result['id'];
// $permissions = getUserPermissionsByUUID($uuid, $conn);
// echo "UUID: $uuid. Permission level: $perm.";

// if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
    $new_password = trim($_POST['new_password']);
    $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

    echo "New password received.";
 

    $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :owner");
    $stmt->bindValue(':password', $new_password_hashed);
    $stmt->bindValue(':owner', $owner);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE users_profiles SET password = :password WHERE owner = :owner");
    $stmt->bindValue(':password', $new_password_hashed);
    $stmt->bindValue(':owner', $owner);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO audit (user, timestamp, action) VALUES (:user, :timestamp, :action)");
    $stmt->bindValue(':user', $owner);
    $stmt->bindValue(':timestamp', time(), PDO::PARAM_INT);
    $stmt->bindValue(':action', "Password changed by user.");
    $stmt->execute();
    // echo "Password updated.";
// }

// header("Location: /home");
