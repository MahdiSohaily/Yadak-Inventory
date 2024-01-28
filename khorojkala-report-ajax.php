<?php
require_once("./php/db.php");
date_default_timezone_set('Asia/Tehran');

$partNumber = $_POST['partNumber'] === 'null' ? null : $_POST['partNumber']; // Assuming you're retrieving the value from a form
$seller_id = $_POST['seller'] === 'null' ? null : $_POST['seller'];
$brand_id = $_POST['brand'] === 'null' ? null : $_POST['brand'];
$pos1 = $_POST['pos1'] === 'null' ? null : $_POST['pos1'];
$customer = $_POST['customer'] === 'null' ? null : $_POST['customer'];
$stock_id = $_POST['stock'] === 'null' ? null : $_POST['stock'];
$user_id = $_POST['user'] === 'null' ? null : $_POST['user'];
$invoice_number = $_POST['invoice_number'] === 'null' ? null : $_POST['invoice_number'];
$invoice_date = $_POST['invoice_time'] === 'null' ? null : $_POST['invoice_time'];
$exit_time = $_POST['exit_time'] === 'null' ? null : $_POST['exit_time']; // Assuming you're retrieving the value from a form

// Prepare the statement
$stmt = null;

if ($invoice_date && $exit_time) {
    $stmt = $pdo->prepare("SELECT
       qtybank.des AS purchase_description,
        qtybank.qty AS purchase_quantity,
        qtybank.anbarenter AS purchase_isEntered,
        qtybank.invoice_number AS qty_invoice_number,
        qtybank.invoice_date AS qty_invoice_date,
        nisha.id AS partNumber_id,
        nisha.partnumber,
        users.username AS username,
        seller.id AS seller_id,
        seller.name AS seller_name,
        stock.name AS stock_name,
        brand.name AS brand_name,
        exitrecord.qty AS sold_quantity,
        exitrecord.id AS sold_id,
        exitrecord.customer AS sold_customer,
        exitrecord.des AS sold_description,
        exitrecord.exit_time AS sold_time,
        exitrecord.jamkon,
        exitrecord.invoice_number AS sold_invoice_number,
        exitrecord.invoice_date AS sold_invoice_date,
        getter.id AS getter_id,
        getter.name AS getter_name,
        deliverer.id AS deliverer_id,
        deliverer.name AS deliverer_name
        FROM
        qtybank
        INNER JOIN
        nisha ON qtybank.codeid = nisha.id
        INNER JOIN
        exitrecord ON qtybank.id = exitrecord.qtyid
        LEFT JOIN
        seller ON qtybank.seller = seller.id
        LEFT JOIN
        brand ON qtybank.brand = brand.id
        LEFT JOIN
        stock ON qtybank.stock_id = stock.id
        LEFT JOIN
        users ON exitrecord.user = users.id
        LEFT JOIN
        deliverer ON qtybank.deliverer = deliverer.id
        LEFT JOIN
        getter ON exitrecord.getter = getter.id
        WHERE
        (nisha.partnumber LIKE :partNumber OR :partNumber IS NULL)
        AND (qtybank.seller = :seller_id OR :seller_id IS NULL)
        AND (brand.id = :brand_id OR :brand_id IS NULL)
        AND (qtybank.pos1 = :pos1 OR :pos1 IS NULL)
        AND (exitrecord.customer LIKE :customer OR :customer IS NULL)
        AND (qtybank.stock_id = :stock_id OR :stock_id IS NULL)
        AND (exitrecord.user = :user_id OR :user_id IS NULL)
        AND (exitrecord.invoice_number = :invoice_number OR :invoice_number IS NULL)
        AND (exitrecord.invoice_date >= :invoice_date AND exitrecord.invoice_date <= :exit_date)
        AND exitrecord.is_transfered = 0
        ORDER BY
        exitrecord.exit_time DESC,
        exitrecord.invoice_number DESC");

    // Bind the parameters
    $parameter = $partNumber . "%";
    $stmt->bindParam(':partNumber', $parameter, PDO::PARAM_STR);
    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
    $stmt->bindParam(':invoice_number', $invoice_number, PDO::PARAM_STR);
    $stmt->bindParam(':pos1', $pos1, PDO::PARAM_STR);
    $customerParam = '%' . $customer . '%';
    $stmt->bindParam(':customer', $customerParam, PDO::PARAM_STR);
    $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
    $stmt->bindParam(':exit_date', $exit_time, PDO::PARAM_STR);

    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT
        qtybank.des AS purchase_description,
        qtybank.qty AS purchase_quantity,
        qtybank.anbarenter AS purchase_isEntered,
        qtybank.invoice_number AS qty_invoice_number,
        qtybank.invoice_date AS qty_invoice_date,
        nisha.id AS partNumber_id,
        nisha.partnumber,
        users.username AS username,
        seller.id AS seller_id,
        seller.name AS seller_name,
        stock.name AS stock_name,
        brand.name AS brand_name,
        exitrecord.qty AS sold_quantity,
        exitrecord.id AS sold_id,
        exitrecord.customer AS sold_customer,
        exitrecord.des AS sold_description,
        exitrecord.exit_time AS sold_time,
        exitrecord.jamkon,
        exitrecord.invoice_number AS sold_invoice_number,
        exitrecord.invoice_date AS sold_invoice_date,
        getter.id AS getter_id,
        getter.name AS getter_name,
        deliverer.id AS deliverer_id,
        deliverer.name AS deliverer_name
        FROM
        qtybank
        INNER JOIN
        nisha ON qtybank.codeid = nisha.id
        INNER JOIN
        exitrecord ON qtybank.id = exitrecord.qtyid
        LEFT JOIN
        seller ON qtybank.seller = seller.id
        LEFT JOIN
        brand ON qtybank.brand = brand.id
        LEFT JOIN
        stock ON qtybank.stock_id = stock.id
        LEFT JOIN
        users ON exitrecord.user = users.id
        LEFT JOIN
        deliverer ON qtybank.deliverer = deliverer.id
        LEFT JOIN
        getter ON exitrecord.getter = getter.id
        WHERE
        (nisha.partnumber LIKE :partNumber OR :partNumber IS NULL)
        AND (qtybank.seller = :seller_id OR :seller_id IS NULL)
        AND (brand.id = :brand_id OR :brand_id IS NULL)
        AND (qtybank.pos1 = :pos1 OR :pos1 IS NULL)
        AND (DATE_FORMAT(exitrecord.exit_time, '%Y/%m/%d') = :exit_date OR :exit_date IS NULL)
        AND (exitrecord.customer LIKE :customer OR :customer IS NULL)
        AND (qtybank.stock_id = :stock_id OR :stock_id IS NULL)
        AND (exitrecord.user = :user_id OR :user_id IS NULL)
        AND (exitrecord.invoice_number = :invoice_number OR :invoice_number IS NULL)
        AND (exitrecord.invoice_date = :invoice_date OR :invoice_date IS NULL)
        AND exitrecord.is_transfered = 0
        ORDER BY
        exitrecord.exit_time DESC,
        exitrecord.invoice_number DESC");

    // Bind the parameters
    $parameter = $partNumber . "%";
    $stmt->bindParam(':partNumber', $parameter, PDO::PARAM_STR);
    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
    $stmt->bindParam(':invoice_number', $invoice_number, PDO::PARAM_STR);
    $stmt->bindParam(':pos1', $pos1, PDO::PARAM_STR);
    $customerParam = '%' . $customer . '%';
    $stmt->bindParam(':customer', $customerParam, PDO::PARAM_STR);
    $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':invoice_date', $invoice_date, PDO::PARAM_STR);
    $stmt->bindParam(':exit_date', $exit_time, PDO::PARAM_STR);

    $stmt->execute();
}
// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$soldItemsList = $stmt->fetchAll();

$counter = 1; // Assuming $counter is initialized before the loop
$billItemsCount = 0; // Initialize outside the loop
$invoice_number = $soldItemsList[0]['sold_invoice_number'] ?? 'x';
foreach ($soldItemsList as $item) :
    $date = $item["sold_time"];
    $array = explode(' ', $date);
    list($year, $month, $day) = explode('-', $array[0]);
    list($hour, $minute, $second) = explode(':', $array[1]);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
    $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");


    if ($invoice_number !== $item["sold_invoice_number"]) :
        $invoice_number = $item["sold_invoice_number"];
        if ($counter > 1) : // Display summary only if it's not the first iteration
?>
            <tr class="bg-black left_right ">
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
    $billItemsCount += $item["sold_quantity"];
    ?>
    <tr class="left_right">
        <td class="cell-shakhes "><?= $counter ?></td>
        <td class="cell-code "><?= strtoupper($item["partnumber"]) ?></td>
        <td class="cell-brand cell-brand-<?= $item["brand_name"] ?> "><?= $item["brand_name"] ?></td>
        <td class="cell-des "><?= $item["purchase_description"] ?></td>
        <td class="cell-des "><?= $item["sold_description"] ?></td>
        <td class="cell-qty "><?= $item["sold_quantity"] ?></td>
        <td class="cell-seller cell-seller-<?= $item["seller_id"] ?>"><?= $item["seller_name"] ?></td>
        <td class="cell-customer "><?= $item["sold_customer"] ?></td>
        <td class="cell-gtname "><?= $item["getter_name"] ?></td>
        <td class="cell-gtname "><?= $item["jamkon"] ?></td>
        <td class="cell-time "><?= $jalali_time ?></td>
        <td class="cell-date "><?= $jalali_date ?></td>
        <td <?= empty($item["sold_invoice_number"]) ? ' class="no-invoice-number"' : '' ?>>
            <?= $item["sold_invoice_number"] ?>
        </td>
        <td class="cell-date "><?= substr($item["sold_invoice_date"], 5) ?></td>
        <td class="tik-anb-<?= $item["purchase_isEntered"] ?>"></td>
        <td class="cell-time "><?= $item['qty_invoice_number'] ?></td>
        <td class="cell-time "><?= $item['qty_invoice_date'] ?></td>
        <td class="cell-stock "><?= $item["stock_name"] ?></td>
        <td class="cell-user "><?= $item["username"] ?></td>
        <td style="display: flex; justify-content: center; margin-block: 15px;" class="operation">
            <a onclick="displayModal(this)" data-target="<?= $item["sold_id"] ?>" class="edit-rec2">
                <i class="fa fa-pen" aria-hidden="true"></i>
            </a>
        </td>
    </tr>
    <?php
    if ($counter == count($soldItemsList)) : // Display summary only if it's not the first iteration
    ?>
        <tr class="bg-black left_right">
            <td colspan="20">
                مجموع اقلام <?= $billItemsCount ?>
            </td>
        </tr>
<?php
    endif;
    $counter++;
endforeach;
?>