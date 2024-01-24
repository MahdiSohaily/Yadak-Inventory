<?php
require_once("db.php");


$data =  getSellers();
function getSellers()
{
    $statement = PDO_CONNECTION->prepare("SELECT id, name, latinName FROM yadakshop1402.seller");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
