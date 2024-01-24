<?php
require_once("db.php");


$data =  getSellers2();
function getSellers2()
{
    $statement = PDO_CONNECTION->prepare("SELECT id, name, latinName FROM yadakshop1402.seller");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
