<?php
require_once("./php/db.php");

$partNumber = $_POST['partNumber'] === 'null' ? null : $_POST['partNumber']; // Assuming you're retrieving the value from a form
$seller_id = $_POST['seller'] === 'null' ? null : $_POST['seller'];
$brand_id = $_POST['brand'] === 'null' ? null : $_POST['brand'];
$pos1 = $_POST['pos1'] === 'null' ? null : $_POST['pos1'];
$pos2 = $_POST['pos2'] === 'null' ? null : $_POST['pos2'];
$stock_id = $_POST['stock'] === 'null' ? null : $_POST['stock'];
$user_id = $_POST['user'] === 'null' ? null : $_POST['user'];
$invoice_number = $_POST['invoice_number'] === 'null' ? null : $_POST['invoice_number'];
$invoice_date = $_POST['invoice_time'] === 'null' ? null : $_POST['invoice_time']; // Assuming you're retrieving the value from a form

// Prepare the statement
$stmt = $pdo->prepare("SELECT nisha.partnumber ,nisha.price AS nprice,seller.id AS slid, brand.name , qtybank.des ,qtybank.id, qtybank.qty , qtybank.pos1 , qtybank.pos2 , qtybank.create_time , seller.name AS sln, deliverer.name AS dn , qtybank.anbarenter ,qtybank.invoice , users.username AS un , qtybank.invoice_number,qtybank.invoice_date ,stock.name AS stn
                        FROM qtybank
                        LEFT JOIN nisha ON qtybank.codeid=nisha.id
                        LEFT JOIN brand ON qtybank.brand=brand.id
                        LEFT JOIN seller ON qtybank.seller=seller.id
                        LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
                        LEFT JOIN users ON qtybank.user=users.id
                        LEFT JOIN stock ON qtybank.stock_id=stock.id 
                        WHERE (nisha.partnumber = :partNumber OR :partNumber IS NULL)
                        AND (qtybank.seller = :seller_id OR :seller_id IS NULL)
                        AND (brand.id = :brand_id OR :brand_id IS NULL)
                        AND (qtybank.pos1 = :pos1 OR :pos1 IS NULL)
                        AND (qtybank.pos2 = :pos2 OR :pos2 IS NULL)
                        AND (qtybank.stock_id = :stock_id OR :stock_id IS NULL)
                        AND (qtybank.user = :user_id OR :user_id IS NULL)
                        AND (qtybank.invoice_number = :invoice_number OR :invoice_number IS NULL)
                        AND (qtybank.invoice_date = :invoice_date OR :invoice_date IS NULL)
                        ORDER BY qtybank.create_time DESC");

// Bind the parameters
$stmt->bindParam(':partNumber', $partNumber, PDO::PARAM_STR);
$stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
$stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
$stmt->bindParam(':invoice_number', $invoice_number, PDO::PARAM_STR);
$stmt->bindParam(':pos1', $pos1, PDO::PARAM_STR);
$stmt->bindParam(':pos2', $pos2, PDO::PARAM_STR);
$stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);

$stmt->execute();

// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

global $jameitem;
$jameitem = 0;
global $invoice_number;
$invoice_number = 0000;
global $shakhes;
$shakhes = 1;

if (true) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $date = $row["create_time"];

        $array = explode(' ', $date);
        list($year, $month, $day) = explode('-', $array[0]);
        list($hour, $minute, $second) = explode(':', $array[1]);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);

        $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
        $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");

?>


        <?php
        if ($invoice_number == 0000) {

            $invoice_number = $row["invoice_number"];
        }


        if ($invoice_number != $row["invoice_number"]) {



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
        <tr style="background-color: #f4f3f3;">
            <td class="cell-shakhes "><?php echo $shakhes ?></td>
            <td class="cell-code "><?php echo '&nbsp;' . $row["partnumber"] ?></td>
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
            <td class="cell-date "><?php echo substr($row["invoice_date"], 5) ?></td>
            <td class="tik-anb-<?php echo $row["anbarenter"] ?>"></td>
            <td class="cell-stock "><?php echo $row["stn"] ?></td>
            <td class="cell-user "><?php echo $row["un"] ?></td>

            <?php if (userRoll() < 3) { ?>
                <td class="cell-price "><?php echo (echoRial($row["nprice"], $row["name"])); ?></td>
            <?php } ?>
            <td><a onclick="displayModal(this)" id="<?php echo $row["id"] ?>" class="edit-rec2">ویرایش<i class="fas fa-edit"></i></a></td>
        </tr>
<?php

        $shakhes = $shakhes + 1;
    } // end while
} else {
    echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';
}

function userRoll()
{
    $username =  $_SESSION["username"];
    $con = mysqli_connect('localhost', 'root', '', 'yadakshop1401');
    $sql = "SELECT * FROM users WHERE username='$username' ";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            return $row["roll"];
        }
    }
}
