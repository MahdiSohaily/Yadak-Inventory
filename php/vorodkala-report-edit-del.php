<?php
session_name("MyAppSession");
$q = $_GET['q'];
$exit = $_GET['d'];
require_once("db.php");
$sql = "DELETE FROM qtybank WHERE id = '" . $q . "' ";
$sql2 = "DELETE FROM exitrecord WHERE id = '" . $exit . "' ";
$sql3 = "DELETE FROM transfer_record WHERE qtybanck_id = '" . $q . "' ";

$result = mysqli_query($con, $sql);
$result = mysqli_query($con, $sql2);
$result = mysqli_query($con, $sql3);
log_action('vorodKalaDelete', $sql, $_SESSION['id']);


if (!$result) {
    echo "Error MySQLI QUERY: " . mysqli_error($con) . "";
    die();
} else {
    echo "عملیات موفقانه انجام شد.";
}



mysqli_close($con);
