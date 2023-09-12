<?php
require_once './app/controller/TransferReportController.php';


?>
<tr style="margin-block: 10px !important; background-color: #dae5eb;">
    <td colspan="13">عملیات روزهای امروز</td>
</tr>
<?php
if (count($todays_records)) :
    foreach ($todays_records as $index => $result) : ?>
        <tr>
            <td class="cell-shakhes"><?= $index + 1 ?></td>
            <td class="cell-code "><?= '&nbsp;' . $result["partnumber"] ?></td>
            <td class="cell-brand cell-brand-<?= $result["brand_name"] ?> "><?= $result["brand_name"] ?></td>
            <td class="cell-des "><?= $result["des"] ?></td>
            <td class="cell-pos1 "><?= getStockName($result["stock_id"]) ?></td>
            <td class="cell-qt"><?= $result["prev_quantity"] ?></td>
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
else :
    echo "<tr style='margin-block: 10px !important; background-color: #;'>
            <td colspan='13'>
                <p style='font-size:12px'> موردی پیدا نشد</p>
            </td>
          </tr>";
endif;

?>
<tr style="background-color: transparent;">
    <td colspan="13"></td>
</tr>
<tr style="background-color: transparent;">
    <td colspan="13"></td>
</tr>
<tr style="margin-block: 10px !important; background-color: #dae5eb;">
    <td colspan="13">عملیات روزهای قبل</td>
</tr>
<?php

if (count($previous_records)) :
    foreach ($previous_records as $index => $result) : ?>
        <tr>
            <td class="cell-shakhes"><?= $index + 1 ?></td>
            <td class="cell-code "><?= '&nbsp;' . $result["partnumber"] ?></td>
            <td class="cell-brand cell-brand-<?= $result["brand_name"] ?> "><?= $result["brand_name"] ?></td>
            <td class="cell-des "><?= $result["des"] ?></td>
            <td class="cell-pos1 "><?= getStockName($result["stock_id"]) ?></td>
            <td class="cell-qt "><?= $result["prev_quantity"] ?></td>
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
else :
    echo "<tr style='margin-block: 10px !important; background-color: #;'>
            <td colspan='13'>
                <p style='font-size:12px'> موردی پیدا نشد</p>
            </td>
          </tr>";
endif;

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
