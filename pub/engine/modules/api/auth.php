<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once __ven__;
//  Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
    header('Content-Type: application/json');
    $responseData = array(
        'error' => true,
        'msg' => 'Sorry. You are not allowed to access this page.'
    );
    die(json_encode($responseData, JSON_PRETTY_PRINT));
}

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function validate_jwt($jwt) {
    try {
        // Load RSA public key
        $publicKey = file_get_contents(__DIR__ ."/public_key.pem");
        
        // Decode the JWT
        $decoded = JWT::decode($jwt, new Key($publicKey, 'RS256'));

        // Convert the decoded data to an array
        $decoded_array = (array) $decoded;
        
        // Check if the token has expired
        $currentTimestamp = time();
        if (isset($decoded_array['exp']) && $decoded_array['exp'] < $currentTimestamp) {
            return ['error' => 'Token has expired'];
        }
        
        // Token is valid, return decoded data
        return $decoded_array;
    } catch (Exception $e) {
        // If an exception occurs during JWT decoding, return error
        return ['error' => $e->getMessage()];
    }
}

?>
