<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
// require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
// require_once __CM__ . "inc/mysql.php";
// require_once __CM__ . "modules/api/verifytoken_profile.php";

// Assuming $token is defined before this point

// Validate the token
$userInfo = verifyToken($token, $conn);

if ($userInfo !== false) {
    // Token is valid, and user information is available
    // var_dump($userInfo['perms']);
    var_dump($userInfo);
} else {
    // Token is invalid or user information not found
    http_response_code(401); // Unauthorized
    echo "Invalid token.";
    exit;
}

// Rest of your code
?>
