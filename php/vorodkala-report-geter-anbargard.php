<?php
 require_once("db.php"); 
 

$lim = "";
 if (!empty($_GET['lim'])) {  
    $lim ="LIMIT " . $_GET['lim'];
}



$var = "WHERE 1=1";

if (!empty($_GET['user'])) {  
    $var = $var . " AND users.id=".$_GET['user'];
}
if (!empty($_GET['brand'])) {  
    $var = $var . " AND  brand.id=".$_GET['brand'];
}
if (!empty($_GET['codeid'])) {  
    $var = $var . " AND  nisha.partnumber LIKE '".$_GET['codeid']."%'";
}
if (!empty($_GET['pos1'])) {  
    $var = $var . " AND   pos1='".$_GET['pos1']."'";
}
if (!empty($_GET['pos2'])) {  
    $var = $var . " AND   pos2='".$_GET['pos2']."'";
}
 
 if (!empty($_GET['stock'])) {  
    $var = $var . " AND   qtybank.stock_id='".$_GET['stock']."'";
}
 if (!empty($_GET['seller'])) {  
    $var = $var . " AND   qtybank.seller='".$_GET['seller']."'";
}
 if (!empty($_GET['invoice_number'])) {  
    $var = $var . " AND   qtybank.invoice_number='".$_GET['invoice_number']."'";
}
 if (!empty($_GET['invoice_time'])) {  
    $var = $var . " AND  qtybank.invoice_date LIKE '".$_GET['invoice_time']."%'";
}

 

$sql = "


SELECT COUNT(nisha.partnumber),nisha.partnumber ,nisha.price AS nprice,seller.id AS slid, brand.name , qtybank.des ,qtybank.id, qtybank.qty , qtybank.pos1 , qtybank.pos2 , qtybank.create_time , seller.name AS sln, deliverer.name AS dn , qtybank.anbarenter ,qtybank.invoice , users.username AS un , qtybank.invoice_number,qtybank.invoice_date ,stock.name AS stn
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
LEFT JOIN brand ON qtybank.brand=brand.id
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
LEFT JOIN users ON qtybank.user=users.id
LEFT JOIN stock ON qtybank.stock_id=stock.id
GROUP BY partnumber,brand.name 
HAVING COUNT(nisha.partnumber) > 1
 
ORDER BY nisha.partnumber DESC
 
;

";

global $jameitem ;
$jameitem = 0;
global $invoice_number ;
$invoice_number = 0000;
global $shakhes ;
$shakhes = 1 ;

$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
 
     
         
        
        

        
        
        
$date = $row["create_time"];
            
$array = explode(' ', $date);
list($year, $month, $day) = explode('-', $array[0]);
list($hour, $minute, $second) = explode(':', $array[1]);
$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

        
$jalali_time = jdate("H:i", $timestamp,"","Asia/Tehran","en");
$jalali_date = jdate("Y/m/d", $timestamp,"","Asia/Tehran","en");
        
    
        
        
        
        
?>


<?php 
        if($invoice_number == 0000){
            
            $invoice_number = $row["invoice_number"];
        }
        
         
        if($invoice_number != $row["invoice_number"]){ 
     
    

$invoice_number = $row["invoice_number"];

?>


<tr>
    <td class="invoice-spacer" colspan="18">
        جمع اقلام : <?php echo $jameitem; 
        $jameitem = 0;   
        ?>
    </td>
</tr>

<?php
                                                   } 
               $jameitem = $jameitem + $row["qty"];


?>



<tr>
    <td class="cell-shakhes "><?php echo $shakhes ?></td>
    <td class="cell-code "><?php echo '&nbsp;'.$row["partnumber"] ?></td>
    <td class="cell-brand cell-brand-<?php echo $row["name"] ?> "><?php echo $row["name"] ?></td>
    <td class="cell-des "><?php echo $row["des"] ?></td>
    <td class="cell-qty "><?php echo $row["qty"] ?></td>
    <td class="cell-pos1 "><?php echo $row["pos1"] ?></td>
    <td class="cell-pos2 "><?php echo $row["pos2"] ?></td>
    <td class="cell-seller cell-seller-<?php echo $row["slid"] ?>"><?php echo $row["sln"] ?></td>
    <td class="cell-time "><?php echo $jalali_time ?></td>
    <td class="cell-date "><?php echo $jalali_date ?></td>

    <td class="cell-dlname "><?php echo $row["dn"] ?></td>
    <td class="tik-inv-<?php echo $row["invoice"] ?>"></td>
    <td><?php echo $row["invoice_number"] ?></td>
    <td class="cell-date "><?php echo substr($row["invoice_date"],5) ?></td>

    <td class="tik-anb-<?php echo $row["anbarenter"] ?>"></td>

    <td class="cell-stock "><?php echo $row["stn"] ?></td>
    <td class="cell-user "><?php echo $row["un"] ?></td>

    <?php if(userRoll() < 3){ ?>

    <td class="cell-price "><?php echo(echoRial($row["nprice"],$row["name"])) ;?></td>


    <?php } ?>


    <td><a id="<?php echo $row["id"] ?>" class="edit-rec">ویرایش<i class="fas fa-edit"></i></a></td>

</tr>










<?php
            
            $shakhes = $shakhes + 1 ;

    } // end while
}
else {
echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';

}
mysqli_close($con);
?>
