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
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
// $yamlFilePath = __CM__ . 'configs/config.inc.yml';
require_once __CI__ . "yamlReader.php";
require __CM__ . "inc/mysql.php";

$file_path = __CM__ . 'configs/template.yaml';
$yaml_data = read_yaml($file_path);


$projectname = $yaml_data['projectname'];
$icon = $yaml_data['icon'];
$bootstrapcss = __CSS__ . "bootstrap.css";
$bootstrapjs = __JS__ . "bootstrap.bundle.js";
$bootstrapicons = $yaml_data['bootstrapicons'];
$jquery = $yaml_data['icon'];
$indexdescription = $yaml_data['indexdescription'];
$navvbarpic = $yaml_data['navvbarpic'];
$snow = $yaml_data['snow'];

$ConfigFilePath = __CM__ . 'configs/config.inc.yaml';
$CFPyaml_data = read_yaml($ConfigFilePath);


if ($CFPyaml_data['basic']['ssl'] ==  true) {
    $urlicon = "https://" . $CFPyaml_data['basic']['domain'] . __TDS__ . "$icon";
} else {
    $urlicon = "http://" . $CFPyaml_data['basic']['domain'] . __TDS__ . "$icon";
}
if (isset($_SESSION['id'])){
    $session = true;
} else {
    $session = false;
}
$stmt = $conn->prepare("SELECT username, uuid FROM users_profiles WHERE BINARY owner = :owner");
$stmt->bindParam(':owner', $_SESSION['id']); // Replace $owner with the actual value you want to match
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
ob_start(); // Start output buffering

foreach ($users as $item): ?>
        <li><a class="dropdown-item" href="/home?user=<?= $item['uuid'] ?>"><?= $item['username'] ?></a></li>

<?php endforeach; ?>


<?php

$profiles = ob_get_clean(); // Get the content and clear the buffer

// Add $listContent to the $variables array

?>
