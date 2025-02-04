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
// if (!isset($_SESSION['id'])) {
//     header("Location: /");
//      exit();
// }
// $uuid = $_SESSION['uuid'];

// $stmt = $conn->prepare("SELECT perm FROM users WHERE uuid = :uuid");
// $stmt->bindParam(':uuid', $uuid);
// $stmt->execute();
// $result = $stmt->fetch(PDO::FETCH_ASSOC);
// $perm = $result['perm'];
$owner = $_SESSION['id'];

    // Select the row where default is 1 and owner matches the session ID
$stmt = $conn->prepare("SELECT id, username, uuid, `default`, owner FROM users_profiles WHERE `default` = 1 AND BINARY owner = :owner");
$stmt->bindParam(':owner', $owner);
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($resultr);
$uuid = $result['uuid'];
$profileId = $result['id'];
// echo "UUID: $uuid. Profile ID: $profileId.";
$permissions = GetProfilePermissions($profileId, $conn);
if (isset($_POST['new_username']) && !empty($_POST['new_username'])) {
    $new_username = trim(filter_var($_POST['new_username']));
    // Remove all non-alphanumeric characters
    $new_username = preg_replace("/[^A-Za-z0-9]/", '', $new_username);
    if ($new_username === "") {
        header('Content-Type: application/json');
        $responseData = array(
            'error' => true,
            'msg' => 'Invalid username format.'
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    }
    // echo "New username: $new_username.";
    try {
        $stmt = $conn->prepare("SELECT username FROM users_profiles WHERE username = :username");
        $stmt->bindParam(':username', $new_username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            
            die(msgdisplay(true, "Username already exists."));
        } else {
            $stmt = $conn->prepare("UPDATE users_profiles SET username = :username WHERE uuid = :uuid");
            $stmt->bindValue(':username', $new_username);
            $stmt->bindValue(':uuid', $uuid);
            $stmt->execute();
            header('Content-Type: application/json');
            $responseData = array(
                'error' => false,
                'msg' => 'Username updated.'
            );
            echo json_encode($responseData, JSON_PRETTY_PRINT);
        }
    } catch (Exception $e) {
        header('Content-Type: application/json');

        $responseData = array(
            'error' => true,
            'msg' => $e->getMessage()
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    } 
        
    
    

    // echo "Username updated.";
}

if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
    $new_password = trim($_POST['new_password']);
    $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

    // echo "New password received.";

    $stmt = $conn->prepare("UPDATE users SET password = :password WHERE uuid = :uuid");
    $stmt->bindValue(':password', $new_password_hashed);
    $stmt->bindValue(':uuid', $uuid);
    $stmt->execute();

    // echo "Password updated.";
}

// Handle skin upload
if (isset($_FILES['new_skin']) && !empty($_FILES['new_skin']['name'])) {

    $file = $_FILES['new_skin'];
  
    
    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        header('Content-Type: application/json');

        $responseData = array(
            'error' => true,
            'msg' => 'Invalid file type. Only PNG allowed.'
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    }

    $mimeType = $imageInfo['mime'];
    if ($mimeType !== 'image/png') {
        die("Invalid file type. Only PNG allowed.");
    }

    

    $permissionToCheck = "profile.hdskin." . $profileId;
    if (!in_array($permissionToCheck, $permissions) && !in_array("profile.hdskin.*", $permissions)) {
        $imageInfo = getimagesize($file['tmp_name']);
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];

        if ($imageWidth > 64 || $imageHeight > 64) {
            header('Content-Type: application/json');

            $responseData = array(
                'error' => true,
                'msg' => 'Image dimensions exceed 64x64 pixels for this permission level.'
            );
            die(json_encode($responseData, JSON_PRETTY_PRINT));
        }
    }

    

  
    
    $imageName = $uuid . ".png";
  
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/" . $imageName;
  
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            header('Content-Type: application/json');

            $responseData = array(
                'error' => false,
                'msg' => 'Skin uploaded successfully.'
            );
            echo json_encode($responseData, JSON_PRETTY_PRINT);
  
  
    } else {
        $responseData = array(
            'error' => true,
            'msg' => 'An error occurred while uploading the skin.'
        );
        die(json_encode($responseData, JSON_PRETTY_PRINT));
    }
  }

if (isset($_POST['setcloak'])) {
    $cloak = (int)$_POST['setcloak'];
    $user_id = $_POST['uuid'];
    if ($cloak === 0) { // Use strict comparison and correct assignment operator
        try {
            $stmt = $conn->prepare('UPDATE `skins` SET `cape` = NULL WHERE `uuid` = :uuid');
            $stmt->bindValue(':uuid', $user_id);
            $stmt->execute();
            $responseData = array(
                'error' => false,
                'msg' => "Cape removed successfully."
            );
            echo json_encode($responseData, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $responseData = array(
                'error' => true,
                'msg' => $e->getMessage()
            );
            die(json_encode($responseData, JSON_PRETTY_PRINT));
        }
    } else {
        try {
            $stmt = $conn->prepare('UPDATE `skins` SET `cape` = :cid WHERE `uuid` = :uuid');
            $stmt->bindValue(':uuid', $user_id);
            $stmt->bindValue(':cid', $cloak);
            $stmt->execute(); // Remove unnecessary semicolon
            $responseData = array(
                'error' => false,
                'msg' => "Cape set successfully."
            );
            echo json_encode($responseData, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $responseData = array(
                'error' => true,
                'msg' => $e->getMessage()
            );
            die(json_encode($responseData, JSON_PRETTY_PRINT));
        }
    }
}
