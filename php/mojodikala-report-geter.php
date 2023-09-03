<?php
$existingGoods = getExistingGoods();

$existingGoods = array_map(function ($record) {

    $record['entqty'] = getSanitizedData($record["entqty"], $record["qtyid"]);
    return $record;
}, $existingGoods);


$existingGoods = array_filter($existingGoods, function ($record) {
    if ($record["entqty"] > 0)
        return $record;
});

createDisplay($existingGoods);

function getExistingGoods()
{
    $statement = DB_CONNECTION->prepare("SELECT nisha.partnumber , nisha.id,stock.name AS stckname ,nisha.price AS nprice,
            seller.name , brand.name AS brn , qtybank.qty,qtybank.pos1,qtybank.pos2 ,qtybank.des,qtybank.id AS qtyid,
            qtybank.qty AS entqty ,qtybank.is_transfered
            FROM qtybank
            LEFT JOIN nisha ON qtybank.codeid=nisha.id
            LEFT JOIN seller ON qtybank.seller=seller.id
            LEFT JOIN brand ON qtybank.brand=brand.id
            LEFT JOIN stock ON qtybank.stock_id=stock.id
            ORDER BY nisha.partnumber DESC");
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    return   $statement->fetchAll();
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

function createDisplay($records)
{
    if (count($records) > 0) :
        $counter = 1;
        foreach ($records as $record) : ?>
            <tr>
                <td class="cell-shakhes "><?= $counter ?></td>
                <td class="cell-code "><?= '&nbsp;' .  $record["partnumber"] ?></td>
                <td class="cell-brand cell-brand-<?= $record["brn"] ?> "><?= $record["brn"] ?></td>
                <td class="cell-qty "><?= $record["entqty"] ?></td>
                <td class="cell-seller cell-seller-<?= $record["name"] ?>"><?= $record["name"] ?></td>
                <td class="cell-pos1 "><?= $record["pos1"] ?></td>
                <td class="cell-pos2 "><?= $record["pos2"] ?></td>
                <td class="cell-des "><?= $record["des"] ?></td>
                <td class="cell-stock "><?= $record["stckname"] ?></td>
            </tr>
        <?php
            $counter++;
        endforeach;
    else :
        ?>
        <tr>
            <td colspan="18">متاسفانه نتیجه ای یافت نشد</td>
        </tr>

<?php
    endif;
}
