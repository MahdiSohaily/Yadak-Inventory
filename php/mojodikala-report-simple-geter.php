<?php
 
 require_once("db.php"); 





$sql = "


SELECT nisha.partnumber , nisha.id ,nisha.price AS nprice, seller.name , brand.name AS brn , qtybank.qty ,qtybank.des,qtybank.id AS qtyid,  qtybank.qty AS entqty 
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN brand ON qtybank.brand=brand.id
ORDER BY nisha.partnumber DESC
";


 
 $result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
     
    while($row = mysqli_fetch_assoc($result)) {
   
        
       $finalqty = $row["entqty"];
        



        $sql2 = "
SELECT qty FROM exitrecord WHERE qtyid LIKE '".$row["qtyid"]."'
";





 $result2 = mysqli_query($con,$sql2);
if (mysqli_num_rows($result2) > 0) {
    while($row2 = mysqli_fetch_assoc($result2)) {
        
               $finalqty =  $finalqty - $row2["qty"];

        
    }
}
        
        
         if ($finalqty > 0){
        
    
        
        
        ?>


<td><?php echo $row["partnumber"] ?></td>
<td><?php echo $row["brn"] ?></td>
<td><?php echo $finalqty ?></td>
<td><?php echo $row["name"] ?></td>
<td><?php echo $row["des"] ?></td>








<tr>



</tr>








<?php
            
                } 
   
 }
     
    
    } // end while

else {
echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';
}
mysqli_close($con);
?>
