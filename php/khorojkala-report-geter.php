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
qtybank.des, 
nisha.id , 
users.username AS usn,
seller.name ,
seller.id AS slid,
stock.name AS stn,
brand.name AS brn,
qtybank.qty,
qtybank.id AS qtyid,exitrecord.qty AS extqty,exitrecord.id AS exid ,
qtybank.qty AS entqty ,exitrecord.customer,exitrecord.des AS exdes,getter.name AS gtn,
deliverer.name AS dln,exitrecord.exit_time,exitrecord.jamkon,
exitrecord.invoice_number,exitrecord.invoice_date,qtybank.anbarenter
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
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
        $jameitem = $jameitem + $row["extqty"];


        ?>
        <tr>
            <td class="cell-shakhes "><?php echo $shakhes ?></td>
            <td class="cell-code "><?php echo '&nbsp;' . $row["partnumber"] ?></td>
            <td class="cell-brand cell-brand-<?php echo $row["brn"] ?> "><?php echo $row["brn"] ?></td>
            <td class="cell-des "><?php echo $row["des"] ?></td>
            <td class="cell-des "><?php echo $row["exdes"] ?></td>
            <td class="cell-qty "><?php echo $row["extqty"] ?></td>
            <td class="cell-seller cell-seller-<?php echo $row["slid"] ?>"><?php echo $row["name"] ?></td>
            <td class="cell-customer "><?php echo $row["customer"] ?></td>
            <td class="cell-gtname "><?php echo $row["gtn"] ?></td>
            <td class="cell-gtname "><?php echo $row["jamkon"] ?></td>
            <td class="cell-time "><?php echo $jalali_time ?></td>
            <td class="cell-date "><?php echo $jalali_date ?></td>
            <td <?php if (empty($row["invoice_number"])) {
                    echo 'class="no-invoice-number"';
                } ?>><?php echo $row["invoice_number"] ?></td>
            <td class="cell-date "><?php echo substr($row["invoice_date"], 5) ?></td>

            <td class="tik-anb-<?php echo $row["anbarenter"] ?>"></td>
            <td></td>
            <td></td>
            <td class="cell-stock "><?php echo $row["stn"] ?></td>
            <td class="cell-user "><?php echo $row["usn"] ?></td>
            <td><a onclick="displayModal(this)" id="<?php echo $row["exid"] ?>" class="edit-rec2">ویرایش<i class="fas fa-edit"></i></a></td>
        </tr>
<?php
        $shakhes = $shakhes + 1;
    }
} // end while

else {
    echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';
}
mysqli_close($con);
?>