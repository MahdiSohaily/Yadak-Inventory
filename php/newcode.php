<?php
 require_once("db.php"); 
$value1 = $_POST['newcode'];






$value2 = $_POST['doll-gen'];
$value4 = $_POST['doll-psq'];

if (!empty($_POST['doll-gen'])) {  
    $value4 = $value2*(2.43);
}
 

$value3 = $_POST['doll-mob'];
$value5 = $_POST['doll-pm'];

if (!empty($_POST['doll-mob'])) {  
    $value5 = $value3*(2.43);
}
 

$sql="INSERT INTO nisha (partnumber,price,mobis) VALUES ('$value1','$value4','$value5');";
$result = mysqli_query($con,$sql);
if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();
}
else
{
echo '<p class="ok"> کد فنی <span>'.$value1.'</span>  با موفقیت وارد بانک کد فنی شد</p>';
} 
 
mysqli_close($con);
?>
