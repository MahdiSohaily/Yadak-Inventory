<?php
require_once("./php/db.php");

if (isset($_GET['interval'])) {
    $interval = $_GET['interval'];
}

if (isset($interval)) {
    date_default_timezone_set('Asia/Tehran');
    // Get today's date
    $todayDate = date('Y-m-d');

    // Calculate the date from 10 days ago
    $previousDate = date('Y-m-d', strtotime('-' . $interval . ' days'));

    $todayDate .= " 23:00:00";
    $previousDate .= " 00:00:00";

    $condition = " WHERE exitrecord.exit_time >= '$previousDate'
    AND exitrecord.exit_time <= '$todayDate'";
} else {
    $condition = 'WHERE 1=1';
}

$sql = "SELECT qtybank.id AS purchase_id,
        qtybank.des AS purchase_description,
        qtybank.qty AS purchase_quantity,
        qtybank.anbarenter AS purchase_isEntered,
        qtybank.invoice_number AS qty_invoice_number,
        qtybank.invoice_date AS qty_invoice_date,
        nisha.id AS partNumber_id,
        nisha.partnumber,
        users.username AS username,
        seller.id AS seller_id,
        seller.name AS seller_name,
        stock.name AS stock_name,
        brand.name AS brand_name,
        exitrecord.qty AS sold_quantity,
        exitrecord.id AS sold_id,
        exitrecord.customer AS sold_customer,
        exitrecord.des AS sold_description,
        exitrecord.exit_time AS sold_time,
        exitrecord.jamkon,
        exitrecord.invoice_number AS sold_invoice_number,
        exitrecord.invoice_date AS sold_invoice_date,
        getter.id AS getter_id,
        getter.name AS getter_name,
        deliverer.id AS deliverer_id,
        deliverer.name AS deliverer_name,
        callcenter.shomarefaktor.kharidar AS customer
        FROM qtybank
        INNER JOIN nisha ON qtybank.codeid = nisha.id
        INNER JOIN exitrecord ON qtybank.id = exitrecord.qtyid
        LEFT JOIN seller ON qtybank.seller = seller.id
        LEFT JOIN brand ON qtybank.brand = brand.id
        LEFT JOIN stock ON qtybank.stock_id = stock.id
        LEFT JOIN users ON exitrecord.user = users.id
        LEFT JOIN deliverer ON qtybank.deliverer = deliverer.id
        LEFT JOIN getter ON exitrecord.getter = getter.id
        LEFT JOIN callcenter.shomarefaktor ON exitrecord.invoice_number = shomarefaktor.shomare
        $condition
        AND exitrecord.is_transfered = 0
        ORDER BY  exitrecord.exit_time DESC";
        
$result = $con->query($sql);

$soldItemsList = [];

while ($row = $result->fetch_assoc()) {
    array_push($soldItemsList, $row);
}
