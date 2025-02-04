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
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";


function getUserInfoByToken($token) {

    try {
        require __CM__ . "inc/mysql.php";
        // Connect to the database using PDO

        // Prepare a SQL statement to fetch user information based on the token
        $sql = 'SELECT u.id AS id, u.perms
        FROM users_tokens ut
        JOIN users u ON u.id = ut.id
        WHERE ut.token = :userToken';

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userToken', $token);
        $stmt->execute();
        // Fetch the user information
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        // $pdo = null;

        // Check if user information is found
        if ($userInfo) {
            return $userInfo;
        } else {
            // User information not found
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        die("Database Connection Failed: " . $e->getMessage());
    }
}

// Example usage:


?>
