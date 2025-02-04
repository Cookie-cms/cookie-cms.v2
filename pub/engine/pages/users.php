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