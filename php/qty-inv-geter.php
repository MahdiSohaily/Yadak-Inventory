<?php
$q = $_GET['q'];
 require_once("db.php"); 
 require_once("function.php"); 





$sql = "


SELECT nisha.partnumber ,nisha.price AS nprice, nisha.id , seller.name , brand.name AS brn , qtybank.qty ,qtybank.des,qtybank.id AS qtyid,  qtybank.qty AS entqty 
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN brand ON qtybank.brand=brand.id
WHERE partnumber LIKE '".$q."%'
ORDER BY nisha.partnumber DESC




";


global $y ;
 
 $result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
     
    while($row = mysqli_fetch_assoc($result)) {
   
        
       $finalqty = $row["entqty"];
        
$price = echoRial($row['nprice'],$row["brn"]);


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
        
            $x = $row["partnumber"];
        
        if ($x != $y){
           echo '<div class="qty-inv-head">'.$row["partnumber"].'</div>';
        }
        $y = $row["partnumber"];
        
        
        
        
        
 
 
        
        
        
 
        echo '<div class="qty-inv">
        
        
        <div class="qty-inv-first">'.$finalqty.'</div>
        <div>'.$row["brn"].'</div>
        <div class="qty-inv-des">'.$row["des"].'</div>
        <div>'.$row["name"].'</div>
        <div class="action"><input type="text" value="'.$price.'"><input type="number" min="0" max="'.$finalqty.'" value="1" class="qty-x"><a class="add-to-btn">افزودن <i class="fas fa-plus-circle"></i>

</a></div>

</div>'; 
    } 
        
        
         
        }

        } // end while

        else {
        echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
        }
        mysqli_close($con);
        ?>
