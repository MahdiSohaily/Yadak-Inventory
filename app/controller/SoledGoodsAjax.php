<?php
require_once "../../config/db_connect.php";


if (isset($_POST['delete_record'])) {
    $record = $_POST['record_id'];

    echo delete_record($record);
}


function delete_record($record)
{
    try {
        $statement = DB_CONNECTION->prepare("DELETE FROM yadakshop1402.exitrecord WHERE id = :id");

        $statement->bindParam(':id', $record);
        $statement->execute();

        return $statement->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}
