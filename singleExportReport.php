<?php
require_once("./php/db.php");
date_default_timezone_set('Asia/Tehran');

$partNumber = $_POST['partNumber'];

// Prepare the statement
$stmt = $pdo->prepare("SELECT
nisha.partnumber,
qtybank.des,
nisha.id,
users.username AS usn,
seller.name,
seller.id AS slid,
stock.name AS stn,
brand.name AS brn,
qtybank.qty,
qtybank.id AS qtyid,
exitrecord.qty AS extqty,
exitrecord.id AS exid,
qtybank.qty AS entqty,
exitrecord.customer,
exitrecord.des AS exdes,
getter.name AS gtn,
deliverer.name AS dln,
exitrecord.exit_time,
exitrecord.jamkon,
exitrecord.invoice_number,
qtybank.invoice_number AS qty_invoice_number,
exitrecord.invoice_date,
qtybank.invoice_date AS qty_invoice_date,
qtybank.anbarenter
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

$parameter = $partNumber;
$stmt->bindParam(':partNumber', $parameter, PDO::PARAM_STR);

$stmt->execute();

// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();


echo (json_encode($result));
