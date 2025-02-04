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

$code = $_POST['code'];

$permissions = GetProfilePermissions($profileId, $conn);

if ($_POST['type']= "mailverify") {
    $stmt = $conn->prepare("SELECT mail_verify FROM users WHERE id = :userid");
    $stmt->bindParam(':userid', $owner);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['mail_verify'] == 1) {

        $stmt = $conn->prepare("SELECT * FROM mail_codes WHERE userid = :userid AND code = :code"); 
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':code', $code);
        $stmt->execute();   

        if ($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("UPDATE users SET mail_verify = 1 WHERE id = :userid");
            $stmt->bindParam(':userid', $owner);
            $stmt->execute();
            $stmt = $conn->prepare("DELETE FROM mail_codes WHERE userid = :userid");
            $stmt->bindParam(':userid', $owner);
            $stmt->execute();
            $responseData = array(
                'error' => false,
                'msg' => 'Your account has been verified.'
            );
            echo(json_encode($responseData, JSON_PRETTY_PRINT));
            sleep(2);
            header('Location: /');
            exit();
        } else {
            $responseData = array(
                'error' => true,
                'msg' => 'Invalid code.'
            );
            die(json_encode($responseData, JSON_PRETTY_PRINT));
        }
    } else {
        $responseData = array(
            'error' => true,
            'msg' => 'Your account is already verified.'
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    }
}

if ($_POST['type']= 'coupon') {
    die('Coupon code');
}

if ($_POST['type']= 'reffal') {
    die('Reffal code');
}