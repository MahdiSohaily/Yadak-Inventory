<?php
// Create a PDO connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "yadakshop1402";

// Establish a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define a Global database connection to work white in every page
    define('DB_CONNECTION', $pdo);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
