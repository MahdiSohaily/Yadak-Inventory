<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
global $con;
$con = mysqli_connect('localhost', 'root', '', 'yadakshop1402');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

// Create a PDO connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "yadakshop1402";

// Establish a database connection
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  define('PDO_CONNECTION', $pdo);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit();
}



mysqli_set_charset($con, "utf8");
require_once 'jdf.php';
