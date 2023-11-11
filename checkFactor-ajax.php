<?php
session_name("MyAppSession");
require_once("./php/db.php");
date_default_timezone_set('Asia/Tehran');


if (isset($_POST["bill_number"])) {

    $bill_number = $_POST["bill_number"];

    // Prepare the statement
    $stmt = $pdo->prepare("SELECT * FROM callcenter.shomarefaktor WHERE shomare = :shomarefaktor");

    // Bind the parameters
    $stmt->bindParam(':shomarefaktor', $bill_number, PDO::PARAM_STR);

    $stmt->execute();

    // set the resulting array to associative
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    header("content-type: application/json");
    echo json_encode($stmt->fetchAll()[0]);
}
