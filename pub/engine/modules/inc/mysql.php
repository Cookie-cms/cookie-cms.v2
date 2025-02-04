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
// $yamlFilePath = __CM__ . 'configs/config.inc.yml';
require_once __CI__ . "yamlReader.php";

$file_path = __CM__ . 'configs/config.inc.yaml';
$yaml_data = read_yaml($file_path);

// echo($file_path);
// Access the 'database' section
$databaseConfig = $yaml_data['database'];

// var_dump($databaseConfig);
// Access specific values
$host = $databaseConfig['host'];
$username = $databaseConfig['username'];
$password = $databaseConfig['pass'];
$database = $databaseConfig['db'];
$port = $databaseConfig['port'];

try {
   $conn = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
   // Perform database operations using $pdo
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   die("Connection failed: " . $e->getMessage());

}

// print_r($array);
?>
