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

$partNumber = $_POST['partNumber'];
// Prepare the statement
$stmt = $pdo->prepare("SELECT nisha.partnumber ,nisha.price AS nprice,seller.id AS slid,
                                brand.name , qtybank.des ,qtybank.id, qtybank.qty , qtybank.pos1,
                                qtybank.pos2 , qtybank.create_time , seller.name AS sln, deliverer.name AS dn,
                                qtybank.anbarenter ,qtybank.invoice , users.username AS un , qtybank.invoice_number,
                                qtybank.invoice_date ,stock.name AS stn
                        FROM qtybank
                        LEFT JOIN nisha ON qtybank.codeid=nisha.id
                        LEFT JOIN brand ON qtybank.brand=brand.id
                        LEFT JOIN seller ON qtybank.seller=seller.id
                        LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
                        LEFT JOIN users ON qtybank.user=users.id
                        LEFT JOIN stock ON qtybank.stock_id=stock.id 
                        WHERE (nisha.partnumber = :partNumber)
                        ORDER BY qtybank.create_time DESC");

// Bind the parameters
$parameter = $partNumber;
$stmt->bindParam(':partNumber', $parameter, PDO::PARAM_STR);
$stmt->execute();

// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll();

echo json_encode($result);