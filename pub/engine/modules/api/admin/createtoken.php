<?php
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
