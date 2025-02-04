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
