<?php
require_once("../../config/db_connect.php");
require_once("../../utilities/helpers.php");
require_once("../../php/jdf.php");
$successfulOperation = false;

if (isset($_GET['record'])) {
    $record_id = $_GET['record'];
    $selected_record = getRecord($record_id);
    $brands = getBrands();
    $sellers = getSellers();
    $stocks = getStocks();
    $deliverers = getDeliverers();
}

if (isset($_POST['selected_record_id'])) {
    $record_id = $_POST['selected_record_id'];

    $successfulOperation = saveChanges($_POST);
    $selected_record = getRecord($record_id);
    $brands = getBrands();
    $sellers = getSellers();
    $stocks = getStocks();
    $deliverers = getDeliverers();
}
?>
<!DOCTYPE html>
<html style="margin-top:0">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='../../../callcenter/report/public/css/styles.css?v=<?= rand() ?>' type='text/css' media='all' />
    <script src="../../../callcenter/report/public/js/index.js?v=<?= rand() ?>"></script>
    <link type="text/css" rel="stylesheet" href="../../css/persianDatepicker.css" />

    <script src="../../js/jquery-1.11.3.min.js"></script>
    <script src="../../public/js/assets/assets/axios.js"></script>
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
    <main>
        <table id="report-table" class="report-table">
            <thead>
                <tr>
                    <th title="شماره فنی">شماره فنی</th>
                    <th title="برند">برند</th>
                    <th title="توضیحات ورود">توضیحات و</th>
                    <th title="توضیحات خروج">توضیحات خ</th>
                    <th title="تعداد">تعداد</th>

                    <th title="فروشنده">فروشنده</th>
                    <th title="خریدار">خریدار</th>
                    <th title="تحویل گیرنده">تحویل گیرنده</th>
                    <th title="جمع کننده">جمع کننده</th>
                    <th title="زمان خروج">زمان خ</th>
                    <th title="تاریخ خروج">تاریخ خ</th>

                    <th title="شماره فاکتور خروج">ش ف خروج</th>
                    <th title="تاریخ فاکتور خروج">تاریخ ف خ</th>

                    <th title="ورود به انبار">ورود به انبار</th>

                    <th title="شماره فاکتور ورود">ش ف و</th>
                    <th title="تاریخ فاکتور ورود">تاریخ ف و</th>
                    <th title="انبار">انبار</th>
                    <th title="کاربر">کاربر</th>
                </tr>
            </thead>
            <tbody id="resultBox">
                <?php
                $date = $selected_record["sold_time"];
                $array = explode(' ', $date);
                list($year, $month, $day) = explode('-', $array[0]);
                list($hour, $minute, $second) = explode(':', $array[1]);
                $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
                $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
                $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");

                ?>
                <tr class="left_right">
                    <td class="cell-code "><?= strtoupper($selected_record["partnumber"]) ?></td>
                    <td class="cell-brand cell-brand-<?= $selected_record["brand_name"] ?> "><?= $selected_record["brand_name"] ?></td>
                    <td class="cell-des "><?= $selected_record["purchase_description"] ?></td>
                    <td class="cell-des "><?= $selected_record["sold_description"] ?></td>
                    <td class="cell-qty "><?= $selected_record["sold_quantity"] ?></td>
                    <td class="cell-seller cell-seller-<?= $selected_record["seller_id"] ?>"><?= $selected_record["seller_name"] ?></td>
                    <td class="cell-customer "><?= $selected_record["customer"] ?></td>
                    <td class="cell-gtname "><?= $selected_record["getter_name"] ?></td>
                    <td class="cell-gtname "><?= $selected_record["jamkon"] ?></td>
                    <td class="cell-time "><?= $jalali_time ?></td>
                    <td class="cell-date "><?= $jalali_date ?></td>
                    <td <?= empty($selected_record["sold_invoice_number"]) ? ' class="no-invoice-number"' : '' ?>>
                        <?= $selected_record["sold_invoice_number"] ?>
                    </td>
                    <td class="cell-date "><?= substr($selected_record["sold_invoice_date"], 5) ?></td>
                    <td class="tik-anb-<?= $selected_record["purchase_isEntered"] ?>"></td>
                    <td class="cell-time "><?= $selected_record['qty_invoice_number'] ?></td>
                    <td class="cell-time "><?= $selected_record['qty_invoice_date'] ?></td>
                    <td class="cell-stock "><?= $selected_record["stock_name"] ?></td>
                    <td class="cell-user "><?= $selected_record["username"] ?></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

<?php
function getRecord($record_id)
{
    try {
        $statement = DB_CONNECTION->prepare("SELECT 
        qtybank.id AS purchase_id,
        qtybank.des AS purchase_description,
        qtybank.qty AS purchase_quantity,
        qtybank.anbarenter AS purchase_isEntered,
        qtybank.invoice_number AS qty_invoice_number,
        qtybank.invoice_date AS qty_invoice_date,
        nisha.id AS partNumber_id,
        nisha.partnumber,
        users.username AS username,
        seller.name AS seller_name,
        seller.id AS seller_id,
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
        deliverer.name AS deliverer_name,
        callcenter.shomarefaktor.kharidar AS customer
        FROM qtybank
        INNER JOIN nisha ON qtybank.codeid = nisha.id
        INNER JOIN exitrecord ON qtybank.id = exitrecord.qtyid
        LEFT JOIN seller ON qtybank.seller = seller.id
        LEFT JOIN brand ON qtybank.brand = brand.id
        LEFT JOIN stock ON qtybank.stock_id = stock.id
        LEFT JOIN users ON exitrecord.user = users.id
        LEFT JOIN deliverer ON qtybank.deliverer = deliverer.id
        LEFT JOIN getter ON exitrecord.getter = getter.id
        LEFT JOIN callcenter.shomarefaktor ON exitrecord.invoice_number = shomarefaktor.shomare
        WHERE exitrecord.id = :record_id");

        $statement->bindParam(':record_id', $record_id);
        $statement->execute();

        $purchaseList = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $purchaseList ? $purchaseList[0] : [];
    } catch (\Throwable $th) {
        throw $th;
    }
}
