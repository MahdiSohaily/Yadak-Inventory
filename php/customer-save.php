<?php
require_once("db.php"); 

$value1 = $_POST['name'];
$value2 = $_POST['lastname'];
$value3 = $_POST['mobile'];
$value4 = $_POST['phone'];
$value5 = $_POST['address'];
$value6 = $_POST['car'];

 

$sql="INSERT INTO customer (name,lastname,mobile,phone,address,car) VALUES ('$value1','$value2','$value3','$value4','$value5','$value6');";
$result = mysqli_query($con,$sql);
if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();
}
else
{
echo '<p class="ok"> مشتری <span>'.$value1.' '.$value2.'</span>  با موفقیت وارد لیست شد</p>';
} 
 
mysqli_close($con);
?>
