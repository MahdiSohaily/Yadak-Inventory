<?php
require_once("../../php/db.php");

if (isset($_POST['getSelectedRecordToEdit'])) {
    $purchase_id = $_POST['recordId'];
    $record = getRecord($con, $purchase_id);
    print_r(json_encode($record));
}


function getRecord($con, $record_id)
{

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
    WHERE qtybank.id = '$record_id'
    ORDER BY qtybank.create_time DESC";

    $result = $con->query($sql);

    $purchaseList = [];

    while ($row = $result->fetch_assoc()) {
        array_push($purchaseList, $row);
    }
    return $purchaseList[0];
}
