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
$stmt = $pdo->prepare("SELECT
nisha.partnumber,
qtybank.des,
nisha.id,
users.username AS usn,
seller.name,
seller.id AS slid,
stock.name AS stn,
brand.name AS brn,
qtybank.qty,
qtybank.id AS qtyid,
exitrecord.qty AS extqty,
exitrecord.id AS exid,
qtybank.qty AS entqty,
exitrecord.customer,
exitrecord.des AS exdes,
getter.name AS gtn,
deliverer.name AS dln,
exitrecord.exit_time,
exitrecord.jamkon,
exitrecord.invoice_number,
qtybank.invoice_number AS qty_invoice_number,
exitrecord.invoice_date,
qtybank.invoice_date AS qty_invoice_date,
qtybank.anbarenter
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

// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

global $jameitem;
$jameitem = 0;
global $invoice_number;
$invoice_number = 0000;
global $shakhes;
$shakhes = 1;
$counter = 1;

if ($stmt->rowCount() > 0) :

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :

        $date = $row["exit_time"];

        $array = explode(' ', $date);
        list($year, $month, $day) = explode('-', $array[0]);
        list($hour, $minute, $second) = explode(':', $array[1]);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
        $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");

        if ($invoice_number == 0000) :
            $invoice_number = $row["invoice_number"];
        endif;

        if ($invoice_number != $row["invoice_number"]) :
            $invoice_number = $row["invoice_number"];
            $shakhes = 1; ?>

            <tr class="bill_section" style="border-bottom: 2px solid gray;">
                <td colspan="20" class="left_right" style="background-color: aquamarine !important;
                                        font-weight: bold; font-size: 18px;
                                        margin-right: 10% !important;">
                    جمع اقلام : <?= $jameitem;
                                $jameitem = 0;
                                ?>
                </td>
            </tr>
            <tr style="background-color: white !important;">
                <td colspan="20"></td>
            </tr>
            <tr style="background-color: white !important;">
                <td colspan="20"></td>
            </tr>

        <?php
        endif;
        $jameitem = $jameitem + $row["extqty"];

        ?>
        <tr class="left_right <?= $shakhes == 1 ? 'border_top' : ''; ?>">
            <td class="cell-shakhes "><?= $shakhes ?></td>
            <td class="cell-code "><?= '&nbsp;' . strtoupper($row["partnumber"]) ?></td>
            <td class="cell-brand cell-brand-<?= $row["brn"] ?> "><?= $row["brn"] ?></td>
            <td class="cell-des "><?= $row["des"] ?></td>
            <td class="cell-des "><?= $row["exdes"] ?></td>
            <td class="cell-qty "><?= $row["extqty"] ?></td>
            <td class="cell-seller cell-seller-<?= $row["slid"] ?>"><?= $row["name"] ?></td>
            <td class="cell-customer "><?= $row["customer"] ?></td>
            <td class="cell-gtname "><?= $row["gtn"] ?></td>
            <td class="cell-gtname "><?= $row["jamkon"] ?></td>
            <td class="cell-time "><?= $jalali_time ?></td>
            <td class="cell-date "><?= $jalali_date ?></td>
            <td <?php if (empty($row["invoice_number"])) {
                    echo 'class="no-invoice-number"';
                } ?>><?= $row["invoice_number"] ?></td>
            <td class="cell-date "><?= substr($row["invoice_date"], 5) ?></td>

            <td class="tik-anb-<?= $row["anbarenter"] ?>"></td>
            <td class="cell-time "><?= $row['qty_invoice_number'] ?></td>
            <td class="cell-time "><?= $row['qty_invoice_date'] ?></td>
            <td class="cell-stock "><?= $row["stn"] ?></td>
            <td class="cell-user "><?= $row["usn"] ?></td>
            <td style="display: flex; justify-content: center; margin-block: 15px;"><a onclick="displayModal(this)" id="<?= $row["exid"] ?>" class="edit-rec2"><i class="fa fa-pen" aria-hidden="true"></i></a></td>
        </tr>
        <?php
        if ($stmt->rowCount() == $counter) : ?>
            <tr class="bill_section" style="border-bottom: 2px solid gray;">
                <td colspan="20" class="left_right" style="background-color: aquamarine !important;
                                        font-weight: bold; font-size: 18px;
                                        margin-right: 10% !important;">
                    جمع اقلام : <?= $jameitem;
                                $jameitem = 0; ?>
                </td>
            </tr>
            <tr style="background-color: white !important;">
                <td colspan="20"></td>
            </tr>
            <tr style="background-color: white !important;">
                <td colspan="20"></td>
            </tr>
<?php
        endif;
        $shakhes++;
        $counter++;
    endwhile; // end while
else :
    echo '<tr><td colspan="18">متاسفانه نتیجه ای یافت نشد</td></tr>';
endif;
