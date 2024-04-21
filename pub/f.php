<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "inc/mysql.php";
require __CM__ . "inc/checkperms.php";
// if (!isset($_SESSION['id'])) {

$userId = 0;

$perms = getUserPermissions($userId, $conn);
var_dump($perms);