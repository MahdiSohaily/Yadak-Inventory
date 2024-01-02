<?php
require_once("./php/db.php");
date_default_timezone_set('Asia/Tehran');

$partNumber = $_POST['partNumber'];

// Prepare the statement
$stmt = $pdo->prepare("SELECT
nisha.partnumber,
users.username AS username,
seller.name AS sellerName,
stock.name AS stockName,
brand.name AS brandName,
exitrecord.qty As quantity,
exitrecord.customer,
exitrecord.des AS description,
exitrecord.exit_time AS create_time,
exitrecord.invoice_number,
exitrecord.invoice_date
FROM
qtybank
INNER JOIN
nisha ON qtybank.codeid = nisha.id
INNER JOIN
exitrecord ON qtybank.id = exitrecord.qtyid
LEFT JOIN
seller ON qtybank.seller = seller.id
LEFT JOIN
brand ON qtybank.brand = brand.id
LEFT JOIN
stock ON qtybank.stock_id = stock.id
LEFT JOIN
users ON exitrecord.user = users.id
LEFT JOIN
deliverer ON qtybank.deliverer = deliverer.id
LEFT JOIN
getter ON exitrecord.getter = getter.id
WHERE
(nisha.partnumber = :partNumber)
ORDER BY
exitrecord.exit_time DESC,
exitrecord.invoice_number DESC");

$stmt->bindParam(':partNumber', $partNumber, PDO::PARAM_STR);
$stmt->execute();
$result1 = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result1 = $stmt->fetchAll();

// Second Query
$stmt = $pdo->prepare("SELECT
    nisha.partnumber,
    brand.name AS brandName,
    qtybank.des AS description,
    qtybank.qty AS quantity,
    qtybank.create_time,
    seller.name AS sellerName,
    users.username AS username,
    qtybank.invoice_number,
    qtybank.invoice_date,
    stock.name AS stockName
FROM
    qtybank
LEFT JOIN
    nisha ON qtybank.codeid = nisha.id
LEFT JOIN
    brand ON qtybank.brand = brand.id
LEFT JOIN
    seller ON qtybank.seller = seller.id
LEFT JOIN
    deliverer ON qtybank.deliverer = deliverer.id
LEFT JOIN
    users ON qtybank.user = users.id
LEFT JOIN
    stock ON qtybank.stock_id = stock.id
WHERE
    (nisha.partnumber = :partNumber)
ORDER BY
    qtybank.create_time DESC");  // Sort by create_time

// Bind the parameters
$parameter = $partNumber;
$stmt->bindParam(':partNumber', $parameter, PDO::PARAM_STR);

$stmt->execute();

// Set the resulting array to associative
$result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Modify $result1 array
foreach ($result1 as &$item) {
    $item['export'] = true;
}

// Modify $result2 array
foreach ($result2 as &$item) {
    $item['import'] = true;
}

// Note: Always unset the reference after using it to avoid any unintended side effects
unset($item);


// Combine the results into one array
$combinedResult = array_merge($result1, $result2);

// Custom sorting function to compare create_time and exit_time
usort($combinedResult, function ($a, $b) {
    return strtotime($b['create_time']) - strtotime($a['create_time']);
});

// Output the combined result as JSON
echo json_encode($combinedResult);
