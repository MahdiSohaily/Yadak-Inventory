<?php
require_once("db.php");

$action = isset($_POST['action']) ? $_POST['action'] : 'normal';
$customer = isset($_POST['customer']) ? $_POST['customer'] : 'انتقال به انبار';
$getter = $_POST['getter'];
$id = $_SESSION["id"];
$invoice_number = isset($_POST['invoice_number']) ? $_POST['invoice_number'] : 'انتقال به انبار';
$description = $_POST['des'];
$collector = $_POST['jamkon'];
$invoice_time = $_POST['invoice_time'];
$stock = $_POST['stock'];


$x = 0;
foreach ($_POST['qty'] as $value) {
    $qty = $value;
    $qty_id = $_POST['qtyid'][$x];
    $x++;

    $sql = "INSERT INTO exitrecord (customer,getter,qty,qtyid,user,invoice_number,des,jamkon,invoice_date) VALUES ('$customer', '$getter', '$qty', '$qty_id','$id','$invoice_number','$description','$collector','$invoice_time');";
    $result = mysqli_query($con, $sql);

    $exit_id = mysqli_insert_id($con);

    if ($action == 'move') {
        $info = get_entered_Info($qty_id);
        $Bank_id = save_new_entrance($info, $stock, $qty);
        record_transaction($qty_id, $Bank_id, $exit_id, $qty, $stock);
    }

    if (!$result) {
        echo "Error MySQLI QUERY: " . mysqli_error($con) . "";
        die();
    } else {
        $var = 1;
    }
}
if ($var == 1) {

    echo '<p class="ok"> تعداد <span>' . $x . '</span> آیتم کالا برای خریدار <span>' . $customer . '</span> با موفقیت از انبار خارج شد </p>';
}

mysqli_close($con);

function get_entered_Info($qty_id)
{
    $statement = PDO_CONNECTION->prepare("SELECT * FROM qtybank WHERE id = :qty_id");
    $statement->bindParam(':qty_id', $qty_id);
    $statement->execute();
    $result = $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result = $statement->fetch();
    return $result;
}

function save_new_entrance($info, $stock, $quantity)
{
    $codeId = $info['codeid'];
    $brand = $info['brand'];
    $quantity = $quantity;
    $pos1 = $info['pos1'];
    $pos2 = $info['pos2'];
    $des = $info['des'];
    $seller = $info['seller'];
    $deliverer = $info['deliverer'];
    $invoice = $info['invoice'];
    $anbarenter = $info['anbarenter'];
    $user_id = $_SESSION["id"];
    $invoice_number = $info['invoice_number'];
    $invoice_time = $info['invoice_date'];

    $statement = PDO_CONNECTION->prepare("INSERT INTO qtybank (codeid, brand, qty, pos1, pos2, des, seller, deliverer, invoice, anbarenter, user, invoice_number, stock_id, invoice_date)
    VALUES (:codeId, :brand, :quantity, :pos1, :pos2, :description, :seller, :deliverer, :invoice, :anbarenter, :user_id, :invoice_number, :stock, :invoice_time)");

    $statement->bindParam(':codeId', $codeId);
    $statement->bindParam(':brand', $brand);
    $statement->bindParam(':quantity', $quantity);
    $statement->bindParam(':pos1', $pos1);
    $statement->bindParam(':pos2', $pos2);
    $statement->bindParam(':description', $des);
    $statement->bindParam(':seller', $seller);
    $statement->bindParam(':deliverer', $deliverer);
    $statement->bindParam(':invoice', $invoice);
    $statement->bindParam(':anbarenter', $anbarenter);
    $statement->bindParam(':user_id', $user_id);
    $statement->bindParam(':invoice_number', $invoice_number);
    $statement->bindParam(':stock', $stock);
    $statement->bindParam(':invoice_time', $invoice_time);

    $statement->execute();
    return PDO_CONNECTION->lastInsertId();
}

function record_transaction($affected_record, $Bank_id, $exit_id, $quantity, $stock)
{
    $statement = PDO_CONNECTION->prepare("INSERT INTO transfer_record (affected_record, qtybanck_id , exit_id, stock, user_id, quantity)
    VALUES (:affected_record, :qtybanck_id, :exit_id, :stock, :user_id, :quantity)");

    $statement->bindParam(':affected_record', $affected_record);
    $statement->bindParam(':qtybanck_id', $Bank_id);
    $statement->bindParam(':exit_id', $exit_id);
    $statement->bindParam(':stock', $stock);
    $statement->bindParam(':user_id', $_SESSION["id"]);
    $statement->bindParam(':quantity', $quantity);

    $statement->execute();
    return PDO_CONNECTION->lastInsertId();
}
