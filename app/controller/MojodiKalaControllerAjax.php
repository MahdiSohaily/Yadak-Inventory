<?php
require_once '../../config/db_connect.php';

if (filter_has_var(INPUT_POST, 'search')) {


    $pattern = $_POST['pattern'] . "%";
    $existingGoods = getExistingGoods($pattern);

    $existingGoods = array_map(function ($record) {

        $record['entqty'] = getSanitizedData($record["entqty"], $record["qtyid"]);
        return $record;
    }, $existingGoods);


    $existingGoods = array_filter($existingGoods, function ($record) {
        if ($record["entqty"] > 0)
            return $record;
    });
    createDisplay($existingGoods);
}

function getExistingGoods($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT nisha.partnumber , nisha.id,stock.name AS stckname ,nisha.price AS nprice,
                seller.name , brand.name AS brn , qtybank.qty,qtybank.pos1,qtybank.pos2 ,qtybank.des,qtybank.id AS qtyid,
                qtybank.qty AS entqty, qtybank.is_transfered
    FROM qtybank
    LEFT JOIN nisha ON qtybank.codeid=nisha.id
    LEFT JOIN seller ON qtybank.seller=seller.id
    LEFT JOIN brand ON qtybank.brand=brand.id
    LEFT JOIN stock ON qtybank.stock_id=stock.id
    WHERE nisha.partnumber LIKE :pattern
    ORDER BY nisha.partnumber DESC");

    $statement->bindParam(":pattern", $pattern);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
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
        foreach ($records as $record) :
            if ($record['is_transfered'] !== 1) : ?>
                <tr>
                    <td class="text-center cell-shakhes "><?= $counter ?></td>
                    <td class="text-center cell-code "><?= '&nbsp;' .  $record["partnumber"] ?></td>
                    <td class="text-center cell-brand  cell-brand-<?= $record["brn"] ?> "><?= $record["brn"] ?></td>
                    <td class="text-center cell-qty "><?= $record["entqty"] ?></td>
                    <td class="text-center cell-seller cell-seller-<?= $record["name"] ?>"><?= $record["name"] ?></td>
                    <td class="text-center cell-pos1 "><?= $record["pos1"] ?></td>
                    <td class="text-center cell-pos2 "><?= $record["pos2"] ?></td>
                    <td class="text-center cell-des "><?= $record["des"] ?></td>
                    <td class="text-center cell-stock ">
                        <?php
                        $stock = $record["stckname"];
                        $theme = '';

                        if ($stock == "خاوران") {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:red;"';
                        } elseif ($stock == 'یدک شاپ') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:green;"';
                        } elseif ($stock == 'فرشاد') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:blue;"';
                        } elseif ($stock == 'دوبی') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:black;"';
                        } elseif ($stock == 'انبار 2') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:skyblue;"';
                        } elseif ($stock == 'لنتور') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:magnet;"';
                        }
                        echo "<p $theme > $stock </p>"
                        ?>
                    </td>
                </tr>
            <?php else :
            ?>
                <tr style="background-color: #f8ad8c;">
                    <td class="text-center" style="background-color: #f8ad8c; color:white"><?= $counter ?></td>
                    <td class="text-center cell-code "><?= '&nbsp;' .  $record["partnumber"] ?></td>
                    <td class="text-center cell-brand  cell-brand-<?= $record["brn"] ?> "><?= $record["brn"] ?></td>
                    <td class="text-center cell-qty "><?= $record["entqty"] ?></td>
                    <td class="text-center cell-seller cell-seller-<?= $record["name"] ?>"><?= $record["name"] ?></td>
                    <td><?= $record["pos1"] ?></td>
                    <td><?= $record["pos2"] ?></td>
                    <td class="text-center cell-des"><?= $record["des"] ?></td>
                    <td class="text-center cell-stock-move">
                        <?php
                        $stock = $record["stckname"];
                        $theme = '';

                        if ($stock == "خاوران") {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:red;"';
                        } elseif ($stock == 'یدک شاپ') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:green;"';
                        } elseif ($stock == 'فرشاد') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:blue;"';
                        } elseif ($stock == 'دوبی') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:black;"';
                        } elseif ($stock == 'انبار 2') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:skyblue;"';
                        } elseif ($stock == 'لنتور') {
                            $theme = 'style = "padding-block:10px;margin-inline:10px;border-radius:5px;color:white;background-color:magnet;"';
                        }
                        echo "<p $theme > $stock </p>"
                        ?>
                    </td>
                </tr>
        <?php
            endif;
            $counter++;
        endforeach;
    else :
        ?>
        <tr style="background-color: #f8ad8c; color:white; height:100px">
            <td colspan="18" class="text-center">متاسفانه نتیجه ای یافت نشد</td>
        </tr>

<?php
    endif;
}

function echoRial($x, $y)
{
    if (!empty($x)) {


        if ($y == "GEN") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3) * 10000), 0);
        }
        if ($y == "MOB") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3 * 0.9) * 10000), 0);
        }
        if ($y != "GEN" && $y != "MOB") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3 * 0.5) * 10000), 0);
        }
    }
}
