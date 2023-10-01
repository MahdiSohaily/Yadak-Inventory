<?php
// Initialize the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  // Check if the session has expired (current time > expiration time)
  if (isset($_SESSION["expiration_time"]) && time() > $_SESSION["expiration_time"]) {
    // Session has expired, destroy it and log the user out
    session_unset();
    session_destroy();
    header("location: login.php"); // Redirect to the login page
    exit;
  }
} else {
  // User is not logged in, redirect them to the login page
  header("location: login.php");
  exit;
}


require_once("db.php");



function echoRial($x, $y)
{
  if (!empty($x)) {


    if ($y == "GEN") {
      return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3) * 10000), 0);
    }
    if ($y == "MOB") {
      return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3 * 0.9) * 10000), 0);
    }
    if ($y != "GEN" && $y != "MOB") {
      return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3 * 0.5) * 10000), 0);
    }
  }
}



function userRoll()
{

  $username =  $_SESSION["username"];
  $con = mysqli_connect('localhost', 'root', '', 'yadakshop1401');
  $sql = "SELECT * FROM users WHERE username='$username' ";
  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      return $row["roll"];
    }
  }
}
