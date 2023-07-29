<?php
require_once './php/db.php';
global $jame_item;
$jame_item = 0;
global $invoice_number;
$invoice_number = 0000;
global $factor;
$factor = 1;

if (filter_has_var(INPUT_POST, 'submit_filter')) {
    $partNumber = empty($_POST['partNumber']) ? null : $_POST['partNumber']; // Assuming you're retrieving the value from a form
    $seller_id = empty($_POST['seller']) ? null : $_POST['seller'];
    $brand_id = empty($_POST['brand']) ? null : $_POST['brand'];
    $pos1 = empty($_POST['pos1']) ? null : $_POST['pos1'];
    $pos2 = empty($_POST['pos2']) ? null : $_POST['pos2'];
    $stock_id = empty($_POST['stock']) ? null : $_POST['stock'];
    $user_id = empty($_POST['user']) ? null : $_POST['user'];
    $invoice_number = empty($_POST['invoice_number']) ? null : $_POST['invoice_number'];
    $invoice_date = empty($_POST['invoice_time']) ? null : $_POST['invoice_time'];
    $exit_time = empty($_POST['exit_time']) ? null : $_POST['exit_time']; // Assuming you're retrieving the value from a form

    // Prepare the statement
    $stmt = $pdo->prepare("SELECT nisha.partnumber, qtybank.des, nisha.id, users.username AS usn, seller.name, seller.id AS slid, stock.name AS stn, brand.name AS brn, qtybank.qty, qtybank.id AS qtyid, exitrecord.qty AS extqty, exitrecord.id AS exid, qtybank.qty AS entqty, exitrecord.customer, exitrecord.des AS exdes, getter.name AS gtn, deliverer.name AS dln, exitrecord.exit_time, exitrecord.jamkon, exitrecord.invoice_number, exitrecord.invoice_date, qtybank.anbarenter
                            FROM qtybank
                            LEFT JOIN nisha ON qtybank.codeid = nisha.id
                            INNER JOIN exitrecord ON qtybank.id = exitrecord.qtyid
                            LEFT JOIN seller ON qtybank.seller = seller.id
                            LEFT JOIN brand ON qtybank.brand = brand.id
                            LEFT JOIN stock ON qtybank.stock_id = stock.id
                            LEFT JOIN users ON exitrecord.user = users.id
                            LEFT JOIN deliverer ON qtybank.deliverer = deliverer.id
                            LEFT JOIN getter ON exitrecord.getter = getter.id
                            WHERE (nisha.partnumber LIKE :partNumber OR :partNumber IS NULL)
                            AND (qtybank.seller = :seller_id OR :seller_id IS NULL)
                            AND (brand.id = :brand_id OR :brand_id IS NULL)
                            AND (qtybank.pos1 = :pos1 OR :pos1 IS NULL)
                            AND (qtybank.pos2 = :pos2 OR :pos2 IS NULL)
                            AND (qtybank.stock_id = :stock_id OR :stock_id IS NULL)
                            AND (exitrecord.user = :user_id OR :user_id IS NULL)
                            AND (exitrecord.invoice_number = :invoice_number OR :invoice_number IS NULL)
                            AND (exitrecord.invoice_date = :invoice_date OR :invoice_date IS NULL)
                            AND (exitrecord.exit_time = :exit_time OR :exit_time IS NULL)
                            ORDER BY exitrecord.exit_time DESC, exitrecord.invoice_number DESC
                            LIMIT 100
                            ");

    // Bind the parameters
    $stmt->bindParam(':partNumber', $partNumber, PDO::PARAM_STR);
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

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $date = $row["exit_time"];

        $array = explode(' ', $date);
        list($year, $month, $day) = explode('-', $array[0]);
        list($hour, $minute, $second) = explode(':', $array[1]);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);

        $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
        $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");

        if ($invoice_number == 0000) {
            $invoice_number = $row["invoice_number"];
        }

        if ($invoice_number != $row["invoice_number"]) {
            $invoice_number = $row["invoice_number"];
?>
            <tr>
                <td class="invoice-spacer" colspan="18">
                    جمع اقلام : <?php echo $jame_item;
                                $jame_item = 0;
                                ?>
                </td>
            </tr>

        <?php
        }
        $jame_item = $jame_item + $row["extqty"];


        ?>
        <tr>
            <td class="cell-shakhes "><?php echo $factor ?></td>
            <td class="cell-code "><?php echo '&nbsp;' . $row["partnumber"] ?></td>
            <td class="cell-brand cell-brand-<?php echo $row["brn"] ?> "><?php echo $row["brn"] ?></td>
            <td class="cell-des "><?php echo $row["des"] ?></td>
            <td class="cell-des "><?php echo $row["exdes"] ?></td>
            <td class="cell-qty "><?php echo $row["extqty"] ?></td>
            <td class="cell-seller cell-seller-<?php echo $row["slid"] ?>"><?php echo $row["name"] ?></td>
            <td class="cell-customer "><?php echo $row["customer"] ?></td>
            <td class="cell-gtname "><?php echo $row["gtn"] ?></td>
            <td class="cell-gtname "><?php echo $row["jamkon"] ?></td>
            <td class="cell-time "><?php echo $jalali_time ?></td>
            <td class="cell-date "><?php echo $jalali_date ?></td>
            <td <?php if (empty($row["invoice_number"])) {
                    echo 'class="no-invoice-number"';
                } ?>><?php echo $row["invoice_number"] ?></td>
            <td class="cell-date "><?php echo substr($row["invoice_date"], 5) ?></td>

            <td class="tik-anb-<?php echo $row["anbarenter"] ?>"></td>
            <td></td>
            <td></td>
            <td class="cell-stock "><?php echo $row["stn"] ?></td>
            <td class="cell-user "><?php echo $row["usn"] ?></td>
            <td><a id="<?php echo $row["exid"] ?>" class="edit-rec2">ویرایش<i class="fas fa-edit"></i></a></td>
        </tr>
<?php
        $factor = $factor + 1;
    }
} // end while
