<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <?php
$q = $_GET['q'];
 require_once("db.php"); 
    
$sql="SELECT * FROM Nisha WHERE partnumber LIKE '".$q."%'";
$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $partnumber = $row['partnumber'];
        $price = $row['price'];
        $Weight =  round($row['weight'],2);
        $avgprice = round($price*100/243.5*1.1);
        $mobis = $row['mobis'];
        if($mobis=="0.00"){$status = "NO-Price";}
        elseif ($mobis=="-"){$status = "NO-Mobis";}
        elseif ($mobis==NULL){$status = "Requset";}
        else {$status = "YES-Mobis";} ?>

    <tr>
        <td class="blue">
            <?php if($status == "Requset"){?><a class="Requset" target="_blank" href="php/mobis-get.php?q=<?php echo $partnumber ?>">?</a><?php } 
            if($status == "NO-Price"){?><a class="NO-Price" target="_blank" href="php/mobis-get.php?q=<?php echo $partnumber ?>">!</a><?php } 
            if($status == "NO-Mobis"){?><div class="NO-Mobis">X</div><?php } if($status == "YES-Mobis"){?><div class="empty"></div> <?php } ?>
            <?php echo $partnumber ?></td>
        <td><?php echo round($avgprice) ?></td>
        <td><?php echo round($avgprice*1.1) ?></td>
        <td class="border gold"><?php echo round($avgprice*1.2) ?></td>

        <td><?php echo round($avgprice*27*1.1*1.3) ?></td>
        <td><?php echo round($avgprice*28*1.1*1.3) ?></td>
        <td><?php echo round($avgprice*29*1.1*1.3) ?></td>
        <td><?php echo round($avgprice*30*1.1*1.3) ?></td>
        <td class="gold"><?php echo round($avgprice*31*1.1*1.3) ?></td>
        <td><?php echo round($avgprice*31*1.1*1.3*1.1) ?></td>
        <td class="gold2"><?php echo round($avgprice*31*1.1*1.3*1.2) ?></td>
        <td><?php echo round($avgprice*31*1.1*1.3*1.3) ?></td>


        <td class="Action"><a class="Google" target="_blank" href="https://www.google.com/search?tbm=isch&q=<?php echo $partnumber ?>"></a>
            <a class="Save" msg="<?php echo $partnumber ?>"></a>
            <a class="PartSouq" target="_blank" href="https://partsouq.com/en/search/all?q=<?php echo $partnumber ?>"></a>
        </td>
        <td>
            <div class="Weight"><?php echo $Weight ?> KG</div>
        </td>
    </tr>
    <?php
        if($status == "YES-Mobis"){ 
            $price = $row['mobis'];
            $price = str_replace(",","",$price);
            $avgprice = round($price*100/243.5*1.1);

    ?>
    <tr class="itsmobis">
        <td class="blue">
            <div class="empty"></div><?php echo $partnumber ?>-M
        </td>
        <td><?php echo round($avgprice/1.1) ?></td>
        <td class="gold"><?php echo round($avgprice) ?></td>
        <td class="border"><?php echo round($avgprice*1.1) ?></td>

        <td><?php echo round($avgprice*27*1.25*1.3) ?></td>
        <td><?php echo round($avgprice*28*1.25*1.3) ?></td>
        <td><?php echo round($avgprice*29*1.25*1.3) ?></td>
        <td><?php echo round($avgprice*30*1.25*1.3) ?></td>
        <td class="gold"><?php echo round($avgprice*31*1.25*1.3) ?></td>
        <td><?php echo round($avgprice*31*1.25*1.3*1.1) ?></td>
        <td><?php echo round($avgprice*31*1.25*1.3*1.2) ?></td>
        <td><?php echo round($avgprice*31*1.25*1.3*1.3) ?></td>


        <td class="Action"></td>
        <td></td>

    </tr>
    <?php }
    } // end while
}
else {
    echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
}
mysqli_close($con);
?>
</body>

</html>
