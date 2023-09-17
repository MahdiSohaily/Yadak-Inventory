<?php

require_once("db.php");

$statement = $con->prepare("SELECT pattern_id, original, fake FROM shop.good_limit_all WHERE pattern_id != 'null'");
$statement->execute();
$result = $statement->get_result();

$relations = array();
while ($row = $result->fetch_assoc()) {
    array_push($relations, $row);
}

print_r($relations);


$statement = $con->prepare("SELECT nisha_id FROM shop.similars WHERE pattern_id= ?");
$statement->bind_param('i', $result['pattern_id']);
$statement->execute();
$result = $statement->get_result();


$records = array();
while ($row = $result->fetch_assoc()) {
    array_push($records, $row);
}

$goods = array_column($records, 'nisha_id');

$existing = getStockInfo($con, $goods);

print_r($existing);















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
