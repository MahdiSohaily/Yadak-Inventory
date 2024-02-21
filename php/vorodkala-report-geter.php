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

$sql = "SELECT qtybank.id AS purchase_id,
qtybank.des As purchase_description,
qtybank.qty AS purchase_quantity,
qtybank.pos1 AS purchase_position1,
qtybank.pos2 AS purchase_position2,
qtybank.create_time AS purchase_time,
qtybank.anbarenter AS purchase_isEntered,
qtybank.invoice AS purchase_hasBill,
qtybank.invoice_number,
qtybank.invoice_date,
nisha.partnumber,
nisha.price AS good_price,
seller.id AS seller_id,
seller.name AS seller_name,
brand.name AS brand_name,
deliverer.name AS deliverer_name,
users.username AS username,
stock.name AS stock_name
FROM qtybank
INNER JOIN nisha ON qtybank.codeid = nisha.id
INNER JOIN brand ON qtybank.brand = brand.id
LEFT JOIN seller ON qtybank.seller = seller.id
LEFT JOIN deliverer ON qtybank.deliverer = deliverer.id
LEFT JOIN users ON qtybank.user = users.id
LEFT JOIN stock ON qtybank.stock_id = stock.id 
$condition
AND qtybank.is_transfered = 0
ORDER BY qtybank.create_time DESC";

$result = $con->query($sql);

$purchaseList = [];

while ($row = $result->fetch_assoc()) {
    array_push($purchaseList, $row);
}

$counter = 1;

foreach ($purchaseList as $item) :
    $date = $item["purchase_time"];
    $array = explode(' ', $date);
    list($year, $month, $day) = explode('-', $array[0]);
    list($hour, $minute, $second) = explode(':', $array[1]);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
    $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");
?>
    <tr class="left_right">
        <td class="cell-shakhes"><?= $counter ?></td>
        <td class="cell-code" style="mso-number-format:\@;"><?= "&#8203;" . strtoupper($item["partnumber"]) ?></td>
        <td class="cell-brand cell-brand-<?= $item['brand_name'] ?>"><?= $item["brand_name"] ?></td>
        <td class="cell-des"><?= $item["purchase_description"] ?></td>
        <td class="cell-qty"><?= $item["purchase_quantity"] ?></td>
        <td class="cell-pos1"><?= $item["purchase_position1"] ?></td>
        <td class="cell-pos2"><?= $item["purchase_position2"] ?></td>
        <td class="cell-seller cell-seller-<?= $item["seller_id"] ?>"><?= $item["seller_name"] ?></td>
        <td class="cell-time"><?= $jalali_time ?></td>
        <td class="cell-date"><?= $jalali_date ?></td>
        <td class="cell-dlname"><?= $item["deliverer_name"] ?></td>
        <td class="tik-inv-<?= $item["purchase_hasBill"] ?>"></td>
        <td><?= $item["invoice_number"] ?></td>
        <td class="cell-date"><?= substr($item["invoice_date"], 5) ?></td>
        <td class="tik-anb-<?= $item["purchase_isEntered"] ?>"></td>
        <td class="cell-stock"><?= $item["stock_name"] ?></td>
        <td class="cell-user"><?= $item["username"] ?></td>
        <td style="display: flex; justify-content: center; margin-block: 15px">
            <a onclick="displayModal(this)" id="<?= $item["purchase_id"] ?>" class="edit-rec2"><i class="fa fa-pen" aria-hidden="true"></i></a>
        </td>
    </tr>


<?php
    $counter++;
endforeach; ?>