<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);
require_once __DEF__;
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require __CM__ . "inc/mysql.php";

require __CM__ . "home/main.php";

$loggeds = "";
$avatarUrlDS = "";

// $a = $_SESSION['uuid'];



$variables = [
    'Projectname' => "$projectname",
    'icon' => __TDS__ . "$icon",
    'bootstrapcss' => "$bootstrapcss",
    'bootstrapjs' => "$bootstrapjs",
    'bootstrapicons' => "$bootstrapicons",
    'assets' => __TDS__ . 'assets/background.jpg',
    'description' => 'Minecraft project with launcher x)',
    'maincss' => __CSS__ . 'main.css',
    'avatarUrlds' => "$avatarUrlDS",
    // 'avatarUrl' => "$avatarUrl",
    'skinjs' => __TDS__ . "js/skinview3d.bundle.js",
    'uuid' => "$a",
    'username' => "$playername",
    // 'logged' => "$logged",
    
];

$id = $result['id'];
$stmt = $conn->prepare("SELECT * FROM audit");
$stmt->execute();
$audit = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($audit);
ob_start(); // sssStart output buffering
?>

<?php foreach ($audit as $entry): ?>
    <tr>
        <td><?php echo $entry['id']; ?></th>
        <td><?php echo date('H:i d.m.Y', $entry['timestamp']); ?></td>
        <td><?php echo $entry['user']; ?></td>
        <td><?php echo $entry['action']; ?></td>
    </tr>
<?php endforeach; ?>
<?php
$listContent = ob_get_clean(); // Get the content and clear the buffer

// Add $listContent to the $variables array
$variables = isset($variables) && is_array($variables) ? $variables : [];
$variables['list'] = $listContent;
?>