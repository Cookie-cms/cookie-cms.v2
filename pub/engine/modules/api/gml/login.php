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
// $yamlFilePath = __CM__ . 'configs/config.inc.yml';
require_once __CI__ . "yamlReader.php";
require __CM__ . "auth/ip_module.php";
require __CM__ . "inc/mysql.php";

$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);
$registrationstatus = $yaml_data['basic']['registration'];
$ip = $_SERVER['REMOTE_ADDR'];
function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
try {
    $username = isset($_POST['username']);
    $password = isset($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users_profiles WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($stmt->rowCount() < 0) {
        http_response_code(404);
        header('Content-Type: application/json');
        $responseData = array(
            'Login' => $username,
            'UserUuid' => $user['uuid'],
            'Message' => "User logged in successfully."
        );
        return json_encode($responseData, JSON_PRETTY_PRINT);
    }

    if ($user && password_verify($password, $user['password'])) {
        http_response_code(401);
        header('Content-Type: application/json');
        $responseData = array(
            'msg' => "Invalid username or password."
        );
        return json_encode($responseData, JSON_PRETTY_PRINT);
    } else {
        http_response_code(401);
        header('Content-Type: application/json');
        $responseData = array(
            'msg' => "Invalid username or password."
        );
        return json_encode($responseData, JSON_PRETTY_PRINT);
    }    
} catch (PDOException $e) {
    echo "error: An error occurred during login. error: " . $e->getMessage();
    error_log("error: PDOException: " . $e->getMessage(), 0);
    exit();
}
?>
