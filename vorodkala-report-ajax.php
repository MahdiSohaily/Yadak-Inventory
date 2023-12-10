<?php
session_name("MyAppSession");
require_once("./php/db.php");
date_default_timezone_set('Asia/Tehran');

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
                        WHERE (nisha.partnumber LIKE :partNumber OR :partNumber IS NULL)
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
$parameter = $partNumber . "%";
$stmt->bindParam(':partNumber', $parameter, PDO::PARAM_STR);
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
$counter = 1;
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $date = $row["create_time"];

        $array = explode(' ', $date);
        list($year, $month, $day) = explode('-', $array[0]);
        list($hour, $minute, $second) = explode(':', $array[1]);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);

        $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
        $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");
        if ($invoice_number == 0000) {

            $invoice_number = $row["invoice_number"];
        }


        if ($invoice_number != $row["invoice_number"]) {
            $invoice_number = $row["invoice_number"];
            $shakhes = 1;
?>


            <tr class="bill_section" style="border-bottom: 2px solid gray;">
                <td colspan="20" class="left_right" style="background-color: aquamarine !important;
                                        font-weight: bold; font-size: 18px;
                                        margin-right: 10% !important;">
                    جمع اقلام : <?= $jameitem;
                                $jameitem = 0; ?>
                </td>
            </tr>
            <tr style="background-color: white !important;">
                <td colspan="20"></td>
            </tr>
            <tr style="background-color: white !important;">
                <td colspan="20"></td>
            </tr>

        <?php
        }
        $jameitem = $jameitem + $row["qty"];
        ?>
        <tr class="left_right <?= $shakhes == 1 ? 'border_top' : ''; ?>">
            <td class="cell-shakhes "><?= $shakhes ?></td>
            <td class="cell-code "><?= '&nbsp;' . strtoupper($row["partnumber"]) ?></td>
            <td class="cell-brand cell-brand-<?= $row["name"] ?> "><?= $row["name"] ?></td>
            <td class="cell-des "><?= $row["des"] ?></td>
            <td class="cell-qty "><?= $row["qty"] ?></td>
            <td class="cell-pos1 "><?= $row["pos1"] ?></td>
            <td class="cell-pos2 "><?= $row["pos2"] ?></td>
            <td class="cell-seller cell-seller-<?= $row["slid"] ?>"><?= $row["sln"] ?></td>
            <td class="cell-time "><?= $jalali_time ?></td>
            <td class="cell-date "><?= $jalali_date ?></td>
            <td class="cell-dlname "><?= $row["dn"] ?></td>
            <td class="tik-inv-<?= $row["invoice"] ?>"></td>
            <td><?= $row["invoice_number"] ?></td>
            <td class="cell-date "><?= substr($row["invoice_date"], 5) ?></td>
            <td class="tik-anb-<?= $row["anbarenter"] ?>"></td>
            <td class="cell-stock "><?= $row["stn"] ?></td>
            <td class="cell-user "><?= $row["un"] ?></td>
            <td><a onclick="displayModal(this)" id="<?= $row["id"] ?>" class="edit-rec2">ویرایش</a></td>
        </tr>
        <?php
        if ($stmt->rowCount() == $counter) :
        ?>
            <tr class="bill_section" style="border-bottom: 2px solid gray;">
                <td colspan="20" class="left_right" style="background-color: aquamarine !important;
                                        font-weight: bold; font-size: 18px;
                                        margin-right: 10% !important;">
                    جمع اقلام : <?= $jameitem;
                                $jameitem = 0; ?>
                </td>
            </tr>
            <tr style="background-color: white !important;">
                <td colspan="20"></td>
            </tr>
            <tr style="background-color: white !important;">
                <td colspan="20"></td>
            </tr>
<?php
        endif;
        $shakhes++;
        $counter++;
    } // end while
} else {
    echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';
}
