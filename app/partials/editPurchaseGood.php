<?php
require_once("../../config/db_connect.php");
require_once("../../php/jdf.php");

if (isset($_GET['record'])) {
    $record_id = $_GET['record'];

    $selected_record = getRecord($record_id);
}

?>
<!DOCTYPE html>
<html style="margin-top:0">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='../../css/style.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
    <link type="text/css" rel="stylesheet" href="../../css/persianDatepicker.css" />

    <script src="../../js/jquery-1.11.3.min.js"></script>
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 6px !important;
            height: 4px !important;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey !important;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: rgb(105, 104, 104) !important;
            border-radius: 5px !important;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #6d6c6c !important;
        }
    </style>
</head>

<body>

    <table id="report-table" class="report-table">
        <thead>
            <tr class="left_right border_top">
                <th>#</th>
                <th>شماره فنی</th>
                <th>برند</th>
                <th>توضیحات</th>
                <th>تعداد</th>
                <th>راهرو</th>
                <th>قفسه</th>
                <th>فروشنده</th>
                <th>زمان ورود</th>
                <th>تاریخ ورود</th>
                <th>تحویل دهنده</th>
                <th>فاکتور</th>
                <th>شماره فاکتور</th>
                <th>تاریخ فاکتور</th>
                <th>ورود به انبار</th>
                <th>انبار</th>
                <th>کاربر</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody id="resultBox">
            <?php
            $billItemsCount = 0;
            if (count($selected_record) > 0) :
                $invoice_number = $selected_record['invoice_number'] ?? 'x';
                $date = $selected_record["purchase_time"];
                $array = explode(' ', $date);
                list($year, $month, $day) = explode('-', $array[0]);
                list($hour, $minute, $second) = explode(':', $array[1]);
                $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
                $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
                $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");
                $billItemsCount += $selected_record["purchase_quantity"];
            ?>
                <tr class="left_right">
                    <td class="cell-code"><?= '&nbsp;' . strtoupper($selected_record["partnumber"]) ?></td>
                    <td class="cell-brand cell-brand-<?= $selected_record['brand_name'] ?>"><?= $selected_record["brand_name"] ?></td>
                    <td class="cell-des"><?= $selected_record["purchase_description"] ?></td>
                    <td class="cell-qty"><?= $selected_record["purchase_quantity"] ?></td>
                    <td class="cell-pos1"><?= $selected_record["purchase_position1"] ?></td>
                    <td class="cell-pos2"><?= $selected_record["purchase_position2"] ?></td>
                    <td class="cell-seller cell-seller-<?= $selected_record["seller_id"] ?>"><?= $selected_record["seller_name"] ?></td>
                    <td class="cell-time"><?= $jalali_time ?></td>
                    <td class="cell-date"><?= $jalali_date ?></td>
                    <td class="cell-dlname"><?= $selected_record["deliverer_name"] ?></td>
                    <td class="tik-inv-<?= $selected_record["purchase_hasBill"] ?>"></td>
                    <td><?= $selected_record["invoice_number"] ?></td>
                    <td class="cell-date"><?= substr($selected_record["invoice_date"], 5) ?></td>
                    <td class="tik-anb-<?= $selected_record["purchase_isEntered"] ?>"></td>
                    <td class="cell-stock"><?= $selected_record["stock_name"] ?></td>
                    <td class="cell-user"><?= $selected_record["username"] ?></td>
                </tr>
            <?php else : ?>
                <tr class="">
                    <td colspan="18" class="cell-shakhes">Null</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <form id="vorod-edit" method="get" action="vorodkala-report-edit-save.php" autocomplete="off">


        <div class="right-form">

            <input value="<?php echo $qtybankID ?>" type="hidden" name="id">

            <label for="qty">تعداد</label>
            <input value="<?php echo $row["qty"] ?>" min="0" type="number" name="qty" id="qty">

            <label for="pos1">راهرو</label>
            <input value="<?php echo $row["pos1"] ?>" onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1">

            <label for="pos2">قفسه</label>
            <input value="<?php echo $row["pos2"] ?>" onkeydown="upperCaseF(this)" type="text" name="pos2" id="pos2">

            <label for="invoice_number">شماره فاکتور</label>
            <input value="<?php echo $row["invoice_number"] ?>" type="number" name="invoice_number" id="invoice_number">

            <label for="invoice_time">زمان فاکتور</label>
            <input value="<?php echo $row["invoice_date"] ?>" type="text" name="invoice_time" id="invoice_time">
            <span id="span_invoice_time"></span>
            <fieldset>
                <legend>آیا فاکتور دارد ؟</legend>
                <label for="invoice">خیر</label>
                <input type="radio" name="invoice" id="invoice" value="0" <?php if ($row["invoice"] == 0) {
                                                                                echo "checked";
                                                                            } ?>>
                <label for="nvoice">بله</label>
                <input type="radio" name="invoice" id="invoice" value="1" <?php if ($row["invoice"] == 1) {
                                                                                echo "checked";
                                                                            } ?>>
            </fieldset>
            <fieldset>
                <legend>آیا وارد انبار شده ؟</legend>

                <label for="anbarenter">خیر</label>
                <input type="radio" name="anbarenter" id="anbarenter" value="0" <?php if ($row["anbarenter"] == 0) {
                                                                                    echo "checked";
                                                                                } ?>>

                <label for="anbarenter">بله</label>
                <input type="radio" name="anbarenter" id="anbarenter" value="1" <?php if ($row["anbarenter"] == 1) {
                                                                                    echo "checked";
                                                                                } ?>>

            </fieldset>
        </div>

        <div class="left-form">

            <label for="brand">اصالت</label>
            <select name="brand" id="esalat" data="<?php echo $brnid ?>">
                <?php include("brand-form.php") ?>
            </select>
            <label>فروشنده</label>
            <select name="seller" id="seller">
                <?php include("./seller-form.php");
                foreach ($data as $key => $value) :
                ?>
                    <option <?= ($key == $seller_id) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>

            <label for="stock">انبار</label>
            <select name="stock" id="stock" data="<?php echo $stid ?>">
                <?php include("stock-form.php") ?>
            </select>

            <label for="deliverer">تحویل دهنده</label>
            <select name="deliverer" id="deliverer" data="<?php echo $dlid ?>">
                <?php include("deliverer-form.php") ?>
            </select>

            <label for="des">توضیحات</label>
            <textarea name="des" id="des"><?php echo $mydes ?></textarea>

        </div>
        <div class="-bar">
            <input type="submit" value="ذخیره" id="sabt">
            <a data="<?php echo $qtybankID ?>" class="del-vorod"> حذف</a>
            <div class="error"></div>
        </div>

    </form>
    <script src="../../js/vorodkala-edit.js?v=<?php echo (rand()) ?>"></script>
    <script src="../../js/form.js?v=<?php echo (rand()) ?>"></script>
    <script src="../../js/persianDatepicker.min.js?v=<?php echo (rand()) ?>"></script>
</body>

</html>

<?php
function getRecord($record_id)
{
    $statement = DB_CONNECTION->prepare("SELECT qtybank.id AS purchase_id,
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
                                    WHERE qtybank.id = :record_id
                                    ORDER BY qtybank.create_time DESC");

    $statement->bindParam(':record_id', $record_id);
    $statement->execute();

    $purchaseList = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $purchaseList[0];
}
