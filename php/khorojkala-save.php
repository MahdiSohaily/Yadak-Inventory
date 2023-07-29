<?php

 require_once("db.php"); 


$value1 = $_POST['customer'];
$value2 = $_POST['getter'];
$value5 =  $_SESSION["id"];
$value6 =  $_POST['invoice_number'];
$value7 =  $_POST['des'];
$value8 =  $_POST['jamkon'];
$value9 =  $_POST['invoice_time'];

$x = 0;
foreach ($_POST['qty'] as $value) {
  

    $value3 = $value;
    $value4 = $_POST['qtyid'][$x];
    $x++;



$sql="INSERT INTO exitrecord (customer,getter,qty,qtyid,user,invoice_number,des,jamkon,invoice_date) VALUES ('$value1', '$value2', '$value3', '$value4','$value5','$value6','$value7','$value8','$value9');";
$result = mysqli_query($con,$sql);
 
if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();
 

}
else
{
$var = 1; 

} 
 
    
    
    }
if ($var == 1){
    
    echo '<p class="ok"> تعداد <span>'.$x.'</span> آیتم کالا برای خریدار <span>'.$value1.'</span> با موفقیت از انبار خارج شد </p>'; 

}

mysqli_close($con);
?>
