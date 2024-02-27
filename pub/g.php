<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
require 'vendor/autoload.php'; // Include the JWT library

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
// Your secret key (keep it secret and secure)
$secretKey = 'your_secret_key';

// Function to verify and decode a JWT token
function verifyToken($token) {
    global $secretKey;

    try {
        // Decode the token without passing $headers by reference
        $decoded = $data = JWT::decode($token, new Key($secretKey, 'HS256'));

        // Convert the decoded JSON to an associative array
        $decodedArray = json_decode(json_encode($decoded), true);

        return $decodedArray;
    } catch (Exception $e) {
        // JWT validation failed
        return null;
    }
}

// Check if the Authorization header is present
if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];

    // Extract the token from the Authorization header
    $clientToken = str_replace('Bearer ', '', $authHeader);

    // Verify the token
    $decodedToken = verifyToken($clientToken);

    if ($decodedToken) {
        // Token is valid
        echo json_encode(array("valid" => true, "decoded" => $decodedToken));
    } else {
        // Token validation failed
        echo json_encode(array("valid" => false));
    }
} else {
    // Authorization header not present
    echo json_encode(array("valid" => false, "message" => "Authorization header not found"));
}
?>
