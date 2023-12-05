<?php
require_once("db.php");

if (isset($interval)) {
    date_default_timezone_set('Asia/Tehran');
    // Get today's date
    $todayDate = date('Y-m-d');

    // Calculate the date from 10 days ago
    $previousDate = date('Y-m-d', strtotime('-' . $interval . ' days'));

    $todayDate .= " 23:00:00";
    $previousDate .= " 00:00:00";

    $condition = " WHERE exitrecord.exit_time >= '$previousDate'
    AND exitrecord.exit_time <= '$todayDate'";
} else {
    $condition = 'WHERE 1=1';
}

$sql = "SELECT nisha.partnumber,
exitrecord.id AS exitrecord_id,
qtybank.des, 
nisha.id , 
users.username AS usn,
seller.name ,
seller.id AS slid,
stock.name AS stn,
brand.name AS brn,
qtybank.qty,
qtybank.id AS qtyid,exitrecord.qty AS extqty,exitrecord.id AS exid,
qtybank.qty AS entqty ,exitrecord.customer,exitrecord.des AS exdes,getter.name AS gtn,
deliverer.name AS dln,exitrecord.exit_time,exitrecord.jamkon,
exitrecord.invoice_number,exitrecord.invoice_date,qtybank.anbarenter,
qtybank.invoice_number AS qty_invoice_number,
qtybank.invoice_date AS qty_invoice_date
FROM qtybank
INNER JOIN nisha ON qtybank.codeid=nisha.id
INNER JOIN exitrecord ON qtybank.id=exitrecord.qtyid
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN brand ON qtybank.brand=brand.id
LEFT JOIN stock ON qtybank.stock_id=stock.id
LEFT JOIN users ON exitrecord.user=users.id
LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
LEFT JOIN getter ON exitrecord.getter=getter.id
$condition
AND exitrecord.is_transfered = 0
ORDER BY  exitrecord.exit_time DESC";


global $jameitem;
$jameitem = 0;
global $invoice_number;
$invoice_number = 0000;
global $shakhes;
$shakhes = 1;
$counter = 1;

$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        $date = $row["exit_time"];

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
        $jameitem = $jameitem + $row["extqty"]; ?>
        <tr class="left_right <?= $shakhes == 1 ? 'border_top' : ''; ?>">
            <td class="cell-shakhes "><?= $shakhes ?></td>
            <td class="cell-code "><?= '&nbsp;' . strtoupper($row["partnumber"]) ?></td>
            <td class="cell-brand cell-brand-<?= $row["brn"] ?> "><?= $row["brn"] ?></td>
            <td class="cell-des "><?= $row["des"] ?></td>
            <td class="cell-des "><?= $row["exdes"] ?></td>
            <td class="cell-qty "><?= $row["extqty"] ?></td>
            <td class="cell-seller cell-seller-<?= $row["slid"] ?>"><?= $row["name"] ?></td>
            <td class="cell-customer "><?= $row["customer"] ?></td>
            <td class="cell-gtname "><?= $row["gtn"] ?></td>
            <td class="cell-gtname "><?= $row["jamkon"] ?></td>
            <td class="cell-time "><?= $jalali_time ?></td>
            <td class="cell-date "><?= $jalali_date ?></td>
            <td <?php if (empty($row["invoice_number"])) {
                    echo 'class="no-invoice-number"';
                } ?>><?= $row["invoice_number"] ?></td>
            <td class="cell-date "><?= substr($row["invoice_date"], 5) ?></td>

            <td class="tik-anb-<?= $row["anbarenter"] ?>"></td>
            <td class="cell-time "><?= $row['qty_invoice_number'] ?></td>
            <td class="cell-time "><?= $row['qty_invoice_date'] ?></td>
            <td class="cell-stock "><?= $row["stn"] ?></td>
            <td class="cell-user "><?= $row["usn"] ?></td>
            <td style="display: flex; justify-content: center; margin-block: 15px;"><a onclick="displayModal(this)" id="<?= $row["exid"] ?>" class="edit-rec2"><i class="fa fa-pen" aria-hidden="true"></i></a></td>
        </tr>
        <?php
        if (mysqli_num_rows($result) == $counter) :
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
