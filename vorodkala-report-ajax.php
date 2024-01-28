<?php
session_name("MyAppSession");
require_once("./php/db.php");
date_default_timezone_set('Asia/Tehran');

$partNumber = $_POST['partNumber'] === 'null' ? null : $_POST['partNumber']; // Assuming you're retrieving the value from a form
$seller_id = $_POST['seller'] === 'null' ? null : $_POST['seller'];
$brand_id = $_POST['brand'] === 'null' ? null : $_POST['brand'];
$pos1 = $_POST['pos1'] === 'null' ? null : $_POST['pos1'];
$pos2 = $_POST['pos2'] === 'null' ? null : $_POST['pos2'];
$stock_id = $_POST['stock'] === 'null' ? null : $_POST['stock'];
$user_id = $_POST['user'] === 'null' ? null : $_POST['user'];
$invoice_number = $_POST['invoice_number'] === 'null' ? null : $_POST['invoice_number'];
$invoice_date = $_POST['invoice_time'] === 'null' ? null : $_POST['invoice_time']; // Assuming you're retrieving the value from a form
$exit_time = $_POST['exit_time'] === 'null' ? null : $_POST['exit_time']; // Assuming you're retrieving the value from a form

$sql = '';
$stmt = null;
if ($invoice_date && $exit_time) {
    // Prepare the statement
    $stmt = $pdo->prepare("SELECT
    qtybank.id AS purchase_id,
    qtybank.des As purchase_description,
    qtybank.qty AS purchase_quantity,
    qtybank.pos1 AS purchase_position1,
    qtybank.pos2 AS purchase_position2,
    qtybank.create_time AS purchase_time,
    qtybank.anbarenter AS purchase_isEntered,
    qtybank.invoice AS purchase_hasBill,
    qtybank.invoice_number,
    qtybank.invoice_date,
    nisha.partnumber,
    nisha.price AS good_price,
    seller.id AS seller_id,
    seller.name AS seller_name,
    brand.name AS brand_name,
    deliverer.name AS deliverer_name,
    users.username AS username,
    stock.name AS stock_name
    FROM qtybank
    INNER JOIN nisha ON qtybank.codeid = nisha.id
    INNER JOIN brand ON qtybank.brand = brand.id
    LEFT JOIN seller ON qtybank.seller = seller.id
    LEFT JOIN deliverer ON qtybank.deliverer = deliverer.id
    LEFT JOIN users ON qtybank.user = users.id
    LEFT JOIN stock ON qtybank.stock_id = stock.id 
    WHERE (nisha.partnumber LIKE :partNumber OR :partNumber IS NULL)
    AND (qtybank.seller = :seller_id OR :seller_id IS NULL)
    AND (brand.id = :brand_id OR :brand_id IS NULL)
    AND (qtybank.pos1 = :pos1 OR :pos1 IS NULL)
    AND (qtybank.pos2 = :pos2 OR :pos2 IS NULL)
    AND (qtybank.stock_id = :stock_id OR :stock_id IS NULL)
    AND (qtybank.user = :user_id OR :user_id IS NULL)
    AND (qtybank.invoice_number = :invoice_number OR :invoice_number IS NULL)
    AND (qtybank.invoice_date >= :invoice_date AND qtybank.invoice_date <= :exit_time)
    AND is_transfered = 0
    ORDER BY qtybank.create_time DESC");

    // Bind the parameters
    $parameter = $partNumber . "%";
    $stmt->bindParam(':partNumber', $parameter, PDO::PARAM_STR);
    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
    $stmt->bindParam(':invoice_number', $invoice_number, PDO::PARAM_STR);
    $stmt->bindParam(':pos1', $pos1, PDO::PARAM_STR);
    $stmt->bindParam(':pos2', $pos2, PDO::PARAM_STR);
    $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
    $stmt->bindParam(':exit_time', $exit_time, PDO::PARAM_STR);

    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT
        qtybank.id AS purchase_id,
        qtybank.des As purchase_description,
        qtybank.qty AS purchase_quantity,
        qtybank.pos1 AS purchase_position1,
        qtybank.pos2 AS purchase_position2,
        qtybank.create_time AS purchase_time,
        qtybank.anbarenter AS purchase_isEntered,
        qtybank.invoice AS purchase_hasBill,
        qtybank.invoice_number,
        qtybank.invoice_date,
        nisha.partnumber,
        nisha.price AS good_price,
        seller.id AS seller_id,
        seller.name AS seller_name,
        brand.name AS brand_name,
        deliverer.name AS deliverer_name,
        users.username AS username,
        stock.name AS stock_name
        FROM qtybank
        INNER JOIN nisha ON qtybank.codeid = nisha.id
        INNER JOIN brand ON qtybank.brand = brand.id
        LEFT JOIN seller ON qtybank.seller = seller.id
        LEFT JOIN deliverer ON qtybank.deliverer = deliverer.id
        LEFT JOIN users ON qtybank.user = users.id
        LEFT JOIN stock ON qtybank.stock_id = stock.id 
        WHERE (nisha.partnumber LIKE :partNumber OR :partNumber IS NULL)
        AND (qtybank.seller = :seller_id OR :seller_id IS NULL)
        AND (brand.id = :brand_id OR :brand_id IS NULL)
        AND (qtybank.pos1 = :pos1 OR :pos1 IS NULL)
        AND (qtybank.pos2 = :pos2 OR :pos2 IS NULL)
        AND (qtybank.stock_id = :stock_id OR :stock_id IS NULL)
        AND (qtybank.user = :user_id OR :user_id IS NULL)
        AND (qtybank.invoice_number = :invoice_number OR :invoice_number IS NULL)
        AND (qtybank.invoice_date = :invoice_date OR :invoice_date IS NULL)
        AND is_transfered = 0
        ORDER BY qtybank.create_time DESC");
    // Bind the parameters
    $parameter = $partNumber . "%";
    $stmt->bindParam(':partNumber', $parameter, PDO::PARAM_STR);
    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
    $stmt->bindParam(':invoice_number', $invoice_number, PDO::PARAM_STR);
    $stmt->bindParam(':pos1', $pos1, PDO::PARAM_STR);
    $stmt->bindParam(':pos2', $pos2, PDO::PARAM_STR);
    $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);

    $stmt->execute();
}


// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

$purchaseList = $stmt->fetchAll();

$counter = 1;
$billItemsCount = 0;
if (count($purchaseList) > 0) :
    $invoice_number = $purchaseList[0]['invoice_number'] ?? 'x';
    foreach ($purchaseList as $item) :
        $date = $item["purchase_time"];
        $array = explode(' ', $date);
        list($year, $month, $day) = explode('-', $array[0]);
        list($hour, $minute, $second) = explode(':', $array[1]);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
        $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");


        if ($invoice_number !== $item["invoice_number"]) :
            $invoice_number = $item["invoice_number"];
            if ($counter > 1) : // Display summary only if it's not the first iteration
?>
                <tr class="bg-black left_right total">
                    <td colspan="20">
                        مجموع اقلام <?= $billItemsCount ?>
                    </td>
                </tr>
                <tr class="border_bottom">
                    <td colspan="20"></td>
                </tr>
        <?php
            endif;

            $billItemsCount = 0; // Reset for the new bill
        endif;
        $billItemsCount += $item["purchase_quantity"];
        ?>
        <tr class="left_right">
            <td class="cell-shakhes"><?= $counter ?></td>
            <td class="cell-code"><?= '&nbsp;' . strtoupper($item["partnumber"]) ?></td>
            <td class="cell-brand cell-brand-<?= $item['brand_name'] ?>"><?= $item["brand_name"] ?></td>
            <td class="cell-des"><?= $item["purchase_description"] ?></td>
            <td class="cell-qty"><?= $item["purchase_quantity"] ?></td>
            <td class="cell-pos1"><?= $item["purchase_position1"] ?></td>
            <td class="cell-pos2"><?= $item["purchase_position2"] ?></td>
            <td class="cell-seller cell-seller-<?= $item["seller_id"] ?>"><?= $item["seller_name"] ?></td>
            <td class="cell-time"><?= $jalali_time ?></td>
            <td class="cell-date"><?= $jalali_date ?></td>
            <td class="cell-dlname"><?= $item["deliverer_name"] ?></td>
            <td class="tik-inv-<?= $item["purchase_hasBill"] ?>"></td>
            <td><?= $item["invoice_number"] ?></td>
            <td class="cell-date"><?= substr($item["invoice_date"], 5) ?></td>
            <td class="tik-anb-<?= $item["purchase_isEntered"] ?>"></td>
            <td class="cell-stock"><?= $item["stock_name"] ?></td>
            <td class="cell-user"><?= $item["username"] ?></td>
            <td style="display: flex; justify-content: center; margin-block: 15px" class="operation">
                <a onclick="displayModal(this)" data-target="<?= $item["purchase_id"] ?>" class="edit-rec2">
                    <i class="fa fa-pen" aria-hidden="true"></i>
                </a>
            </td>
        </tr>

        <?php
        if ($counter == count($purchaseList)) : // Display summary only if it's not the first iteration
        ?>
            <tr class="bg-black left_right total">
                <td colspan="20">
                    مجموع اقلام <?= $billItemsCount ?>
                </td>
            </tr>
    <?php
        endif;
        $counter++;
    endforeach;
else : ?>
    <tr class="">
        <td colspan="18" class="cell-shakhes">Null</td>
    </tr>
<?php endif; ?>