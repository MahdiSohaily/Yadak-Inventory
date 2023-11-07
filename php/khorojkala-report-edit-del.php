<?php
session_name("MyAppSession");
$q = $_GET['q'];
require_once("db.php");
$sql = "DELETE FROM exitrecord WHERE id LIKE '" . $q . "' ";

$result = mysqli_query($con, $sql);
log_action('khorojKalaDelete', $sql, $_SESSION['id']);



if (!$result) {
    echo "Error MySQLI QUERY: " . mysqli_error($con) . "";
    die();
} else {
    echo "Query succesfully executed!";
}



mysqli_close($con);
