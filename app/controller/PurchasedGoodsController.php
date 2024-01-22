<?php
require_once("./config/db_connect.php");

if (isset($_GET['interval'])) {
    $interval = $_GET['interval'];
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

    $purchaseList = getPurchaseReport($condition);
}

function getPurchaseReport($condition)
{
    $statement = DB_CONNECTION->prepare("SELECT qtybank.id AS purchase_id,
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
            ORDER BY qtybank.create_time DESC");

    $statement->execute();
    return $statement->fetchAll();
}

if (isset($_POST['searchForSeller'])) {
    $pattern = $_POST['pattern'];

    echo json_encode(searchForSeller($pattern));
}

function searchForSeller($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT name FROM yadakshop1402.seller WHERE name LIKE :name");
    $statement->bindParam(':name', $pattern);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
