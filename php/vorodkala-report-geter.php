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

    $condition = " WHERE qtybank.create_time >= '$previousDate'
    AND qtybank.create_time <= '$todayDate'";
} else {
    $condition = 'WHERE 1=1';
}

$sql = "SELECT qtybank.id AS qtyidsss, nisha.partnumber ,nisha.price AS nprice,seller.id AS slid, brand.name , qtybank.des ,qtybank.id, qtybank.qty , qtybank.pos1 , qtybank.pos2 , qtybank.create_time , seller.name AS sln, deliverer.name AS dn , qtybank.anbarenter ,qtybank.invoice , users.username AS un , qtybank.invoice_number,qtybank.invoice_date ,stock.name AS stn
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
LEFT JOIN brand ON qtybank.brand=brand.id
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
LEFT JOIN users ON qtybank.user=users.id
LEFT JOIN stock ON qtybank.stock_id=stock.id 
$condition
ORDER BY qtybank.create_time DESC";

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
            <td class="cell-shakhes"><?= $shakhes ?></td>
            <td class="cell-code"><?= '&nbsp;' . strtoupper($row["partnumber"]) ?></td>
            <td class="cell-brand cell-brand-<?= $row["name"] ?>"><?= $row["name"] ?></td>
            <td class="cell-des"><?= $row["des"] ?></td>
            <td class="cell-qty"><?= $row["qty"] ?></td>
            <td class="cell-pos1"><?= $row["pos1"] ?></td>
            <td class="cell-pos2"><?= $row["pos2"] ?></td>
            <td class="cell-seller cell-seller-<?= $row["slid"] ?>"><?= $row["sln"] ?></td>
            <td class="cell-time"><?= $jalali_time ?></td>
            <td class="cell-date"><?= $jalali_date ?></td>
            <td class="cell-dlname"><?= $row["dn"] ?></td>
            <td class="tik-inv-<?= $row["invoice"] ?>"></td>
            <td><?= $row["invoice_number"] ?></td>
            <td class="cell-date"><?= substr($row["invoice_date"], 5) ?></td>
            <td class="tik-anb-<?= $row["anbarenter"] ?>"></td>
            <td class="cell-stock"><?= $row["stn"] ?></td>
            <td class="cell-user"><?= $row["un"] ?></td>
            <td><a onclick="displayModal(this)" id="<?= $row["id"] ?>" class="edit-rec2">ویرایش</a></td>
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
