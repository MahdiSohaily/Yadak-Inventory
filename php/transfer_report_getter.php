<?php
require_once './app/controller/TransferReportController.php';
$item_per_page = 15;
$page = 1;

if (isset($_GET['page'])) :
    $page = intval($_GET['page']);
endif;



$todays_records = getTodayRecords();
$previous_records = getPreviousRecords($item_per_page, $page);

?>
<tr style="margin-block: 10px !important; background-color: #dae5eb;">
    <td colspan="14">عملیات روزهای امروز</td>
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
            <td>
                <a onclick="displayModal(this)" id="<?=  $result['qtybanck_id'] ?>" class="edit-rec2"><i class="fa fa-pen" aria-hidden="true"></i></a>
            </td>
        </tr>
<?php endforeach;
else :
    echo "<tr style='margin-block: 10px !important; background-color: #;'>
            <td colspan='14'>
                <p style='font-size:12px'> موردی پیدا نشد</p>
            </td>
          </tr>";
endif;

?>


<tr style="background-color: transparent;">
    <td colspan="14"></td>
</tr>
<tr style="background-color: transparent;">
    <td colspan="14"></td>
</tr>
<tr style="margin-block: 10px !important; background-color: #dae5eb;">
    <td colspan="14">عملیات روزهای قبل</td>
</tr>
<?php

if (count($previous_records['display'])) :
    foreach ($previous_records['display'] as $index => $result) : ?>
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
            <td>
            <a onclick="displayModal(this)" id="<?=  $result['qtybanck_id'] ?>" class="edit-rec2"><i class="fa fa-pen" aria-hidden="true"></i></a>
            </td>
        </tr>
    <?php endforeach;
    $pages_count = ceil($previous_records['total'] / $item_per_page);
    if ($pages_count > 1) :
    ?>
        <!-- <tr style="background-color: transparent;">
            <td colspan="14">
                <div class="pagination">
                    <?php
                    for ($page = 1; $page <= $pages_count; $page++) :
                    ?>
                        <a class="pagination_item" href="<?= htmlspecialchars_decode($_SERVER['PHP_SELF']) ?>?page=<?= $page ?>"><?= $page ?> </a>
                    <?php
                    endfor; ?>
                </div>
            </td>
        </tr> -->
<?php
    endif;
else :
    echo "<tr style='margin-block: 10px !important; background-color: #;'>
            <td colspan='14'>
                <p style='font-size:12px'> موردی پیدا نشد</p>
            </td>
          </tr>";
endif;
