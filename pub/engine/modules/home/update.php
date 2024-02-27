<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";

$uuid = $_SESSION['uuid'];

$stmt = $conn->prepare("SELECT perm FROM users WHERE uuid = :uuid");
$stmt->bindParam(':uuid', $uuid);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$perm = $result['perm'];

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

  if ($perm < 2) {
      $imageInfo = getimagesize($file['tmp_name']);
      $imageWidth = $imageInfo[0];
      $imageHeight = $imageInfo[1];

      if ($imageWidth > 64 || $imageHeight > 64) {
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

header("Location: /home");