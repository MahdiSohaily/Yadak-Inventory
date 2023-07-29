<?php
$q = $_GET['q'];
 require_once("db.php"); 





$sql = "


SELECT nisha.partnumber , nisha.id , seller.name , brand.name AS brn ,stock.name AS stn, qtybank.qty,qtybank.pos1,qtybank.pos2 ,qtybank.des,qtybank.id AS qtyid,  qtybank.qty AS entqty 
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN brand ON qtybank.brand=brand.id
LEFT JOIN stock ON qtybank.stock_id=stock.id  
WHERE partnumber LIKE '".$q."%'
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








<tr>

    <td class="cell-code "><?php echo $row["partnumber"] ?></td>
    <td class="cell-brand cell-brand-<?php echo $row["brn"] ?> "><?php echo $row["brn"] ?></td>
    <td class="cell-qty "><?php echo $finalqty ?></td>
    <td class="cell-seller cell-seller-<?php echo $row["name"] ?>"><?php echo $row["name"] ?></td>

    <td class="cell-des "><?php echo $row["des"] ?></td>

    <td class="cell-stock "><?php echo $row["stn"] ?></td>

    <td class="cell-pos1 "><?php echo $row["pos1"] ?></td>
    <td class="cell-pos2 "><?php echo $row["pos2"] ?></td>



</tr>







<?php
 
 
        
        
             
             
        
 
             
             
             
             
             
             
             
    } 
        
        
         
        
        
        
     
 }

    } // end while

else {
    echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
}
mysqli_close($con);
?>
