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

<body class="rtl">
    <main class="mx-5">
        <table class="report-table w-full mb-5">
            <thead>
                <tr class="rtl bg-gray-800">
                    <th class="text-white py-2 px-3 text-center" title="شماره فنی">شماره فنی</th>
                    <th class="text-white py-2 px-3 text-center" title="برند">برند</th>
                    <th class="text-white py-2 px-3 text-center" title="توضیحات ورود">توضیحات و</th>
                    <th class="text-white py-2 px-3 text-center" title="توضیحات خروج">توضیحات خ</th>
                    <th class="text-white py-2 px-3 text-center" title="تعداد">تعداد</th>
                    <th class="text-white py-2 px-3 text-center" title="فروشنده">فروشنده</th>
                    <th class="text-white py-2 px-3 text-center" title="خریدار">خریدار</th>
                    <th class="text-white py-2 px-3 text-center" title="تحویل گیرنده">تحویل گیرنده</th>
                    <th class="text-white py-2 px-3 text-center" title="جمع کننده">جمع کننده</th>
                    <th class="text-white py-2 px-3 text-center" title="زمان خروج">زمان خ</th>
                    <th class="text-white py-2 px-3 text-center" title="تاریخ خروج">تاریخ خ</th>
                    <th class="text-white py-2 px-3 text-center" title="شماره فاکتور خروج">ش ف خروج</th>
                    <th class="text-white py-2 px-3 text-center" title="تاریخ فاکتور خروج">تاریخ ف خ</th>
                    <th class="text-white py-2 px-3 text-center" title="ورود به انبار">ورود به انبار</th>
                    <th class="text-white py-2 px-3 text-center" title="شماره فاکتور ورود">ش ف و</th>
                    <th class="text-white py-2 px-3 text-center" title="تاریخ فاکتور ورود">تاریخ ف و</th>
                    <th class="text-white py-2 px-3 text-center" title="انبار">انبار</th>
                    <th class="text-white py-2 px-3 text-center" title="کاربر">کاربر</th>
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
                <tr class="bg-gray-100">
                    <td class="py-2 px-3 text-center text-white bg-blue-600"><?= strtoupper($selected_record["partnumber"]) ?></td>
                    <td class="py-2 px-3 text-center"><?= $selected_record["brand_name"] ?></td>
                    <td class="py-2 px-3 text-center text-sm"><?= $selected_record["purchase_description"] ?></td>
                    <td class="py-2 px-3 text-center text-sm"><?= $selected_record["sold_description"] ?></td>
                    <td class="py-2 px-3 text-center bg-cyan-300"><?= $selected_record["sold_quantity"] ?></td>
                    <td class="py-2 px-3 text-center bg-yellow-400"><?= $selected_record["seller_name"] ?></td>
                    <td class="py-2 px-3 text-center"><?= $selected_record["customer"] ?></td>
                    <td class="py-2 px-3 text-center text-sm"><?= $selected_record["getter_name"] ?></td>
                    <td class="py-2 px-3 text-center text-sm"><?= $selected_record["jamkon"] ?></td>
                    <td class="py-2 px-3 text-center"><?= $jalali_time ?></td>
                    <td class="py-2 px-3 text-center"><?= $jalali_date ?></td>
                    <td class="py-2 px-3 text-center"><?= $selected_record["sold_invoice_number"] ?></td>
                    <td class="py-2 px-3 text-center"><?= substr($selected_record["sold_invoice_date"], 5) ?></td>
                    <td class="py-2 px-3 text-center"><?= $selected_record["purchase_isEntered"] == 0 ? 'خیر' : 'بلی' ?></td>
                    <td class="py-2 px-3 text-center"><?= $selected_record['qty_invoice_number'] ?></td>
                    <td class="py-2 px-3 text-center text-sm"><?= $selected_record['qty_invoice_date'] ?></td>
                    <td class="py-2 px-3 text-center"><?= $selected_record["stock_name"] ?></td>
                    <td class="py-2 px-3 text-center text-sm"><?= $selected_record["username"] ?></td>
                </tr>
            </tbody>
        </table>
        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="p-5 w-full grid grid-cols-2">
            <div class="px-5">
                <input value="<?= $selected_record["purchase_id"] ?>" type="hidden" name="selected_record_id">
                <label for="sold_quantity">تعداد</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" value="<?= $selected_record["sold_quantity"] ?>" min="0" type="number" name="sold_quantity" id="purchase_quantity">

                <label for="invoice_number_edit">شماره فاکتور</label>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" value="<?= $selected_record["sold_invoice_number"] ?>" type="text" name="invoice_number_edit" id="invoice_number_edit">

                <label for="invoice_time">زمان فاکتور</label>
                <input  type="text" name="invoice_time" id="invoice_time">
                <span id="span_invoice_time"></span>
                <label for="purchase_description" class="block mb-2 text-sm font-medium text-gray-900">توضیحات</label>
                <textarea id="purchase_description" name="purchase_description" rows="4" class="block p-2 mb-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?= $selected_record["purchase_description"] ?></textarea>
            </div>
            <div class="px-5 py-2">
                <div class="flex justify-between">
                    <div>
                        <input class="cursor-pointer text-white bg-green-800 rounded px-5 py-2" type="submit" value="ویرایش">
                        <span onclick='deleteRecord(<?= $selected_record["purchase_id"] ?>)' class="cursor-pointer text-white bg-rose-800 rounded px-5 py-2"> حذف</span>
                    </div>
                    <div id='delete_message' class="hidden text-green-900 rounded px-5 py-2" class="error">عملیات موفقانه صورت گرفت</div>
                    <?php if ($successfulOperation) : ?>
                        <div class="text-green-900 rounded px-5 py-2" class="error">عملیات موفقانه صورت گرفت</div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
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
