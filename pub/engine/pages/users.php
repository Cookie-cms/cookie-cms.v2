<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";
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
    'avatarUrlds' => "$avatarUrlDS",
    'avatarUrl' => "$avatarUrl",
    't' => "$requestUri",
    'logged' => "$loggeds",
];


ob_start(); // Start output buffering

$stmt = $conn->prepare("SELECT id, username, uuid FROM users_profiles");
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $item): ?>
        <tr>
            <td><?=$item['id']?></td>
            <td><a href="/users/<?=$item['uuid']?>/"><img src="http://cookiecms.local/api/skinview/extra/<?=$item['uuid']?>/?mode=3&size=50" class="avatar rounded" alt="Avatar"> <?=$item['username']?></a></td>
            <td>12/08/2017</td>                        
            <!-- <td><span class="status text-warning">&bull;</span> Inactive</td> -->
            <!-- <td>
                <a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
            </td> -->
        </tr>

<?php endforeach; ?>

<?php

$listContent = ob_get_clean(); // Get the content and clear the buffer

// Add $listContent to the $variables array
$variables['list'] = $listContent;


?>