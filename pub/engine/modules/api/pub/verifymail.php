<?php
	error_reporting(E_ALL);
    ini_set('display_errors', true);// Функции с плащами пока вырезаны
    require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";

$code = $_GET['code'];

echo($code);