<?php
session_name("MyAppSession");
$q = $_GET['q'];
require_once("db.php");
$sql = "DELETE FROM qtybank WHERE id = '" . $q . "' ";

$result = mysqli_query($con, $sql);
log_action('vorodKalaDelete', $sql, $_SESSION['id']);


if (!$result) {
    echo "Error MySQLI QUERY: " . mysqli_error($con) . "";
    die();
} else {
    echo "Query succesfully executed!";
}



mysqli_close($con);
