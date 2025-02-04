<?php
# This file is part of CookieCms.
#
# CookieCms is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# CookieCms is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with CookieCms. If not, see <http://www.gnu.org/licenses/>.
require_once __DEF__;
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require __CM__ . "inc/mysql.php";

require __CM__ . "home/main.php";


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
$stmt = $conn->prepare("SELECT id, dsid FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($audit);
ob_start(); // sssStart output buffering
?>

<?php foreach ($users as $user): ?>
    <tr onclick="toggleAccordion(this)" id="<?php echo $user['id']; ?>">
        <td><?php echo $user['id']; ?></th>
        <td><?php echo $user['dsid']; ?></td>
    </tr>
<?php endforeach; ?>

<?php
$listContent = ob_get_clean(); // Get the content and clear the buffer

// Add $listContent to the $variables array
$variables = isset($variables) && is_array($variables) ? $variables : [];
$variables['list'] = $listContent;
?>