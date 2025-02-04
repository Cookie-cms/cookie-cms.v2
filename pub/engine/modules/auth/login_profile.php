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
session_start(); 
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    // echo "Received Username: " . $username . "<br>";
    // echo "Received Password: " . $password . "<br>";

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE BINARY username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Debug: Output fetched user data
        // echo "Fetched User Data: ";
        // var_dump($user); // 

        if ($user && password_verify($password, $user['password']) && $user['username'] === $username) {
            var_dump($user); // Placed here to dump the user data
            $_SESSION['id'] = $user['id'];
            $_SESSION['uuid'] = $user['uuid'];
            // echo "Session created!";
            
            $home = "/home";
            header("Location: $home");
            var_dump($user);
            // exit();
        } else {
            echo "Incorrect User name or password";
            // Redirect or handle incorrect login attempt here
        }
    } catch(PDOException $e) {
        // Output detailed error information for debugging
        echo "Error: " . $e->getMessage();
        // Log the error to a file or error tracking system for further investigation
        // You can use error_log or a dedicated logging library
        error_log("Database Error: " . $e->getMessage(), 0);
        // Redirect to an error page or display a generic error message for the user
        header("Location: error.php");
        exit();
    }
} else {
    // Handling if username or password is not set in POST data
    // echo "Error: Username or password not provided";
    // Log this error as well for further investigation
    // error_log("Username or password not provided", 0);
    // Redirect to an error page or display a generic error message for the user
    // header("Location: error.php");
    // exit();
}
?>