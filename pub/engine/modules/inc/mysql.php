<?php
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
