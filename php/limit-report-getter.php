<?php

require_once("db.php");

$sql = "SELECT nisha.partnumber , nisha.id,stock.name AS stckname ,nisha.price AS nprice, seller.name , brand.name AS brn , qtybank.qty,qtybank.pos1,qtybank.pos2 ,qtybank.des,qtybank.id AS qtyid,  qtybank.qty AS entqty 
        , qtybank.is_transfered
        FROM qtybank
        LEFT JOIN nisha ON qtybank.codeid=nisha.id
        LEFT JOIN seller ON qtybank.seller=seller.id
        LEFT JOIN brand ON qtybank.brand=brand.id
        LEFT JOIN stock ON qtybank.stock_id=stock.id
        ORDER BY nisha.partnumber DESC";


global $shakhes;
$shakhes = 1;

$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $finalqty = $row["entqty"];

        $sql2 = " SELECT qty FROM exitrecord WHERE qtyid LIKE '" . $row["qtyid"] . "'";
        $result2 = mysqli_query($con, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            while ($record = mysqli_fetch_assoc($result2)) {

                $finalqty =  $finalqty - $record["qty"];
            }
        }
        if ($finalqty > 0) {

            if ($row['is_transfered'] !== '1') : ?>
                <tr>
                    <td class="cell-shakhes "><?= $shakhes ?></td>
                    <td class="cell-code "><?= '&nbsp;' .  $row["partnumber"] ?></td>
                    <td class="cell-brand  cell-brand-<?= $row["brn"] ?> "><?= $row["brn"] ?></td>
                    <td class="cell-qty "><?= $finalqty ?></td>
                    <td class="cell-seller cell-seller-<?= $row["name"] ?>"><?= $row["name"] ?></td>
                    <td class="cell-pos1 "><?= $row["pos1"] ?></td>
                    <td class="cell-pos2 "><?= $row["pos2"] ?></td>
                    <td class="cell-des "><?= $row["des"] ?></td>
                    <td class="cell-stock "><?= $row["stckname"] ?></td>
                </tr>
            <?php else : ?>
                <tr class="transfer">
                    <td class="cell- "><?= $shakhes ?></td>
                    <td class="bold fs-20"><?= $row["partnumber"] ?></td>
                    <td class="bold fs-13"><?= $row["brn"] ?></td>
                    <td><?= $finalqty ?></td>
                    <td class="bold fs-13"><?= $row["name"] ?></td>
                    <td><?= $row["pos1"] ?></td>
                    <td><?= $row["pos2"] ?></td>
                    <td class="cell-des"><?= $row["des"] ?></td>
                    <td class="cell-stock-move"><?= $row["stckname"] ?></td>
                </tr>
<?php
            endif;

            $shakhes++;
        }
    }
} // end while

else {
    echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';
}
mysqli_close($con);
?>