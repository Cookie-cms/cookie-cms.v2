<?php
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
