<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);
require_once __DEF__;
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require __CM__ . "inc/mysql.php";

require __CM__ . "home/main.php";

require __CM__ . "inc/checkperms.php";

// if (isset($_SESSION['uuid'])) {
    
//     $f = $_SESSION['uuid'];
//     $avatarUrl = "http://192.168.1.85/api?module=skin&type=extra&uuid=$f&size=100&mode=3";

// }
if (isset($_SESSION['user_data'])) {
    $loggeds = "true";
    $userData = $_SESSION['user_data'];
    $avatarUrlDS = "https://cdn.discordapp.com/avatars/{$userData['id']}/{$userData['avatar']}.png";
    // echo($avatarUrl);
}
if (isset(__URL__[1])) {
    $uuid = __URL__[1];
    $owner = $_SESSION['id'];
    echo($uuid);
    // Select the row where owner matches and username is equal to the provided user
    $stmt = $conn->prepare("SELECT username, uuid, `default`, owner FROM users_profiles WHERE BINARY owner = :owner AND BINARY uuid = :uuid");
    $stmt->bindParam(':owner', $owner);
    $stmt->bindParam(':uuid', $uuid);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($result);
    if (!$result) {

        // The user provided in 'user' doesn't match the owner in the database
        // Redirect the user to another page
        header("Location: /home");
        exit();
    }
    $a = $result['uuid']; 

    $playername = getUsernameByUUID($conn, $a);     
} else {
    $owner = $_SESSION['id'];
    // echo($owner);
    // Select the row where default is 1 and owner matches the session ID
    $stmt = $conn->prepare("SELECT id, username, uuid, `default`, owner, id FROM users_profiles WHERE `default` = 1 AND BINARY owner = :owner");
    $stmt->bindParam(':owner', $owner);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($resultr);
    $uuid = $result['uuid'];
    $profileId = $result['id'];
    $playername = getUsernameByUUID($conn, $uuid);
    // echo($a);
    // echo($playername);
}

$playername = getUsernameByUUID($conn, $uuid);


if (!isset($_SESSION['id'])) {
    header("Location: /");
     exit();
}
// exit();

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
    'uuid' => "$uuid",
    'username' => "$playername",
    // 'logged' => "$logged",
    
];

if (isset($_GET['update'])) {
    $playername = getUsernameByUUID($conn, $uuid);
    $variables['username'] = $playername;
} 

$permissions = GetProfilePermissions($profileId, $conn);
// var_dump($permissions); 


foreach ($permissions as $permission) {
    $parts = explode('.', $permission);

    if (count($parts) < 4) {
        // The permission string does not have four parts
        // Handle this case as needed
        continue;
    }

    $namePart = $parts[2]; // Get the name part
    $intPart = $parts[3]; // Get the int part

    if ($parts[0] == "profile" && $parts[1] == "cape" && ($namePart == "*" || $intPart == "*" || $intPart == $profileId)) {
        // The permission string follows the format "profile.cape.{name/*}.{int/*}"
        if ($namePart == "*") {
            // If name is "*", fetch all capes
            $stmt = $conn->prepare("SELECT * FROM cloaks");
        } else {
            // If name is not "*", fetch capes with the specific name
            $stmt = $conn->prepare("SELECT * FROM cloaks");
            $stmt->bindParam(':name', $namePart);
        }
        $stmt->execute();
        $capes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}}

$sql = 'SELECT s.`cape`
    FROM `users_profiles` u
    LEFT JOIN `skins` s ON s.`uuid` = u.`uuid`
    WHERE u.`uuid` = :uuid';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
$stmt->execute();
$c = $stmt->fetch(PDO::FETCH_OBJ);
ob_start(); // Start output buffering 
?>
    <input type="hidden" name="uuid" id="uuid" value="<?php echo $uuid?>">

<?php foreach ($capes as $cape): ?>
    <img src="api/skin/cloakview/<?php echo $cape['cloak']; ?>/2/128">
    <button type="submit" class="btn btn-primary" name="setcloak" value="<?=$cape['id']?>" <?=$cape['id']==$c->cape?'disabled':''?>>set</button>
<?php endforeach; ?>

<?php
$cape = ob_get_clean(); // Get the content and clear the buffer
$variables['cape'] = $cape;

ob_start(); // Start output buffering 
?>
<form method="post" id="rmcape">

<input type="hidden" name="uuid" id="uuid" value="<?php echo $uuid?>">
<button type="submit" class="btn btn-danger" name="setcloak" value="0" >reset</button>

</form>

<?php
$capereset = ob_get_clean(); // Get the content and clear the buffer
$variables['capereset'] = $capereset;
// Remove the closing PHP tag
