<?php include("./views/Layout/newHeader.php");
require_once "./utilities/helpers.php";
?>
<script src="../callcenter/report/public/js/index.js"></script>
<style>
    .right-form td {
        padding: 10px !important;
    }

    .right-form td:first-child {
        width: 150px !important;
    }

    .right-form select {
        display: block !important;
    }

    .right-form input {
        padding: 10px !important;
        margin: 0 !important;
        float: none !important;
    }

    .right-form input[type=radio] {
        width: auto !important;
    }

    .right-form textarea {
        float: none !important;
    }

    .right-form li span {
        padding-inline: 10px;
    }

    .right-form label {
        width: auto !important;
        float: none !important;
        cursor: pointer;
    }

    .right-form .factor_details {
        opacity: 0;
        transition: opacity 0.5s;
    }
</style>

<div class="flex justify-center px-5">
    <!-- <form id="vorodkala" method="post" action="php/vorodkala-save.php" autocomplete="off">
        <div class="left-form">
            <?php include("php/codeid.php") ?>
        </div>
        <div class="right">
            <input type="hidden" name="brand-box" id="brand-box">
            <table style="width: 100% !important;">
                <tbody>
                    <tr>
                        <td>
                            <p for="brand">اصالت</p>
                        </td>
                        <td>
                            <select name="brand" id="esalat">
                                <?php include("php/brand-form.php") ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>فروشنده</p>
                        </td>
                        <td>
                            <select name="seller" id="seller">
                                <option selected="true" disabled="disabled">انتخاب فروشنده</option>
                                <?php
                                foreach (getSellers() as $seller) : ?>
                                    <option value='<?= $seller["id"] ?>'><?= $seller["name"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            تحویل دهنده
                        </td>
                        <td>
                            <select name="deliverer" id="deliverer">
                                <?php include("php/deliverer-form.php") ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>تعداد</p>
                        </td>
                        <td>
                            <input required min="0" type="number" name="qty" id="qty">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                قفسه
                            </p>
                        </td>
                        <td>
                            <input onkeydown="upperCaseF(this)" type="text" name="pos2" id="pos2">
                        </td>
                    </tr>
                    <tr>
                        <td>راهرو</td>
                        <td>
                            <input onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1">
                        </td>
                    </tr>
                    <tr>
                        <td>انبار</td>
                        <td>
                            <select name="stock" id="stock">
                                <?php include("php/stock-form.php") ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">

                            توضیحات
                        </td>
                        <td>
                            <textarea name="des" id="des"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>آیا فاکتور دارد ؟</p>
                        </td>
                        <td>
                            <ul>
                                <br>
                                <li style="margin-bottom: 10px;">
                                    <label for="invoice">
                                        <input type="radio" name="invoice" data-name="yes" id="invoice" value="1" checked>
                                        بله
                                    </label>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <label for="invoiceNO">
                                        <input type="radio" name="invoice" data-name="no" id="invoiceNO" value="0">
                                        خیر
                                    </label>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="factor_details">
                        <td>
                            <p>شماره فاکتور</p>
                        </td>
                        <td>
                            <input type="number" name="invoice_number" id="invoice_number">
                        </td>
                    </tr>
                    <tr class="factor_details">
                        <td>
                            <p>زمان فاکتور</p>
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>آیا وارد انبار شده ؟</p>
                        </td>
                        <td>
                            <ul>
                                <li style="margin-bottom: 10px;">
                                    <label for="anbarenter">
                                        <input type="radio" name="anbarenter" id="anbarenter" value="0">
                                        خیر
                                    </label>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <label for="anbarenterNo">
                                        <input type="radio" name="anbarenter" id="anbarenterNo" value="1" checked>
                                        بله
                                    </label>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>



        </div>

        <div class="bottom-bar">
            <input type="submit" value="ذخیره" id="">
            <div class="error">
            </div>
        </div>

    </form> -->
    <div class="w-1/2">
        <table class="w-full border border-1 border-gray-800">
            <thead class="bg-gray-100">
                <tr class="bg-gray-800">
                    <th class="p-3 text-white" colspan="4">فاکتور ورود</th>
                </tr>
                <tr>
                    <th class="text-right p-3 text-sm">
                        <label class="cursor-pointer" for="bill_number">شماره فاکتور</label>
                    </th>
                    <th class="p-3">
                        <input class="p-2 border w-full" type="text" name="bill_number" id="bill_number">
                    </th>
                    <th class="text-right p-3 text-sm">
                        <label class="cursor-pointer" for="invoice_time">تاریخ</label>
                    </th>
                    <th class="p-3">
                        <input class="p-2 w-full h-full" type="text" name="invoice_time" id="invoice_time" value="<?php echo (jdate("Y/m/d", time(), "", "Asia/Tehran", "en")) ?>">
                        <span id="span_invoice_time"></span>
                    </th>
                </tr>
                <tr>
                    <th class="text-right p-3 text-sm">
                        <label class="cursor-pointer" for="seller">فروشنده</label>
                    </th>
                    <th class="p-3 relative">
                        <input class="p-2 border w-full" type="text" name="seller" id="seller" onkeyup="searchSellers(this.value)">
                        <div id="seller_container"></div>
                    </th>
                    <th class="text-right p-3 text-sm">
                        <label class="cursor-pointer" for="is_entered">وارد انبار شده؟</label>
                    </th>
                    <th class="p-3 grid grid-cols-2">
                        <div class="flex gap-0">
                            <label class="cursor-pointer" for="is_entered_true">بلی</label>
                            <input class="p-2 w-full h-full" type="radio" name="is_entered" id="is_entered_true">
                        </div>

                        <div class="flex gap-0">
                            <label class="cursor-pointer" for="is_entered_false">خیر</label>
                            <input class="p-2 w-full h-full" type="radio" name="is_entered" id="is_entered_false">
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="bill_items_container" class="m-h-12">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot class="bg-gray-100">
                <tr>
                    <td class="p-3 text-sm font-bold">کدفنی</td>
                    <td class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="text" name="" id="">
                    </td>
                    <td class="p-3 text-sm font-bold">اصالت</td>
                    <td class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="text" name="" id="">
                    </td>
                </tr>
                <tr>
                    <td class="p-3 text-sm font-bold">تعداد</td>
                    <td class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="text" name="" id="">
                    </td>
                    <td class="p-3 text-sm font-bold">قفسه</td>
                    <td class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="text" name="" id="">
                    </td>
                </tr>
                <tr>
                    <td class="p-3 text-sm font-bold">راهرو</td>
                    <td class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="text" name="" id="">
                    </td>
                    <td class="p-3 text-sm font-bold">توضیحات</td>
                    <td class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="text" name="" id="">
                    </td>
                </tr>
            </tfoot>
        </table>
        <span>w</span>
    </div>
</div>

<script>
    let factor_info = {
        seller: '',
        date: '',
        bill_number: '',
        is_entered: false
    }

    let factor_items = [];

    function searchSellers(pattern = '') {
        var params = new URLSearchParams();
        axios.post("./vorodkala-report-ajax.php", params)
            .then(function(response) {
                resultBox.innerHTML = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>
</div>
<?php include("./views/Layout/footer.php") ?>