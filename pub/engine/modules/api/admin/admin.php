<?php
// session_start();
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
error_reporting(E_ALL);
ini_set('display_errors', true);

$type = __URL__[1];
echo $type;

if (isset(__URL__[2])) {
    if (__URL__[2] == 'st') {
        // Get the URI parameters
        $type2 = __URL__[2];
        echo $type2;

        $uriParameters = http_build_query($_GET);

        // Use absolute path for inclusion with URI parameters
        $moduleFilePath = __CD__ . "modules/api/admin/st_engine.php";

        // Check if the file exists before including
        if (file_exists($moduleFilePath)) {
            include $moduleFilePath;
        } else {
            // Handle the case where the file doesn't exist
            die("Module file not found.");
        }
    }
}
?>
