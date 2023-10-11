<?php
require_once('./php/db.php');

if (isset($_POST['value']) && !empty($_POST['value'])) {
    echo json_encode(checkBillNumber($con, $_POST['value']));
}
function checkBillNumber($con, $billNumber)
{
    $statement = "SELECT * FROM callcenter.shomarefaktor WHERE shomare = '$billNumber'";

    $result = $con->query($statement);
    $row = $result->fetch_assoc();
    return $row;
}
