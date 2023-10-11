<?php
$q = $_GET['q'];
require_once("db.php");

$sql = "SELECT nisha.partnumber , stock.name AS stn,stock.id AS sti, nisha.id , seller.name , brand.name AS brn , qtybank.qty ,qtybank.des,qtybank.id AS qtyid,  qtybank.qty AS entqty 
FROM qtybank 
LEFT JOIN nisha ON qtybank.codeid=nisha.id
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN stock ON qtybank.stock_id=stock.id
LEFT JOIN brand ON qtybank.brand=brand.id
WHERE partnumber LIKE '" . $q . "%'
ORDER BY nisha.partnumber DESC";

global $y;

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $finalqty = $row["entqty"];
        $sql2 = "SELECT qty FROM exitrecord WHERE qtyid = '" . $row["qtyid"] . "'";
        $result2 = mysqli_query($con, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {

                $finalqty =  $finalqty - $row2["qty"];
            }
        }
        if ($finalqty > 0) {

            $x = $row["partnumber"];

            if ($x != $y) {
                echo '<div class="qtybank-head">' . $row["partnumber"] . '</div>';
            }
            $y = $row["partnumber"];
            echo '<div class="qtybank">
                    <div class="qtybank-first">' . $finalqty . '</div>
                    <div>' . $row["brn"] . '</div><div>' . $row["name"] . '</div>
                    <div class="action">
                        <input stock="' . $row["sti"] . '" data-amount="' . $finalqty . '" brand="' . $row["brn"] . '" seller="' . $row["name"] . '" qtyid="' . $row["qtyid"] . '" code="' . $row["partnumber"] . '" type="number" min="0" max="' . $finalqty . '" value="1" class="qty-x">
                        <a class="add-to-khoroj" style="cursor: pointer">
                            افزودن
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                    <div class="qtybank-des">' . $row["des"] . '</div>
                    <div class="qtybank-stock">' . $row["stn"] . '</div>
                </div>';
        }
    }
} // end while

else {
    echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
}
mysqli_close($con);
