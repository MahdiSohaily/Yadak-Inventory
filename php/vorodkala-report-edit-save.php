<?php
 
 require_once("db.php"); 

$value1 = $_GET['id'];

$value2 = $_GET['brand'];

$value3 = $_GET['qty'];

$value4 = $_GET['pos1'];

$value5 = $_GET['pos2'];

$value6 = $_GET['des'];


 if (isset($_GET['deliverer']) || !empty($_GET['deliverer']))
{
    $value7 = $_GET['deliverer'];
}
else {
    
    $value7 = NULL;
}
$value8 = $_GET['invoice_number'];

$value9 = $_GET['stock'];

$value10 = $_GET['invoice_time'];

$value11 = $_GET['anbarenter'];

$value12 = $_GET['invoice'];


$sql="UPDATE qtybank SET brand='$value2',qty='$value3',anbarenter='$value11',invoice='$value12',invoice_date='$value10',pos1='$value4',pos2='$value5',des='$value6',deliverer='$value7',invoice_number='$value8',stock_id='$value9' 
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
    echo "Query succesfully executed!";


} 
 
mysqli_close($con);
?>
