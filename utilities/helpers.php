<?php

function getBrands()
{
    $statement = DB_CONNECTION->prepare("SELECT * FROM yadakshop1402.brand");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getSellers()
{
    $statement = DB_CONNECTION->prepare("SELECT id, name, latinName FROM yadakshop1402.seller");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getStocks()
{
    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.stock");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getDeliverers()
{
    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.deliverer");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
