<?php
require_once __DEF__;
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require __CM__ . "inc/mysql.php";

require __CM__ . "home/main.php";

$loggeds = "";
$avatarUrlDS = "";

$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . "$icon",
    'bootstrapcss' => "$bootstrapcss",
    'bootstrapjs' => "$bootstrapjs",
    'bootstrapicons' => "$bootstrapicons",
    'assets' => __TDS__ . 'assets/background.jpg',
    'description' => 'Minecraft project with launcher x)',
    'maincss' => __CSS__ . 'style3.css',
    // 'avatarUrl' => "$avatarUrl",
    'js' => __TDS__ . "js/index.js",

    // 'logged' => "$logged",
    
];
$id = $result['id'];
$stmt = $conn->prepare("SELECT * FROM audit");
$stmt->execute();
$audit = $stmt->fetchAll(PDO::FETCH_ASSOC);

var_dump($audit);
// ob_start(); // Start output buffering



// $listContent = ob_get_clean(); // Get the content and clear the buffer

// // Add $listContent to the $variables array
// $variables = isset($variables) && is_array($variables) ? $variables : [];
// $variables['cape'] = $listContent;
?>