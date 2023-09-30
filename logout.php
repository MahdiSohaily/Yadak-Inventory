<?php
// Initialize the session
session_start();

$con->query($sql);
// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location:/YadakShop-APP/index.php");
exit;
