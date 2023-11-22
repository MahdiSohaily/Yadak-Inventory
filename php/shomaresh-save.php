<?php
session_name("MyAppSession");
require_once("db.php");

$value1 = $_POST['codeid'];
$value2 = $_POST['brand'];
$value3 = $_POST['qty'];
$value4 = $_POST['pos1'];
$value5 = $_POST['pos2'];
$value6 = $_POST['des'];

$value7 = 58;
$value8 = $_SESSION["id"];

$value9 = $_POST['stock'];
$value15 = $_POST['code-box'];
$value16 = $_POST['brand-box'];


$sql = "INSERT INTO qtybank (codeid,brand,qty,pos1,pos2,des,seller,user,stock_id) VALUES ('$value1', '$value2', '$value3', '$value4','$value5','$value6','$value7','$value8','$value9');";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo "Error MySQLI QUERY: " . mysqli_error($con) . "";
    die();
} else {
    echo '<p class="ok"> تعداد <span>' . $value3 . '</span> عدد <span>' . $value15 . '</span> برند <span>' . $value16 . '</span> با موفقیت وارد انبار شد </p>';
}

mysqli_close($con);
