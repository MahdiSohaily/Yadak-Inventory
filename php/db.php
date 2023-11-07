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

function log_action($file, $query, $user)
{
  $logFile = "../logs/$file.txt"; // Define the log file name or path

  // Get the current date and time
  $timestamp = date('Y-m-d H:i:s');

  // Create a log entry
  $logEntry = "[$timestamp] Action: $query, User:" . $user . "\n";

  // Open or create the log file in append mode
  $file = fopen($logFile, 'a');

  // Write the log entry to the file
  if ($file) {
    fwrite($file, $logEntry);
    fclose($file);
  } else {
    // Handle the case where the file couldn't be opened
    // You can log this error to another file or take other actions as needed.
  }
}



mysqli_set_charset($con, "utf8");
require_once 'jdf.php';
