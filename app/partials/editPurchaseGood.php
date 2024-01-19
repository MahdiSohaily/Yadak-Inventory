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
            if ($selected_record) :
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
                    <td class="py-2 px-3 text-sm"><?= $jalali_time ?></td>
                    <td class="py-2 px-3 text-sm"><?= $jalali_date ?></td>
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
                    <td colspan="18" class="text-center bg-rose-400 py-3">
                        <p class="text-white">ریکارد مد نظر شما در سیستم موجود نمی باشد</p>
                    </td>
                </tr>
            <?php die();
            endif; ?>
        </tbody>
    </table>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="p-5 w-full grid grid-cols-2">
        <div class="px-5">
            <input value="<?= $selected_record["purchase_id"] ?>" type="hidden" name="selected_record_id">
            <label for="purchase_quantity">تعداد</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" value="<?= $selected_record["purchase_quantity"] ?>" min="0" type="number" name="purchase_quantity" id="purchase_quantity">

            <label for="purchase_position1">راهرو</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" value="<?= $selected_record["purchase_position1"] ?>" onkeydown="upperCaseF(this)" type="text" name="purchase_position1" id="purchase_position1">

            <label for="purchase_position2">قفسه</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" value="<?= $selected_record["purchase_position2"] ?>" onkeydown="upperCaseF(this)" type="text" name="purchase_position2" id="purchase_position2">

            <label for="invoice_number_edit">شماره فاکتور</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" value="<?= $selected_record["invoice_number"] ?>" type="text" name="invoice_number_edit" id="invoice_number_edit">

            <label for="invoice_time">زمان فاکتور</label>
            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" value="<?= $selected_record["invoice_date"] ?>" type="text" name="invoice_time_edit" id="invoice_time">
            <span id="span_invoice_time"></span>
            <fieldset class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2">
                <legend>آیا فاکتور دارد ؟</legend>
                <label for="purchase_hasBill_false">خیر</label>
                <input class="cursor-pointer" type="radio" name="purchase_hasBill" id="purchase_hasBill_false" value="0" <?= $selected_record["purchase_hasBill"] == 0 ? 'checked' : '' ?>>
                <label class="mr-5" for="purchase_hasBill_false">بله</label>
                <input class="cursor-pointer" type="radio" name="purchase_hasBill" id="purchase_hasBill_true" value="1" <?= $selected_record["purchase_hasBill"] == 1 ? 'checked' : '' ?>>
            </fieldset>
            <fieldset class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2">
                <legend>آیا وارد انبار شده ؟</legend>
                <label for="purchase_isEntered_false">خیر</label>
                <input class="cursor-pointer" type="radio" name="purchase_isEntered" id="purchase_isEntered_false" value="0" <?= $selected_record["purchase_isEntered"] == 0 ? 'checked' : '' ?>>

                <label class="mr-5" for="purchase_isEntered_true">بله</label>
                <input class="cursor-pointer" type="radio" name="purchase_isEntered" id="purchase_isEntered_true" value="1" <?= $selected_record["purchase_isEntered"] == 1 ? 'checked' : '' ?>>
            </fieldset>
        </div>

        <div class="px-5">
            <label for="brand_edit">اصالت</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" name="brand_edit" id="brand_edit">
                <?php foreach ($brands as $brand) : ?>
                    <option <?= $selected_record["brand_id"] == $brand['id'] ? 'selected' : '' ?> value="<?= $brand['id'] ?>"> <?= $brand['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="seller_edit">فروشنده</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" name="seller_edit" id="seller_edit">
                <?php
                foreach ($sellers as $seller) : ?>
                    <option title="<?= $seller['latinName'] ?>" value="<?= $seller['id'] ?>" <?= $selected_record["seller_id"] == $seller['id'] ? 'selected' : '' ?>>
                        <?= $seller['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="stock_edit">انبار</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" name="stock_edit" id="stock_edit">
                <?php
                foreach ($stocks as $stock) : ?>
                    <option value="<?= $stock['id'] ?>" <?= $selected_record["stock_id"] == $stock['id'] ? 'selected' : '' ?>>
                        <?= $stock['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="deliverer_edit">تحویل دهنده</label>
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 mb-2" name="deliverer_edit" id="deliverer_edit">
                <?php
                foreach ($deliverers as $deliverer) : ?>
                    <option value="<?= $deliverer['id'] ?>" <?= $selected_record["delivery_id"] == $deliverer['id'] ? 'selected' : '' ?>>
                        <?= $deliverer['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

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
    <script src="../../js/vorodkala-edit.js?v=<?= (rand()) ?>"></script>
    <script src="../../js/form.js?v=<?= (rand()) ?>"></script>
    <script src="../../js/persianDatepicker.min.js?v=<?= (rand()) ?>"></script>
    <script>
        function deleteRecord(record) {
            const result = confirm('آیا مطمئن هستید که این ریکارد حذف شود ؟');

            if (result) {
                var params = new URLSearchParams();
                params.append('delete_record', 'delete_record');
                params.append('record_id', record);
                axios.post("../controller/PurchaseGoodsAjax.php", params)
                    .then(function(response) {
                        document.getElementById('delete_message').style.display = 'block';
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
        }
    </script>
</body>

</html>

<?php
function getRecord($record_id)
{
    try {
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
    deliverer.id AS delivery_id,
    deliverer.name AS deliverer_name,
    users.username AS username,
    stock.id AS stock_id,
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

        return $purchaseList ? $purchaseList[0] : [];
    } catch (\Throwable $th) {
        die('ریکارد مد نظر شما در سیستم موجود نمی باشد.');
    }
}

function saveChanges($data)
{
    $record_id = $data['selected_record_id'];
    $purchase_quantity = $data['purchase_quantity'];
    $purchase_position1 = $data['purchase_position1'];
    $purchase_position2 = $data['purchase_position2'];
    $invoice_number_edit = $data['invoice_number_edit'];
    $invoice_time_edit = $data['invoice_time_edit'];
    $purchase_hasBill = $data['purchase_hasBill'];
    $purchase_isEntered = $data['purchase_isEntered'];
    $brand_edit = $data['brand_edit'];
    $seller_edit = $data['seller_edit'];
    $stock_edit = $data['stock_edit'];
    $deliverer_edit = $data['deliverer_edit'];
    $purchase_description = $data['purchase_description'];

    // Assuming DB_CONNECTION is a PDO instance
    $statement = DB_CONNECTION->prepare("UPDATE yadakshop1402.qtybank
        SET brand = :brand,
        des = :purchase_description,
        qty = :purchase_quantity,
        pos1 = :purchase_position1,
        pos2 = :purchase_position2,
        seller = :seller_edit,
        deliverer = :deliverer_edit,
        invoice = :purchase_isEntered,
        anbarenter = :purchase_isEntered,
        invoice_number = :invoice_number_edit,
        stock_id = :stock_edit,
        invoice_date = :invoice_time_edit
        WHERE id = :record_id
    ");

    // Bind parameters
    $statement->bindParam(':brand', $brand_edit);
    $statement->bindParam(':purchase_description', $purchase_description);
    $statement->bindParam(':purchase_quantity', $purchase_quantity);
    $statement->bindParam(':purchase_position1', $purchase_position1);
    $statement->bindParam(':purchase_position2', $purchase_position2);
    $statement->bindParam(':seller_edit', $seller_edit);
    $statement->bindParam(':deliverer_edit', $deliverer_edit);
    $statement->bindParam(':purchase_isEntered', $purchase_isEntered);
    $statement->bindParam(':invoice_number_edit', $invoice_number_edit);
    $statement->bindParam(':stock_edit', $stock_edit);
    $statement->bindParam(':invoice_time_edit', $invoice_time_edit);
    $statement->bindParam(':record_id', $record_id);

    // Execute the statement
    $statement->execute();

    // Check for success
    if ($statement->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
