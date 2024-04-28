<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/define.php";

require __CM__ . "mail/sendmail.php";

// if (!isset($_SESSION['id'])) {
$email = "misha.lebedev.kiev@gmail.com";
$accountid = 0;
$date = "1714249339";
$username = null;
$test = welcomemsg($email, $accountid, $date, $username);