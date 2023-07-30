<?php
 
 require_once("db.php"); 

$value1 = $_GET['id'];
$value2 = $_GET['qty'];
$value3 = $_GET['des'];
$value4 = $_GET['invoice_number'];
$value5 = $_GET['invoice_time'];
$value6 = $_GET['jamkon'];
$value7 = $_GET['getter'];
$value8 = $_GET['customer'];

 

 


$sql="UPDATE exitrecord SET getter='$value7',jamkon='$value6',qty='$value2',des='$value3',invoice_date='$value5',customer='$value8',invoice_number='$value4' 
WHERE id = '".$value1."'

";
$result = mysqli_query($con,$sql);
if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();

}
else
{
    echo "ویرایش موفقانه صورت گرفت";
} 
 
mysqli_close($con);
