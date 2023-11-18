<?php
require_once("db.php");

$relationALL = $con->prepare("SELECT pattern_id, original, fake FROM shop.good_limit_all WHERE pattern_id IS NOT NULL AND nisha_id IS NULL");
$relationALL->execute();
$result = $relationALL->get_result();

$relations = array();
while ($row = $result->fetch_assoc()) {
    array_push($relations, $row);
}

$needToMove = array();
foreach ($relations as $relation) {
    $patter_id = $relation['pattern_id'];
    $original = $relation['original'];
    $fake = $relation['fake'];

    $similar = $con->prepare("SELECT nisha_id FROM shop.similars WHERE pattern_id= ?");
    $similar->bind_param('i', $patter_id);
    $similar->execute();
    $result = $similar->get_result();

    $records = array();
    while ($row = $result->fetch_assoc()) {
        array_push($records, $row);
    }

    $goods = array_column($records, 'nisha_id');

    if (count($goods) > 0) {
        $existing = getStockInfo($con, $goods);
        // Initialize a variable to store the sum
        $sumOriginal = 0;
        $sumFake = 0;
        foreach ($existing as $item) {
            $sumOriginal += intval($item['original']);
            $sumFake += intval($item['fake']);
        }

        if ($sumOriginal < $original || $sumFake < $fake) {

            $needToMove[$patter_id]['goods'] = $existing;
            $needToMove[$patter_id]['original'] = $original;
            $needToMove[$patter_id]['fake'] = $fake;
            $needToMove[$patter_id]['sumOriginal'] = $sumOriginal;
            $needToMove[$patter_id]['sumFake'] = $sumFake;
            $needToMove[$patter_id]['IsSingle'] = false;
        }
    }
}



$singleGoods = $con->prepare("SELECT nisha_id, original, fake FROM shop.good_limit_all WHERE pattern_id IS  NULL AND nisha_id IS NOT NULL");
$singleGoods->execute();
$records = $singleGoods->get_result();

$goods = array();
while ($row = $records->fetch_assoc()) {
    array_push($goods, $row);
}

$singleItems = array();
foreach ($goods as $good) {
    $patter_id = $good['nisha_id'];
    $original = $good['original'];
    $fake = $good['fake'];
    $existing = getStockInfo($con, [$good['nisha_id']]);

    $sumOriginal = intval(current($existing)['original']);
    $sumFake = intval(current($existing)['fake']);

    if ($sumOriginal < $original || $sumFake < $fake) {
        $needToMove[$patter_id]['goods'] = $existing;
        $needToMove[$patter_id]['original'] = $original;
        $needToMove[$patter_id]['fake'] = $fake;
        $needToMove[$patter_id]['sumOriginal'] = $sumOriginal;
        $needToMove[$patter_id]['sumFake'] = $sumFake;
        $needToMove[$patter_id]['IsSingle'] = true;
    }
}



















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
    WHERE codeid = ?");

    $data = array();
    foreach ($partNumbers as $partNumber) {
        $statement->bind_param('i', $partNumber);
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

function getPartNumber($id)
{
    $statement = PDO_CONNECTION->prepare("SELECT partnumber FROM nisha WHERE id = :id");
    $statement->bindParam(":id", $id);
    $statement->execute();
    $result = $statement->setFetchMode(PDO::FETCH_ASSOC);

    $result = $statement->fetch();
    return $result['partnumber'];
}

function getRelationInfo($id)
{
    $statement = PDO_CONNECTION->prepare("SELECT name FROM shop.patterns WHERE id = :id");
    $statement->bindParam(":id", $id);
    $statement->execute();
    $result = $statement->setFetchMode(PDO::FETCH_ASSOC);

    $result = $statement->fetch();
    return array_key_exists('name', $result) ? $result['name'] : 'Hello';
}
