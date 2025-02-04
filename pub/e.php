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
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";
require_once __ven__;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Load the private key
$privateKey = file_get_contents(__DIR__ ."/key.pem");
$publicKey = file_get_contents(__DIR__ ."/public_key.pem");
// echo $privateKey;
// Your payload data
$payload = [
    'iss' => 'example.org',
    'aud' => 'example.com',
    'iat' => time(), // Current timestamp
    'nbf' => time(), // Not before
    'exp' => time() + 60 // Expiration time, e.g., 1 hour from now
];

// $jwt = JWT::encode($payload, $privateKey, 'RS256');
// echo "Encode:\n" . print_r($jwt, true) . "\n";
// echo $jwt;

function validate_jwt($jwt) {
    try {
        // Load RSA public key
        $publicKey = file_get_contents(__DIR__ ."/public_key.pem");
        
        // Decode the JWT
        $decoded = JWT::decode($jwt, new Key($publicKey, 'RS256'));

        // Convert the decoded data to an array
        $decoded_array = (array) $decoded;
        
        // Return the decoded data
        return $decoded_array;
    } catch (ExpiredException $e) {
        // Handle expired token
        return ['error' => 'Token has expired'];
    } catch (Exception $e) {
        // Handle other exceptions
        return ['error' => $e->getMessage()];
    }
}

// Example JWT token
$jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJleGFtcGxlLm9yZyIsImF1ZCI6ImV4YW1wbGUuY29tIiwiaWF0IjoxNzE2MjAzNzM1LCJuYmYiOjE3MTYyMDM3MzUsImV4cCI6MTcxNjIwMzc5NX0.jl4XYlnT4vuFuOFienleeC3tJ-X3-MzYEnF8H9_7dORURVn6OP-s1pLU8n9Ia53gmBzWsUJvumfYCu_HHBVQ8I6JycCAusedAcT15enhyNTX1vNEddjw7Mnt-eZZhbgd6Xh3pI1a8y9frKOyfjU2tAXB2Pl-5DQ7LJQ1s3wRo9TEAbjE0VX7dMunYOGO2KQmPKhBscRd1Mp58lv8oBBq-MU_WKbBcViACPzRXvZR-M84kIZcFSUpsm7ZlctINERvmPYHHaNTVGSXIjUMDFvsyNgKEGbBb5MOTgoEcYEgD8iqk2ztoJjePysr9tXwZAhue70b-l9Z6rRRmKQS_dDWFg";

// Validate the JWT token
$result = validate_jwt($jwt);

// Output the result
print_r("Validation result: $result") ;

?>
