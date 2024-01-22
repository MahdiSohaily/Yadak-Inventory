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
