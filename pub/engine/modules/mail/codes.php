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
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

// if (!isset($_POST['code'])) {
    $url = $_POST['url'];
    $code = $_POST['code'];
    require __CM__ . "inc/mysql.php";

    $stmt = $conn->prepare("SELECT userid FROM verify_codes WHERE url = :url");
    $stmt->bindParam(':url', $url);
    $stmt->execute();   
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($code, $result['code'])) {
        $stmt = $conn->prepare("UPDATE users SET mail_verify = 1 WHERE id = :userid");
        $stmt->bindParam(':userid', $result['userid']);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM verify_codes WHERE url = :url");
        $stmt->bindParam(':url', $url);
        $stmt->execute();
        echo "Account verified!";
    } else {
        echo "Invalid code!";
    }   
    // } else {
        // echo "No code provided!";
    // }
    