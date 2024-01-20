<?php
require_once("./views/Layout/header.php");
require_once "./app/controller/SoldGoodsController.php";
require_once "./utilities/helpers.php";
?>
<style>
    .left_right {
        border-left: 2px solid lightgray;
        border-right: 2px solid lightgray;
    }

    .border_top {
        border-top: 2px solid lightgray !important;
    }

    .border_bottom {
        border-bottom: 2px solid lightgray !important;
    }

    .bg-black {
        background-color: #c9c8c3 !important;
        color: #545452;
        font-weight: bold;
    }

    #updateModal {
        align-items: end !important;
    }

    @media print {
        * {
            margin: 0 !important;
            padding: 0 !important;
            font-size: 12px !important;
            background-color: transparent !important;
            color: black !important;
            font-weight: normal !important;
        }

        table {
            width: 100% !important;
        }

        #main_nav,
        #parent,
        .operation {
            display: none !important;
        }

        body {
            padding: 0 !important;
            margin: 0 !important;
        }

        th {
            background-color: lightgray !important;
        }

        td,
        th {
            padding: 5px !important;
            font-size: 12px !important;
        }

        .total {
            padding-block: 10px !important;
        }

    }
</style>
<div class="">
    <form id="parent" method="post" onsubmit="event.preventDefault(); filterReport(); return false" autocomplete="off">
        <div class="div1">
            <input type="text" onkeyup="convertToEnglish(this)" name="partNumber" id="partNumber" placeholder="کد فنی">
        </div>

        <div class="div2">
            <select name="seller" id="seller">
                <option selected="true" disabled="disabled">انتخاب فروشنده</option>
                <?php
                foreach (getSellers() as $seller) : ?>
                    <option value='<?= $seller["id"] ?>'><?= $seller["name"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="div3">
            <select name="brand" id="brand">
                <option selected="true" disabled="disabled">انتخاب برند جنس</option>
                <?php foreach (getBrands() as $brand) : ?>
                    <option value='<?= $brand["id"] ?>'><?= $brand["name"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="div4">
            <input type="text" name="customer" id="customer" placeholder="خریدار">
        </div>

        <div class="div5">
            <input onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1" placeholder="راهرو">
        </div>

        <div class="div6">
            <select name="stock" id="stock">
                <option selected="true" disabled="disabled">انتخاب انبار</option>
                <?php foreach (getStocks() as $stock) : ?>
                    <option value='<?= $stock["id"] ?>'><?= $stock["name"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="div7">
            <select name="user" id="user">
                <option selected="true" disabled="disabled">انتخاب کاربر</option>
                <?php foreach (getUsers() as $user) : ?>
                    <option value='<?= $user["id"] ?>'><?= $user["username"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="div8">
            <input type="number" name="invoice_number" id="invoice_number" placeholder="شماره فاکتور">
        </div>

        <div class="div9">
            <input type="text" name="invoice_time" id="invoice_time" placeholder="زمان فاکتور">
        </div>
        <div class="div10">
            <input type="text" name="exit_time" id="exit_time" placeholder="زمان خروج">
        </div>
        <div style="display: flex;">
            <button class="filter" type="submit">
                <i style="padding-inline: 5px;" class="fa fa-filter" aria-hidden="true"></i>
                فیلتر
            </button>
            <a class="removeFilter" onclick="clearFilter()">
                <i style="padding-inline: 5px;" class="fa fa-trash" aria-hidden="true"></i>
                حذف فیلتر
            </a>
            <a class="exportToExcel excel">
                <i style="padding-inline: 5px;" class="fas fa-file-excel"></i>
                اکسل
            </a>
            <a href="./export_khoroj.php" class=" excel">
                <i style="padding-inline: 5px;" class="fas fa-file-excel"></i>
                اکسل جدید
            </a>
            <a onclick="window.print()" class="filter">
                <i style="padding-inline: 5px;" class="fas fa-print"></i>
                پرینت
            </a>
        </div>
    </form>
</div>
<table id="report-table" class="report-table">
    <thead>
        <tr>
            <th title="">#</th>
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
            <th class="operation" title="عملیات">عملیات</th>
        </tr>
    </thead>
    <tbody id="resultBox">
        <?php
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
                <td class="cell-customer "><?= $item["customer"] ?></td>
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

    </tbody>
</table>
<div id="updateModal">
    <div class="modalContent">
        <div class="modalHeader">
            <h2>ویرایش فاکتور خروج</h2>
            <i onclick="closeModal()" class="fa fa-times closeModal" aria-hidden="true"></i>
        </div>
        <div class="displayPage">
            <iframe style="width: 100%; height:80vh !important" id="editPage" src="" frameborder="0"></iframe>
        </div>
    </div>
</div>
<script>
    const partNumber = document.getElementById('partNumber');
    const seller = document.getElementById('seller');
    const brand = document.getElementById('brand');
    const pos1 = document.getElementById('pos1');
    const customer = document.getElementById('customer');
    const stock = document.getElementById('stock');
    const user = document.getElementById('user');
    const invoice_number = document.getElementById('invoice_number');
    const invoice_time = document.getElementById('invoice_time');
    const exit_time = document.getElementById('exit_time');
    const updateModal = document.getElementById('updateModal');

    function filterReport() {
        const partNumber_value = partNumber.value === '' ? null : partNumber.value;
        const seller_value = seller.value === 'انتخاب فروشنده' ? null : seller.value;
        const brand_value = brand.value === 'انتخاب برند جنس' ? null : brand.value;
        const pos1_value = pos1.value === '' ? null : pos1.value;
        const customer_value = customer.value === '' ? null : customer.value;
        const stock_value = stock.value === 'انتخاب انبار' ? null : stock.value;
        const user_value = user.value === 'انتخاب کاربر' ? null : user.value;
        const invoice_number_value = invoice_number.value === '' ? null : invoice_number.value;
        const invoice_time_value = invoice_time.value === '' ? null : invoice_time.value;
        const exit_time_value = exit_time.getAttribute('data-gdate') === '' ? null : exit_time.getAttribute('data-gdate');
        filter(partNumber_value, seller_value, brand_value, pos1_value, customer_value,
            stock_value, user_value, invoice_number_value, invoice_time_value, exit_time_value);
    }

    function clearFilter() {
        partNumber.value = '';
        seller.value = 'انتخاب فروشنده';
        brand.value = 'انتخاب برند جنس';
        pos1.value = '';
        customer.value = '';
        stock.value = 'انتخاب انبار';
        user.value = 'انتخاب کاربر';
        invoice_number.value = '';
        invoice_time.value = '';
        exit_time.value = '';
        document.getElementById('select2-seller-container').innerHTML = 'انتخاب فروشنده';
        document.getElementById('select2-brand-container').innerHTML = 'انتخاب برند جنس';
        document.getElementById('select2-stock-container').innerHTML = 'انتخاب انبار';
        document.getElementById('select2-user-container').innerHTML = 'انتخاب کاربر';
    }

    function displayModal(element) {
        updateModal.style.display = 'flex';
        const iframe = document.getElementById('editPage');
        const targetElement = element.getAttribute('data-target');

        iframe.src = "./app/partials/editSoldGood.php?record=" + targetElement;
    }

    function closeModal() {
        updateModal.style.display = 'none';
    }
    var modal = document.getElementById("updateModal");
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    $(function() {
        $(".exportToExcel").click(function(e) {
            var table = $('#report-table');
            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Exit Report",
                    filename: "Exit Report " + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('#seller').select2({
            matcher: matchCustom
        });
        $('#brand').select2({
            matcher: function matchCustom(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                if (data.text.indexOf(params.term.toUpperCase()) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.text += '';

                    // You can return modified objects from here
                    // This require_onces matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });
        $('#stock').select2({
            matcher: matchCustom
        });
        $('#user').select2({
            matcher: matchCustom
        });

    });

    // This function helps to display only the matching results when user types a keyword (Slecte 2 plugin)
    function matchCustom(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
            return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
            return null;
        }

        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (data.text.indexOf(params.term) > -1) {
            var modifiedData = $.extend({}, data, true);
            modifiedData.text += '';

            // You can return modified objects from here
            // This require_onces matching the `children` how you want in nested data sets
            return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    function filter(partNumber_value = null,
        seller_value = null,
        brand_value = null,
        pos1_value = null,
        customer = null,
        stock_value = null,
        user_value = null,
        invoice_number_value = null,
        invoice_time_value = null,
        exit_time_value = null
    ) {
        var params = new URLSearchParams();
        params.append('submit_filter', 'submit_filter');
        params.append('partNumber', partNumber_value);
        params.append('seller', seller_value);
        params.append('brand', brand_value);
        params.append('pos1', pos1_value);
        params.append('customer', customer);
        params.append('stock', stock_value);
        params.append('user', user_value);
        params.append('invoice_number', invoice_number_value);
        params.append('invoice_time', invoice_time_value);
        params.append('exit_time', exit_time_value);

        const resultBox = document.getElementById('resultBox');
        resultBox.innerHTML = `
                            <tr class='full-page'>
                                <td colspan='18'>
                                <img style='width: 60px; margin-block:30px' src='../callcenter/report/public/img/loading.png' alt='google'>
                                <p class="pt-2 text-gray-500">لطفا صبور باشید</p>
                                </td>
                            </tr>`;
        axios.post("./khorojkala-report-ajax.php", params)
            .then(function(response) {
                resultBox.innerHTML = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>
<?php require_once("./views/Layout/footer.php") ?>