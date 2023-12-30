<?php
require_once './config/db_connect.php';

$rates = getPriceRates() ?? [];



function getPriceRates()
{
    $stmt = DB_CONNECTION->prepare("SELECT * FROM shop.rates ORDER BY amount");
    $stmt->execute();
    -$stmt->setFetchMode(PDO::FETCH_ASSOC);

    $result = $stmt->fetchAll();

    return $result;
}
