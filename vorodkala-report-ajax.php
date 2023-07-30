<?php
require_once("./php/db.php");

print_r(json_encode($_POST));

$partNumber = $_POST['partNumber'] === 'null' ? null : $_POST['partNumber']; // Assuming you're retrieving the value from a form
$seller_id = $_POST['seller'] === 'null' ? null : $_POST['seller'];
$brand_id = $_POST['brand'] === 'null' ? null : $_POST['brand'];
$pos1 = $_POST['pos1'] === 'null' ? null : $_POST['pos1'];
$pos2 = $_POST['pos2'] === 'null' ? null : $_POST['pos2'];
$stock_id = $_POST['stock'] === 'null' ? null : $_POST['stock'];
$user_id = $_POST['user'] === 'null' ? null : $_POST['user'];
$invoice_number = $_POST['invoice_number'] === 'null' ? null : $_POST['invoice_number'];
$invoice_date = $_POST['invoice_time'] === 'null' ? null : $_POST['invoice_time'];// Assuming you're retrieving the value from a form

// Prepare the statement
$stmt = $pdo->prepare("SELECT nisha.partnumber ,nisha.price AS nprice,seller.id AS slid, brand.name , qtybank.des ,qtybank.id, qtybank.qty , qtybank.pos1 , qtybank.pos2 , qtybank.create_time , seller.name AS sln, deliverer.name AS dn , qtybank.anbarenter ,qtybank.invoice , users.username AS un , qtybank.invoice_number,qtybank.invoice_date ,stock.name AS stn
                        FROM qtybank
                        LEFT JOIN nisha ON qtybank.codeid=nisha.id
                        LEFT JOIN brand ON qtybank.brand=brand.id
                        LEFT JOIN seller ON qtybank.seller=seller.id
                        LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
                        LEFT JOIN users ON qtybank.user=users.id
                        LEFT JOIN stock ON qtybank.stock_id=stock.id 
                        WHERE (nisha.partnumber = :partNumber OR :partNumber IS NULL)
                        AND (qtybank.seller = :seller_id OR :seller_id IS NULL)
                        AND (brand.id = :brand_id OR :brand_id IS NULL)
                        AND (qtybank.pos1 = :pos1 OR :pos1 IS NULL)
                        AND (qtybank.pos2 = :pos2 OR :pos2 IS NULL)
                        AND (qtybank.stock_id = :stock_id OR :stock_id IS NULL)
                        AND (qtybank.user = :user_id OR :user_id IS NULL)
                        AND (qtybank.invoice_number = :invoice_number OR :invoice_number IS NULL)
                        AND (qtybank.invoice_date = :invoice_date OR :invoice_date IS NULL)
                        ORDER BY qtybank.create_time DESC");

// Bind the parameters
$stmt->bindParam(':partNumber', $partNumber, PDO::PARAM_STR);
$stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
$stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
$stmt->bindParam(':invoice_number', $invoice_number, PDO::PARAM_STR);
$stmt->bindParam(':pos1', $pos1, PDO::PARAM_STR);
$stmt->bindParam(':pos2', $pos2, PDO::PARAM_STR);
$stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);

$stmt->execute();

// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
