<?php
require_once("db.php");

// Create a DateTime object for today
$today = new DateTime();

// Subtract one day
$yesterday = $today;

// Format and display the result
$yesterday = $yesterday->format('Y-m-d') . ' 00:00:00';

try {
    $statement = PDO_CONNECTION->prepare("SELECT transfer_record.*, qtybank.qty AS previous_amount,
    nisha.partnumber, brand.name As brand_name, seller.name AS seller_name, getter.name AS getter_name,
    users.name AS user_name, qtybank.stock_id, exitrecord.des
    FROM transfer_record
    INNER JOIN qtybank ON qtybank.id =  transfer_record.affected_record
    INNER JOIN nisha ON nisha.id = qtybank.codeid
    INNER JOIN exitrecord ON exitrecord.id  = transfer_record.exit_id
    LEFT JOIN brand ON brand.id = qtybank.brand
    LEFT JOIN seller ON seller.id = qtybank.seller
    LEFT JOIN getter ON getter.id = exitrecord.getter
    INNER JOIN users ON users.id = transfer_record.user_id
    WHERE transfer_record.transfer_date > :transfer_date
    ORDER BY transfer_record.transfer_date DESC");
    $statement->bindParam(':transfer_date', $yesterday);
    $statement->execute();

    // set the resulting array to associative
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $today =  $statement->fetchAll();
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
?>
<tr style="margin-block: 10px !important; background-color: #dae5eb;">
    <td colspan="13">عملیات روزهای امروز</td>
</tr>
<?php

foreach ($today as $index => $result) : ?>
    <tr>
        <td class="cell-shakhes"><?= $index + 1 ?></td>
        <td class="cell-code "><?= '&nbsp;' . $result["partnumber"] ?></td>
        <td class="cell-brand cell-brand-<?= $result["brand_name"] ?> "><?= $result["brand_name"] ?></td>
        <td class="cell-des "><?= $result["des"] ?></td>
        <td class="cell-pos1 "><?= getStockName($result["stock_id"]) ?></td>
        <td class="cell-qty "><?= $result["prev_quantity"] ?></td>
        <td class="cell-pos1 "><?= getStockName($result["stock"]) ?></td>
        <td class="cell-pos1 "><?= $result["quantity"] ?></td>
        <td class="cell-pos2 "><?= $result["seller_name"] ?></td>
        <td class="cell-pos2 "><?= $result["getter_name"] ?></td>
        <td class="cell-pos2 "><?= $result["transfer_date"] ?></td>
        <td class="cell-user "><?= $result["user_name"] ?></td>
        <td class="cell-shakhes" style="width:5px">
            <input type="checkbox" name="select for print" id="select">
        </td>
    </tr>
<?php endforeach;

try {
    $statement = PDO_CONNECTION->prepare("SELECT transfer_record.*, qtybank.qty AS previous_amount,
    nisha.partnumber, brand.name As brand_name, seller.name AS seller_name, getter.name AS getter_name,
    users.name AS user_name, qtybank.stock_id, exitrecord.des
    FROM transfer_record
    INNER JOIN qtybank ON qtybank.id =  transfer_record.affected_record
    INNER JOIN nisha ON nisha.id = qtybank.codeid
    INNER JOIN exitrecord ON exitrecord.id  = transfer_record.exit_id
    LEFT JOIN brand ON brand.id = qtybank.brand
    LEFT JOIN seller ON seller.id = qtybank.seller
    LEFT JOIN getter ON getter.id = exitrecord.getter
    INNER JOIN users ON users.id = transfer_record.user_id
    WHERE transfer_record.transfer_date > :transfer_date
    ORDER BY transfer_record.transfer_date DESC");
    $statement->bindParam(':transfer_date', $yesterday);
    $statement->execute();

    // set the resulting array to associative
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $today =  $statement->fetchAll();
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

?>
<tr style="background-color: transparent;">
    <td colspan="13"></td>
</tr>
<tr style="margin-block: 10px !important; background-color: #dae5eb;">
    <td colspan="13">عملیات روزهای قبل</td>
</tr>
<?php

foreach ($today as $index => $result) : ?>
    <tr>
        <td class="cell-shakhes"><?= $index + 1 ?></td>
        <td class="cell-code "><?= '&nbsp;' . $result["partnumber"] ?></td>
        <td class="cell-brand cell-brand-<?= $result["brand_name"] ?> "><?= $result["brand_name"] ?></td>
        <td class="cell-des "><?= $result["des"] ?></td>
        <td class="cell-pos1 "><?= getStockName($result["stock_id"]) ?></td>
        <td class="cell-qty "><?= $result["prev_quantity"] ?></td>
        <td class="cell-pos1 "><?= getStockName($result["stock"]) ?></td>
        <td class="cell-pos1 "><?= $result["quantity"] ?></td>
        <td class="cell-pos2 "><?= $result["seller_name"] ?></td>
        <td class="cell-pos2 "><?= $result["getter_name"] ?></td>
        <td class="cell-pos2 "><?= $result["transfer_date"] ?></td>
        <td class="cell-user "><?= $result["user_name"] ?></td>
        <td class="cell-shakhes" style="width:5px">
            <input type="checkbox" name="select for print" id="select">
        </td>
    </tr>
<?php endforeach;

function getStockName($stock_id)
{
    $statement = PDO_CONNECTION->prepare("SELECT name FROM stock WHERE id = :stock_id");
    $statement->bindParam(":stock_id", $stock_id);
    $statement->execute();

    // set the resulting array to associative
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result =  $statement->fetch();
    return $result['name'];
}

function getSanitizedData($quantity, $id)
{
    $statement = DB_CONNECTION->prepare("SELECT qty FROM exitrecord WHERE qtyid = :id");

    $statement->bindParam(":id", $id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    $allExit =  $statement->fetchAll();

    foreach ($allExit as $record) {
        $quantity -= $record["qty"];
    }
    return $quantity;
}
