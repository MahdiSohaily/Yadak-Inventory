<?php
session_name("MyAppSession");
session_start();
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

if (isset($_POST['searchForBrand'])) {
    $pattern = '%' . $_POST['pattern'] . '%';

    echo json_encode(searchForBrand($pattern));
}

function searchForBrand($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.brand WHERE name LIKE :pattern");
    $statement->bindParam(':pattern', $pattern);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['searchForReceiver'])) {
    $pattern = '%' . $_POST['pattern'] . '%';

    echo json_encode(searchForReceiver($pattern));
}

function searchForReceiver($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.deliverer WHERE name LIKE :pattern");
    $statement->bindParam(':pattern', $pattern);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['searchForInventory'])) {
    $pattern = '%' . $_POST['pattern'] . '%';

    echo json_encode(searchForInventory($pattern));
}

function searchForInventory($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.stock WHERE name LIKE :pattern");
    $statement->bindParam(':pattern', $pattern);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}







if (isset($_POST['saveFactor'])) {
    $factor_info = json_decode($_POST['factor_info']);
    $factor_items = json_decode($_POST['factor_items']);

    echo json_encode(saveFactor($factor_info, $factor_items));
}

function saveFactor($factor_info, $factor_items)
{
    try {
        // Start a transaction
        DB_CONNECTION->beginTransaction();

        echo json_encode($factor_info);

        $invoice_number = $factor_info->bill_number;
        $seller_id = $factor_info->seller_id;
        $date = $factor_info->date;
        $is_entered = $factor_info->is_entered;
        $has_bill = $invoice_number == null ? 0 : 1;
        echo  $invoice_number == null ? 0 : 1;
        $username = $_SESSION['id'];

        $statement = DB_CONNECTION->prepare("INSERT INTO yadakshop1402.qtybank (codeid, brand, qty, pos1, pos2, des, seller, deliverer, invoice,
        anbarenter, user, invoice_number, stock_id, invoice_date) VALUES 
        (:part_id,  :brand_id, :quantity, :position1, :position2, :description, :seller_id, :deliverer_id, :has_bill,
        :is_entered, :username, :invoice_number, :stock_id, :date)");

        foreach ($factor_items as $item) {
            $part_id = $item->part_id;
            $brand_id = $item->brand_id;
            $quantity = $item->quantity;
            $position1 = $item->position1;
            $position2 = $item->position2;
            $description = $item->description;
            $deliverer_id = $item->deliverer_id;
            $username = $_SESSION['id'];
            $stock_id = $item->inventory_id;

            // Bind parameters
            $statement->bindParam(':part_id', $part_id);
            $statement->bindParam(':brand_id', $brand_id);
            $statement->bindParam(':quantity', $quantity);
            $statement->bindParam(':position1', $position1);
            $statement->bindParam(':position2', $position2);
            $statement->bindParam(':description', $description);
            $statement->bindParam(':seller_id', $seller_id);
            $statement->bindParam(':deliverer_id', $deliverer_id);
            $statement->bindParam(':has_bill', $has_bill);
            $statement->bindParam(':is_entered', $is_entered);
            $statement->bindParam(':username', $username);
            $statement->bindParam(':invoice_number', $invoice_number);
            $statement->bindParam(':stock_id', $stock_id);
            $statement->bindParam(':date', $date);

            $statement->execute();
        }

        // Commit the transaction if all queries are successful
        DB_CONNECTION->commit();

        // Optionally, you can return a success message or handle the result as needed.
        return "Factor saved successfully!";
    } catch (PDOException $e) {
        // Rollback the transaction in case of any error
        DB_CONNECTION->rollBack();

        // Handle any exceptions that may occur during the database operation.
        return "Error: " . $e->getMessage();
    }
}
