<?php
require_once("../../config/db_connect.php");
require_once("../../php/jdf.php");

if (isset($_GET['record'])) {
    $record_id = $_GET['record'];
    $selected_record = getRecord($record_id);
    $brands = getBrands();
    $sellers = getSellers();
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

<body class="rtl p-3">
    <table id="report-table" class="report-table w-full mb-5">
        <thead>
            <tr class="rtl bg-gray-800">
                <th class="text-white py-2 px-3 text-right">شماره فنی</th>
                <th class="text-white py-2 px-3 text-right">برند</th>
                <th class="text-white py-2 px-3 text-right">توضیحات</th>
                <th class="text-white py-2 px-3 text-right">تعداد</th>
                <th class="text-white py-2 px-3 text-right">راهرو</th>
                <th class="text-white py-2 px-3 text-right">قفسه</th>
                <th class="text-white py-2 px-3 text-right">فروشنده</th>
                <th class="text-white py-2 px-3 text-right">زمان ورود</th>
                <th class="text-white py-2 px-3 text-right">تاریخ ورود</th>
                <th class="text-white py-2 px-3 text-right">تحویل دهنده</th>
                <th class="text-white py-2 px-3 text-right">فاکتور</th>
                <th class="text-white py-2 px-3 text-right">شماره فاکتور</th>
                <th class="text-white py-2 px-3 text-right">تاریخ فاکتور</th>
                <th class="text-white py-2 px-3 text-right">ورود به انبار</th>
                <th class="text-white py-2 px-3 text-right">انبار</th>
                <th class="text-white py-2 px-3 text-right">کاربر</th>
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
                <tr class="bg-gray-100">
                    <td class="py-2 px-3 bg-blue-300"><?= strtoupper($selected_record["partnumber"]) ?></td>
                    <td class="py-2 px-3"><?= $selected_record["brand_name"] ?></td>
                    <td class="py-2 px-3"><?= $selected_record["purchase_description"] ?></td>
                    <td class="py-2 px-3"><?= $selected_record["purchase_quantity"] ?></td>
                    <td class="py-2 px-3"><?= $selected_record["purchase_position1"] ?></td>
                    <td class="py-2 px-3"><?= $selected_record["purchase_position2"] ?></td>
                    <td class="py-2 px-3 bg-yellow-300"><?= $selected_record["seller_name"] ?></td>
                    <td class="py-2 px-3"><?= $jalali_time ?></td>
                    <td class="py-2 px-3"><?= $jalali_date ?></td>
                    <td class="py-2 px-3"><?= $selected_record["deliverer_name"] ?></td>
                    <td class="py-2 px-3"><?= $selected_record["purchase_hasBill"] == 0 ? 'خیر' : 'بلی' ?></td>
                    <td class="py-2 px-3"><?= $selected_record["invoice_number"] ?></td>
                    <td class="py-2 px-3"><?= substr($selected_record["invoice_date"], 5) ?></td>
                    <td class="py-2 px-3"><?= $selected_record["purchase_isEntered"] == 0 ? 'خیر' : 'بلی' ?></td>
                    <td class="py-2 px-3"><?= $selected_record["stock_name"] ?></td>
                    <td class="py-2 px-3 text-sm "><?= $selected_record["username"] ?></td>
                </tr>
            <?php else : ?>
                <tr class="">
                    <td colspan="18" class="cell-shakhes">شماره اشتباه</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <form method="post" action="" class="py-5 w-full grid grid-cols-2">
        <div class="px-5">
            <input value="<?= $selected_record["purchase_id"] ?>" type="hidden" name="id">
            <label for="purchase_quantity">تعداد</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $selected_record["purchase_quantity"] ?>" min="0" type="number" name="purchase_quantity" id="purchase_quantity">

            <label for="purchase_position1">راهرو</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $selected_record["purchase_position1"] ?>" onkeydown="upperCaseF(this)" type="text" name="purchase_position1" id="purchase_position1">

            <label for="purchase_position2">قفسه</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $selected_record["purchase_position2"] ?>" onkeydown="upperCaseF(this)" type="text" name="purchase_position2" id="purchase_position2">

            <label for="invoice_number_edit">شماره فاکتور</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $selected_record["invoice_number"] ?>" type="number" name="invoice_number_edit" id="invoice_number_edit">

            <label for="invoice_time_edit">زمان فاکتور</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $selected_record["invoice_date"] ?>" type="text" name="invoice_time_edit" id="invoice_time_edit">
            <span id="span_invoice_time"></span>
            <fieldset class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <legend>آیا فاکتور دارد ؟</legend>
                <label for="purchase_hasBill">خیر</label>
                <input type="radio" name="purchase_hasBill" id="purchase_hasBill" value="0" <?= $selected_record["purchase_hasBill"] == 0 ? 'checked' : '' ?>>
                <label for="nvoice">بله</label>
                <input type="radio" name="purchase_hasBill" id="purchase_hasBill" value="1" <?= $selected_record["purchase_hasBill"] == 1 ? 'checked' : '' ?>>
            </fieldset>
            <fieldset class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <legend>آیا وارد انبار شده ؟</legend>
                <label for="purchase_isEntered">خیر</label>
                <input type="radio" name="purchase_isEntered" id="purchase_isEntered" value="0" <?= $selected_record["purchase_isEntered"] == 0 ? 'checked' : '' ?>>

                <label for="purchase_isEntered">بله</label>
                <input type="radio" name="purchase_isEntered" id="purchase_isEntered" value="1" <?= $selected_record["purchase_isEntered"] == 1 ? 'checked' : '' ?>>
            </fieldset>
        </div>

        <div class="px-5">
            <label for="brand_edit">اصالت</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="brand_edit" id="brand_edit">
                <?php foreach ($brands as $brand) : ?>
                    <option <?= $selected_record["brand_id"] == $brand['id'] ? 'selected' : '' ?> value="<?= $brand['id'] ?>"> <?= $brand['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label>فروشنده</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="seller" id="seller">
                <?php include("./seller-form.php");
                foreach ($data as $key => $value) :
                ?>
                    <option <?= ($key == $seller_id) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>

            <label for="stock">انبار</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="stock" id="stock" data="<?= $stid ?>">
                <?php include("stock-form.php") ?>
            </select>

            <label for="deliverer">تحویل دهنده</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="deliverer" id="deliverer" data="<?= $dlid ?>">
                <?php include("deliverer-form.php") ?>
            </select>

            <label for="message" class="block mb-2 text-sm font-medium text-gray-900">توضیحات</label>
            <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?= $selected_record["purchase_description"] ?></textarea>
        </div>
        <div class="fixed right-0 left-0 bottom-0 px-5 py-2">
            <div class="flex justify-between">
                <div>
                    <input class="cursor-pointer text-white bg-green-800 rounded px-5 py-2" type="submit" value="ویرایش">
                    <span class="cursor-pointer text-white bg-rose-800 rounded px-5 py-2" data="<?= $qtybankID ?>"> حذف</span>
                </div>
                <div class="text-white bg-green-800 rounded px-5 py-2" class="error">عملیات موفقانه صورت گرفت</div>
            </div>
        </div>
    </form>
    <script src="../../js/vorodkala-edit.js?v=<?= (rand()) ?>"></script>
    <script src="../../js/form.js?v=<?= (rand()) ?>"></script>
    <script src="../../js/persianDatepicker.min.js?v=<?= (rand()) ?>"></script>
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
                                    brand.id AS brand_id,
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

function getBrands()
{
    $statement = DB_CONNECTION->prepare("SELECT * FROM yadakshop1402.brand");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getSellers()
{
    $statement = DB_CONNECTION->prepare("SELECT * FROM yadakshop1402.seller");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
