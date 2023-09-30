<?php
// Initialize the session
session_start();
require_once './php/db.php';
$id = $_SESSION['id'];
$sql = "Update users SET isLogin = '0' WHERE id = '$id'";

$con->query($sql);
// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location:/YadakShop-APP/index.php");
exit;
