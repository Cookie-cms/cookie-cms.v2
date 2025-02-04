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
error_reporting(E_ALL);
ini_set('display_errors', true);
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once __CM__ . "inc/mysql.php";

function verifyToken($token, $conn) {
    try {
        // Connect to the database using PDO
        // $token = "1111-1111";
        
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

        // Check if user information is found
        if ($userInfo) {
            return $userInfo;
        } else {
            // User information not found
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        http_response_code(500); // Internal Server Error
        echo "Database Connection Failed: " . $e->getMessage();
        exit;
    }
}

// Example usage:
// $userInfo = verifyToken($token, $conn);

// Rest of your code
?>
