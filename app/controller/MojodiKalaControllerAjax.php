<?php
require_once '../../bootstrap/init.php';



function echoRial($x, $y)
{
    if (!empty($x)) {


        if ($y == "GEN") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3) * 10000), 0);
        }
        if ($y == "MOB") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3 * 0.9) * 10000), 0);
        }
        if ($y != "GEN" && $y != "MOB") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3 * 0.5) * 10000), 0);
        }
    }
}

if (filter_has_var(INPUT_POST, 'search')) {
    $pattern = $_POST['pattern'];

    $sql = " SELECT nisha.partnumber , nisha.id,stock.name AS stckname ,nisha.price AS nprice, seller.name , brand.name AS brn , qtybank.qty,qtybank.pos1,qtybank.pos2 ,qtybank.des,qtybank.id AS qtyid,  qtybank.qty AS entqty 
        FROM qtybank
        LEFT JOIN nisha ON qtybank.codeid=nisha.id
        LEFT JOIN seller ON qtybank.seller=seller.id
        LEFT JOIN brand ON qtybank.brand=brand.id
        LEFT JOIN stock ON qtybank.stock_id=stock.id
        WHERE nisha.partnumber LIKE '" . $pattern . "%'
        ORDER BY nisha.partnumber DESC ";

    $statement = DB_CONNECTION->prepare("SELECT nisha.partnumber , nisha.id,stock.name AS stckname ,nisha.price AS nprice, seller.name , brand.name AS brn , qtybank.qty,qtybank.pos1,qtybank.pos2 ,qtybank.des,qtybank.id AS qtyid,  qtybank.qty AS entqty 
        FROM qtybank
        LEFT JOIN nisha ON qtybank.codeid=nisha.id
        LEFT JOIN seller ON qtybank.seller=seller.id
        LEFT JOIN brand ON qtybank.brand=brand.id
        LEFT JOIN stock ON qtybank.stock_id=stock.id
        WHERE nisha.partnumber LIKE :pattern
        ORDER BY nisha.partnumber DESC");

    $statement->bindParam(":pattern", $pattern . "%");
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);


    global $shakhes;
    $shakhes = 1;

    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {


            $finalqty = $row["entqty"];

            $sql2 = " SELECT qty FROM exitrecord WHERE qtyid LIKE '" . $row["qtyid"] . "'";
            $result2 = mysqli_query($con, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = mysqli_fetch_assoc($result2)) {

                    $finalqty =  $finalqty - $row2["qty"];
                }
            }
            if ($finalqty > 0) {
?>

                <td class="cell-shakhes "><?php echo $shakhes ?></td>

                <td class="cell-code "><?php echo '&nbsp;' . $row["partnumber"] ?></td>
                <td class="cell-brand cell-brand-<?php echo $row["brn"] ?> "><?php echo $row["brn"] ?></td>
                <td class="cell-qty "><?php echo $finalqty ?></td>
                <td class="cell-seller cell-seller-<?php echo $row["name"] ?>"><?php echo $row["name"] ?></td>


                <td class="cell-pos1 "><?php echo $row["pos1"] ?></td>
                <td class="cell-pos2 "><?php echo $row["pos2"] ?></td>
                <td class="cell-des "><?php echo $row["des"] ?></td>
                <td class="cell-stock "><?php echo $row["stckname"] ?></td>

                <td class="cell-price "><?php echo (echoRial($row["nprice"], $row["brn"])); ?></td>
                <tr>
                </tr>
<?php

                $shakhes = $shakhes + 1;
            }
        }
    } // end while

    else {
        echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';
    }
    mysqli_close($con);
}
