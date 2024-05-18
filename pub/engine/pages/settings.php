<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";
require __CM__ . "inc/checkperms.php";

$owner= $_SESSION['id'];

$stmt = $conn->prepare("SELECT mail, dsid, mail_verify FROM users WHERE BINARY id = :owner");
$stmt->bindParam(':owner', $owner); // Replace $owner with the actual value you want to match
$stmt->execute();

$ownerinfo = $stmt->fetch(PDO::FETCH_ASSOC);
$ownermail = $ownerinfo['mail'] ?? "Not found";
$ownerds = $ownerinfo['dsid'];
if ($ownerinfo['mail_verify'] !== "0") {
    $mailverify = true;
} else {
    $mailverify = false;
}

$stmt = $conn->prepare("SELECT username, uuid FROM users_profiles WHERE BINARY owner = :owner");
$stmt->bindParam(':owner', $owner); // Replace $owner with the actual value you want to match
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!isset($_SESSION['id'])) {
    header("Location: /");
     exit();
}
// var_dump($users);
if(isset($_COOKIE["show"])) {
    $cookieValue = $_COOKIE["show"];
    unset($_COOKIE['show']);
    setcookie('show', null, -1, '/');
    echo $cookieValue;
}
$locked = true;
// echo $locked;https://www.youtube.com/shorts/xgtkV1FkoSs?si=jXP52AgPa3vAmSBvhttps://www.youtube.com/shorts/xgtkV1FkoSs?si=jXP52AgPa3vAmSBv
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
    'mail' => "$ownermail",
    'dsid' => "$ownerds",
    'mailverify' => "$mailverify",
    'locked' => "$locked",

];
// $userId = $_SESSION['id'];
// $permissions = getUserPermissions($userId, $accountId = 0, $conn);
// var_dump($permissions);
// Generate $listContent dynamically
ob_start(); // Start output buffering

foreach ($users as $item): ?>
        <a href="/home?user=<?= $item['uuid'] ?>" class="list-group-item list-group-item-action">
            <img class="rounded" src="http://cookiecms.local/api/skins/extra/<?= $item['uuid'] ?>/?mode=3&size=50" alt="<?= $item['username'] ?>">
            <?= $item['username'] ?>
        </a>

<?php endforeach; ?>
<a hrefu="" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#myModal">
<i class="bi bi-plus" style="font-size: 2rem; color: cornflowerblue;"></i> ADD ACCOUNT
        </a>

<?php

$listContent = ob_get_clean(); // Get the content and clear the buffer

// Add $listContent to the $variables array
$variables['list'] = $listContent;
// $username = $_COOKIE['show'];
    // echo $username;
?>

