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
// error_reporting(E_ALL);  
// ini_set('display_errors', true);
// session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";



function getUsernameByUUID($conn, $uuid) {
    try {
        $stmt = $conn->prepare("SELECT username FROM users_profiles WHERE uuid = :uuid");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->execute();
        $fetchedUser = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($fetchedUser) ? $fetchedUser['username'] : null;
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        return null;
    } catch (Exception $e) {
        error_log("General Error: " . $e->getMessage());
        return null;
    }
}

?>