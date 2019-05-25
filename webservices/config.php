<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$keyId = 'rzp_test_EW4KZOHU49tAMN';
$keySecret = 'YL5JbIS20AJmP67AlPc3pW5r';
$displayCurrency = 'INR';
$serverName = 'localhost:3306';
$userName = 'root';
$passCode = '';
$dbName = 'cspace';
$tablename = "Users";
try { 
$conn = new mysqli($serverName, $userName, $passCode, $dbName);
} catch (Exception $e) { 
    throw $e; 
 } 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//These should be commented out in production
// This is for error reporting
// Add it to config.php to report any errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
