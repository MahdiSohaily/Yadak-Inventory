<?php
require_once '../../config/db_connect.php';

$todays_records = getTodayRecords();
$previous_records = getPreviousRecords();
// Create a DateTime object for today
$today = new DateTime();

// Subtract one day
$yesterday = $today;

// Format and display the result
$yesterday = $yesterday->format('Y-m-d') . ' 00:00:00';


function getTodayRecords()
{
    global $yesterday;

    $statement = DB_CONNECTION->prepare("SELECT transfer_record.*, qtybank.qty AS previous_amount,
        nisha.partnumber, brand.name As brand_name, seller.name AS seller_name, getter.name AS getter_name,
        users.name AS user_name, qtybank.stock_id, exitrecord.des
        FROM transfer_record
        INNER JOIN qtybank ON qtybank.id =  transfer_record.affected_record
        INNER JOIN nisha ON nisha.id = qtybank.codeid
        INNER JOIN exitrecord ON exitrecord.id  = transfer_record.exit_id
        LEFT JOIN brand ON brand.id = qtybank.brand
        LEFT JOIN seller ON seller.id = qtybank.seller
        LEFT JOIN getter ON getter.id = exitrecord.getter
        INNER JOIN users ON users.id = transfer_record.user_id
        WHERE transfer_record.transfer_date > :transfer_date
        ORDER BY transfer_record.transfer_date DESC");
    $statement->bindParam(':transfer_date', $yesterday);
    $statement->execute();

    // set the resulting array to associative
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $today =  $statement->fetchAll();
    return $today;
}

function getPreviousRecords()
{
    global $yesterday;

    $statement = DB_CONNECTION->prepare("SELECT transfer_record.*, qtybank.qty AS previous_amount,
        nisha.partnumber, brand.name As brand_name, seller.name AS seller_name, getter.name AS getter_name,
        users.name AS user_name, qtybank.stock_id, exitrecord.des
        FROM transfer_record
        INNER JOIN qtybank ON qtybank.id =  transfer_record.affected_record
        INNER JOIN nisha ON nisha.id = qtybank.codeid
        INNER JOIN exitrecord ON exitrecord.id  = transfer_record.exit_id
        LEFT JOIN brand ON brand.id = qtybank.brand
        LEFT JOIN seller ON seller.id = qtybank.seller
        LEFT JOIN getter ON getter.id = exitrecord.getter
        INNER JOIN users ON users.id = transfer_record.user_id
        WHERE transfer_record.transfer_date < :transfer_date
        ORDER BY transfer_record.transfer_date DESC");
    $statement->bindParam(':transfer_date', $yesterday);
    $statement->execute();

    // set the resulting array to associative
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $today =  $statement->fetchAll();
    return $today;
}
