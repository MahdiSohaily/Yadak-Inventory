<?php

require_once("db.php");

$statement = $con->prepare("SELECT nisha_id, original, fake FROM shop.good_limit ");
$statement->execute();
$result = $statement->get_result();

$records = array();
while ($row = $result->fetch_assoc()) {
    array_push($records, $row);
}

$goods = (array_column($records, 'nisha_id'));
$existing = getStockInfo($con, $goods);


foreach ($records as $index => $row) : 
    $nisha_id = $row['nisha_id'];
    $original_limit = $row['original'];
    $fake = $row['fake'];

    $existing_record = $existing[$nisha_id];
    if ($original_limit > $existing_record['original'] || $fake > $existing_record['fake']) : ?>
        <tr>
            <td class="cell-shakhes "><?= $index + 1 ?></td>
            <td class="cell-code "><?= $row["nisha_id"] ?></td>
            <td class="cell-qty "><?= $original_limit ?></td>
            <td class="cell-qty"><?= $fake ?></td>
            <td class="cell-qty "><?= $existing_record['original'] ?></td>
            <td class="cell-qty "><?= $existing_record['fake'] ?></td>
        </tr>
<?php
    endif;
endforeach;












function getStockInfo($conn, $codes)
{
    $statement = $conn->prepare("SELECT * FROM yadakshop1402.nisha WHERE id = ?");
    $goods = array();
    foreach ($codes as $code) {
        $statement->bind_param('s', $code);
        $statement->execute();
        $record = $statement->get_result();
        $ids = array();
        $item = null;
        while ($result = $record->fetch_assoc()) {
            array_push($ids, $result['id']);
            $item = $result;
        }
        $goods[$code] =  getEntranceRecord($conn, $ids);
    }

    return $goods;
}

function getEntranceRecord($conn, $partNumbers)
{

    $statement = $conn->prepare("SELECT yadakshop1402.qtybank.id, codeid, brand.name AS brand_name, qty, invoice_date, seller.name As seller_name
    FROM (( yadakshop1402.qtybank 
    INNER JOIN yadakshop1402.brand ON brand.id = qtybank.brand )
    INNER JOIN yadakshop1402.seller ON seller.id = qtybank.seller)
    WHERE codeid = ? AND stock_id = ?");

    $data = array();
    foreach ($partNumbers as $partNumber) {
        $stock_id = 1;
        $statement->bind_param('ii', $partNumber, $stock_id);
        $statement->execute();
        $records = $statement->get_result();
        while ($result = $records->fetch_assoc()) {
            array_push($data, $result);
        }
    }

    return getExitRecords($conn, $data);
}

function getExitRecords($conn, $entrance)
{
    $statement = $conn->prepare("SELECT qty FROM yadakshop1402.exitrecord WHERE qtyid = ?");

    $data = array();
    foreach ($entrance as $record) {
        $statement->bind_param('i', $record['id']);
        $statement->execute();
        $records = $statement->get_result();
        $quantity = 0;
        while ($result = $records->fetch_assoc()) {
            $quantity += $result['qty'];
        }
        $record['qty'] -= $quantity;
        if ($record['qty'] > 0) {
            array_push($data, $record);
        }
        // getFinalAmount($result, $record['qty']);
    }
    $derived = getFinalAmount($data);

    $GEN = isset($derived['GEN']) ? $derived['GEN'] : 0;
    $MOB = isset($derived['MOB']) ? $derived['MOB'] : 0;

    $original = $GEN + $MOB;
    $fake = array_sum($derived) - $original;

    return ['original' => $original, 'fake' => $fake];
}

function getFinalAmount($data)
{
    // Create an associative array to store the sum of qty for each brand_name
    $brandQtySum = array();

    // Iterate through the data and sum the qty for each brand_name
    foreach ($data as $record) {
        $brandName = $record["brand_name"];
        $qty = $record["qty"];
        if (array_key_exists($brandName, $brandQtySum)) {
            $brandQtySum[$brandName] += $qty;
        } else {
            $brandQtySum[$brandName] = $qty;
        }
    }

    uasort($brandQtySum, "sortByBrandNameQTY");

    return $brandQtySum;
}

function sortByBrandNameQTY($a, $b)
{
    return $b - $a;
}
