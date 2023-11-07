<?php
// Set a unique session name
session_name("MyAppSession");
session_start();
require_once("db.php");
$value1 = $_POST['codeid'];

$value2 = $_POST['brand'];

$value3 = $_POST['qty'];

$value4 = $_POST['pos1'];

$value5 = $_POST['pos2'];

$value6 = $_POST['des'];

$value7 = $_POST['seller'];

$value8 = $_POST['deliverer'];

$value9 = $_POST['invoice'];

$value10 = $_POST['anbarenter'];

$value11 = $_SESSION["id"];

$value12 = $_POST['invoice_number'];

$value13 = $_POST['stock'];

$value14 = $_POST['invoice_time'];

$value15 = $_POST['code-box'];
$value16 = $_POST['brand-box'];

$sql = "INSERT INTO qtybank (codeid,brand,qty,pos1,pos2,des,seller,deliverer,invoice,anbarenter,user,invoice_number,stock_id,invoice_date) VALUES ('$value1', '$value2', '$value3', '$value4','$value5','$value6','$value7','$value8','$value9','$value10','$value11','$value12','$value13','$value14');";
$result = mysqli_query($con, $sql);
log_action('vorodKala', $sql, $_SESSION['id']);
if (!$result) {
    echo "Error MySQLI QUERY: " . mysqli_error($con) . "";
    die();
} else {
    echo '<p class="ok"> تعداد <span>' . $value3 . '</span> عدد <span>' . $value15 . '</span> برند <span>' . $value16 . '</span> با موفقیت وارد انبار شد </p>';
}

mysqli_close($con);
