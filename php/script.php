<?php
 

 
 
global $con;
$con = mysqli_connect('localhost','root','','yadakshop1401');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
mysqli_set_charset($con, "utf8");
require_once 'jdf.php';






$sql = "SELECT * FROM qtybank";


 
 
 $result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
     
    while($row = mysqli_fetch_assoc($result)) {
   
        
       $finalqty = $row["qty"];
        



        $sql2 = "
SELECT qty FROM exitrecord WHERE qtyid LIKE '".$row["id"]."'
";





 $result2 = mysqli_query($con,$sql2);
if (mysqli_num_rows($result2) > 0) {
    while($row2 = mysqli_fetch_assoc($result2)) {
        
               $finalqty =  $finalqty - $row2["qty"];

        
    }
}
        
        
         if ($finalqty > 0){
        
    
        
        
   


$codeid = $row["codeid"];
$brand = $row["brand"] ;
$seller = $row["seller"] ;            
$pos1 = $row["pos1"] ;
$pos2 = $row["pos2"] ;
$des = $row["des"] ;
$stock_id = $row["stock_id"] ;
$invoice_date = $row["invoice_date"] ; 
$user = 14;
   
             
            
  $sql3 = "           
INSERT INTO qtybank2 (codeid,brand,des,qty,pos1,pos2,seller,user,stock_id,invoice_date)
VALUES ('".$codeid."', '".$brand."','".$des."','".$finalqty."','".$pos1."','".$pos2."','".$seller."','".$user."','".$stock_id."','".$invoice_date."');
";
             
             
             
             
             
              $result3 = mysqli_query($con,$sql3);
if (mysqli_num_rows($result3) > 0) {
    while($row3 = mysqli_fetch_assoc($result3)) {
        
echo "done";
        
    }
}
             
             
             
             
             
             
             
             
             
             
             
             
            
               } 
   
 }
     
    
    } // end while

else {
echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';
}
mysqli_close($con);
?>
