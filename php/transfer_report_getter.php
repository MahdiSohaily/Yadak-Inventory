<?php
require_once("db.php");

if (isset($interval)) {
    $condition = " WHERE qtybank.invoice_date >= gregorian_to_shamsi_datec($interval)
    AND qtybank.invoice_date <= gregorian_to_shamsi_datec(0)";
} else {
    $condition = 'WHERE 1=1';
}

try {
    $statement = PDO_CONNECTION->prepare("SELECT transfer_record.*, qtybank.qty AS previous_amount,
    nisha.partnumber, brand.name As brand_name, seller.name AS seller_name, deliverer.name AS deliverer_name,
    users.name AS user_name, qtybank.stock_id, exitrecord.des
    FROM transfer_record
    INNER JOIN qtybank ON qtybank.id =  transfer_record.affected_record
    INNER JOIN nisha ON nisha.id = qtybank.codeid
    INNER JOIN exitrecord ON exitrecord.id  = transfer_record.exit_id
    LEFT JOIN brand ON brand.id = qtybank.brand
    LEFT JOIN seller ON seller.id = qtybank.seller
    LEFT JOIN deliverer ON deliverer.id = exitrecord.getter
    INNER JOIN users ON users.id = transfer_record.user_id
    ORDER BY transfer_record.transfer_date DESC");
    $statement->execute();

    // set the resulting array to associative
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $results =  $statement->fetchAll();
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

foreach ($results as $index => $result) : ?>
    <tr>
        <td class="cell-shakhes "><?= $index + 1 ?></td>
        <td class="cell-code "><?= '&nbsp;' . $result["partnumber"] ?></td>
        <td class="cell-brand cell-brand-<?= $result["brand_name"] ?> "><?= $result["brand_name"] ?></td>
        <td class="cell-des "><?= $result["des"] ?></td>
        <td class="cell-qty "><?= $result["previous_amount"] ?></td>
        <td class="cell-pos1 "><?= $result["quantity"] ?></td>
        <td class="cell-pos1 "><?= getStockName($result["stock"]) ?></td>
        <td class="cell-pos1 "><?= getStockName($result["stock_id"]) ?></td>
        <td class="cell-pos2 "><?= $result["seller_name"] ?></td>
        <td class="cell-pos2 "><?= $result["deliverer_name"] ?></td>
        <td class="cell-user "><?= $result["user_name"] ?></td>
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
