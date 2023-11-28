<?php
require_once '../../config/db_connect.php';
if (filter_has_var(INPUT_POST, 'toggle')) {

    DB_CONNECTION->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = DB_CONNECTION->prepare("SELECT * FROM shop.tv WHERE id='1'");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $status = $stmt->fetch()['status'];
    $sql = null;
    if ($status == 'on') {
        $sql = "UPDATE shop.tv SET status= 'off' WHERE id = '1'";
    } else {
        $sql = "UPDATE shop.tv SET status= 'on' WHERE id = '1'";
    }
    $stmt = DB_CONNECTION->prepare($sql);
    $stmt->execute();
}
