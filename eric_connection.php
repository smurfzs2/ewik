<?php
$_GET['country'] = isset($_GET['country']) ? $_GET['country'] : "1"; //1 - Philippines, 2 - japan
session_start(); 
date_default_timezone_set('Asia/Manila');

$DBServer = 'localhost';
$DBUser   = 'root';
$DBPass   = 'arktechdb';
$DBName   = 'testDatabase';

$db = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
$db->set_charset("utf8");
 
// check connection
if ($db->connect_error) {
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}
