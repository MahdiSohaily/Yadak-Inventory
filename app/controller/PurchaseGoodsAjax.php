<?php
require_once "../../config/db_connect.php";


if (isset($_POST['delete_record'])) {
    $record = $_POST['record_id'];

    echo delete_record($record);
}


function delete_record($record)
{
    try {
        $statement = DB_CONNECTION->prepare("DELETE FROM yadakshop1402.qtybank WHERE id = :id");

        $statement->bindParam(':id', $record);
        $statement->execute();

        return $statement->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

if (isset($_POST['searchForSeller'])) {
    $pattern = '%' . $_POST['pattern'] . '%';

    echo json_encode(searchForSeller($pattern));
}

function searchForSeller($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.seller WHERE name LIKE :name");
    $statement->bindParam(':name', $pattern);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['searchForPart'])) {
    $pattern = $_POST['pattern'] . '%';

    echo json_encode(searchForPart($pattern));
}

function searchForPart($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT id, partnumber FROM yadakshop1402.nisha WHERE partnumber LIKE :pattern");
    $statement->bindParam(':pattern', $pattern);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['searchForBrand'])) {
    $pattern = '%' . $_POST['pattern'] . '%';

    echo json_encode(searchForBrand($pattern));
}

function searchForBrand($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.brand WHERE name LIKE :pattern");
    $statement->bindParam(':pattern', $pattern);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['saveFactor'])) {
    $factor_info = json_decode($_POST['factor_info']);
    $factor_items = json_decode($_POST['factor_items']);

    echo json_encode(saveFactor($factor_info, $factor_items));
}

function saveFactor($factor_info, $factor_items)
{
    
    $bill_number = $factor_info['bill_number'];
    $seller_id = $factor_info['seller_id'];
    $date = $factor_info['date'];
    $is_entered = $factor_info['is_entered'];
    $has_bill = $factor_info['bill_number'] == null ? false : true;

    $sql = "INSERT INTO yadakshop1402.qtybank (codeid,brand,qty,pos1,pos2,des,seller,deliverer,invoice,anbarenter,user,invoice_number,stock_id,invoice_date) VALUES ('$value1', '$value2', '$value3', '$value4','$value5','$value6','$value7','$value8','$value9','$value10','$value11','$value12','$value13','$value14');";


    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.brand WHERE name LIKE :pattern");
    $statement->bindParam(':pattern', $pattern);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
