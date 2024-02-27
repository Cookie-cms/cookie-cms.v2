<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";

$owner= $_SESSION['id'];
$stmt = $conn->prepare("SELECT username, uuid FROM users_profiles WHERE BINARY owner = :owner");
$stmt->bindParam(':owner', $owner); // Replace $owner with the actual value you want to match
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!isset($_SESSION['id'])) {
    header("Location: /");
     exit();
}
// var_dump($users);

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
];

// Generate $listContent dynamically
ob_start(); // Start output buffering

foreach ($users as $item): ?>
        <a href="/home?user=<?= $item['uuid'] ?>" class="list-group-item list-group-item-action">
            <img class="rounded" src="http://192.168.1.85/api.php?module=skin&type=extra&size=50&uuid=<?= $item['uuid'] ?>&mode=3" alt="<?= $item['username'] ?>">
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
$username = $_COOKIE['show'];
    echo $username;
?>
