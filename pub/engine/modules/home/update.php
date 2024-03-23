<?php
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
$iduser = $result['id'];
$permissions = getUserPermissionsByUUID($uuid, $conn);
// echo "UUID: $uuid. Permission level: $perm.";

if (isset($_POST['new_username']) && !empty($_POST['new_username'])) {
    $new_username = trim(filter_var($_POST['new_username']));

    // echo "New username: $new_username.";

    $stmt = $conn->prepare("UPDATE users SET username = :username WHERE uuid = :uuid");
    $stmt->bindValue(':username', $new_username);
    $stmt->bindValue(':uuid', $uuid);
    $stmt->execute();

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
  
    $mimeType = getimagesize($file['tmp_name'])['mime'];
    if ($mimeType !== 'image/png') {
        die("Invalid file type. Only PNG allowed.");
    }
  
    if (!in_array("skin.hd", $permissions) && !in_array("*", $permissions)) {
        $imageInfo = getimagesize($file['tmp_name']);
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];

        if ($imageWidth > 64 || $imageHeight > 64) {
            echo $permissions[0];
            die("Image dimensions exceed 64x64 pixels for this permission level.");
        }
    }
  
    
    $imageName = $uuid . ".png";
  
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/skins/" . $imageName;
  
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        echo "File uploaded successfully. UUID: $uuid";
  
  
    } else {
        die("Failed to upload file.");
    }
  }

if (isset($_POST['setcloak'])) {
    $cloak = (int)$_POST['setcloak'];

    echo "Cloak: $cloak.";
    if ($cloak === 0) {
        $stmt = $conn->prepare('UPDATE `cape_users` SET `cid` = NULL WHERE `uid` = :uid');
        $stmt->bindValue(':uid', $iduser);
        $stmt->execute();
    }
        // $stmt = $conn->prepare('SELECT * FROM `cloaks` WHERE `uid` = :uid AND `id` = :id');
        // $stmt->bindValue(':uid', $iduser);
        // $stmt->bindValue(':id', $cloak);
        // $stmt->execute();
        // $cloak = $stmt->fetch(PDO::FETCH_ASSOC);

        // if (!$cloak) {
        //     header('Location: /error/19');
        //     exit();
        // }

        // $stmt = $conn->prepare('DELETE FROM `users_cloaks` WHERE `uid` = :uid');
        // $stmt->bindValue(':uid', $user->id);
        // $stmt->execute();

        // $stmt = $conn->prepare('INSERT INTO `users_cloaks` (`uid`, `cid`) VALUES (:uid, :cid)');
        // $stmt->bindValue(':uid', $user->id);
        // $stmt->bindValue(':cid', $cloak['id']);
        // $stmt->execute();

        $stmt = $conn->prepare('UPDATE `cape_users` SET `cid` = :cid WHERE `uid` = :uid');
        $stmt->bindValue(':uid', $iduser);
        $stmt->bindValue(':cid', $cloak);
        $stmt->execute();;


    

    // header("Location: /home");

    // exit();
}
header("Location: /home");
