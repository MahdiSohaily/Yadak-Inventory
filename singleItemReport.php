<?php
require_once("./views/Layout/header.php");
require_once("./app/controller/SingleItemReportController.php");

if (isset($_GET['code'])) {
    $code = $_GET['code'] ?? '';
}
?>
<link rel="stylesheet" href="./public/css/singleItem.css">
<link rel="stylesheet" href="./public/css/singleItem.css">
<div class="flex justify-center" style="margin-bottom: 50px;">
    <input class="form-controller" type="text" name="code" id="code" onkeyup="convertToEnglish(this);
    search(this.value);
    searchGoods(this.value);
    filterExport(this.value);
    " ; placeholder="کد مد نظر خود را بصورت کامل وارد کنید">
</div>

<section id="price">
    <h2 style="font-size: 18px; font-weight: bold; text-align: center; padding-bottom:10px;">قیمت قطعه</h2>
    <table class="" style="direction: ltr !important;">
        <thead class="font-medium dark:border-neutral-500">
            <tr class="bg-green-700">
                <th scope="col" class="px-3 py-3 bg-black text-white w-52 text-center">
                    شماره فنی
                </th>
                <th scope="col" class="px-3 py-3 text-white w-20">
                    دلار پایه
                </th>
                <th scope="col" class="px-3 py-3 text-white border-black border-r-2">
                    +10%
                </th>
                <?php foreach ($rates as $rate) : ?>
                    <th class='<?= $rate['status']; ?> px-3 py-3 text-white text-center ' scope='col'>
                        <?= $rate['amount'] ?>
                    </th>
                <?php endforeach; ?>
                <th scope="col" class="px-3 py-3 text-white w-32 text-center">
                    عملیات
                </th>
                <th scope="col" class="px-3 py-3 text-white">
                    وزن
                </th>
            </tr>
        </thead>
        <tbody id="results">
        </tbody>
    </table>
</section>
<section id="existing">
    <h2 style="font-size: 18px; font-weight: bold; text-align: center; padding-bottom:10px;">موجودی انبار</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>شماره فنی</th>
                <th>برند</th>
                <th>تعداد موجود</th>
                <th>فروشنده</th>
                <th>راهرو</th>
                <th>قفسه</th>
                <th>توضیحات</th>
                <th>انبار</th>
            </tr>
        </thead>
        <tbody id="mojodiResult" style="background-color: white;">
        </tbody>
    </table>
</section>

<section id="export">
    <h2 style="font-size: 18px; font-weight: bold; text-align: center; padding-bottom:10px;">گزارش ورود / خروج</h2>
    <table style="background-color: white;">
        <thead>
            <tr>
                <th title="">#</th>
                <th title="شماره فنی">شماره فنی</th>
                <th title="برند">برند</th>
                <th title="توضیحات ورود">توضیحات</th>
                <th title="تعداد">تعداد</th>
                <th title="فروشنده">فروشنده</th>
                <th title="خریدار">خریدار</th>
                <th title="تاریخ خروج">تاریخ</th>
                <th title="شماره فاکتور خروج">شماره فاکتور</th>
                <th title="انبار">انبار</th>
                <th title="کاربر">کاربر</th>
                <th title="کاربر">نوعیت</th>
            </tr>
        </thead>
        <tbody id="filterExportResultBox">
        </tbody>
    </table>
</section>
<script src="./public/js/mojodi_kala.js?v=<?= rand() ?>"></script>
<script>
    let result = null;
    const search = (val) => {
        let pattern = val;
        const resultBox = document.getElementById("results");



        if (pattern.length >= 10) {
            pattern = pattern.replace(/\s/g, "");
            pattern = pattern.replace(/-/g, "");
            pattern = pattern.replace(/_/g, "");

            resultBox.innerHTML = `<tr class=''>
            <td colspan='14' class='py-10 text-center'> 
                <img style='width: 60px; margin-block:30px' class=' block w-10 mx-auto h-auto' src='./public/img/loading.png' alt='loading'>
                </td>
        </tr>`;
            var params = new URLSearchParams();
            params.append('pattern', pattern);

            axios.post("../callcenter/report/app/Controllers/SearchController.php", params)
                .then(function(response) {
                    resultBox.innerHTML = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            resultBox.innerHTML = "";
        }
    };

    function filterExport(partNumber_value = null) {

        if (partNumber_value.length >= 10) {
            var params = new URLSearchParams();
            params.append('submit_filter', 'submit_filter');
            params.append('partNumber', partNumber_value);
            const resultBox = document.getElementById('filterExportResultBox');
            resultBox.innerHTML = `
                            <tr class='full-page'>
                                <td colspan='18'>
                                <img style='width: 60px; margin-block:30px' src='../callcenter/report/public/img/loading.png' alt='google'>
                                <p class="pt-2 text-gray-500">لطفا صبور باشید</p>
                                </td>
                            </tr>`;
            axios.post("./singleExportReport.php", params)
                .then(function(response) {
                    const data = response.data;
                    resultBox.innerHTML = '';
                    let counter = 1;
                    if (data.length > 0) {
                        for (item of data) {
                            if (item.import) {
                                resultBox.innerHTML += `
                    <tr style="background-color:lightblue">
                        <td class="text-center cell-shakhes ">${ counter }</td>
                        <td class="text-center cell-code ">${ (item.partnumber) }</td>
                        <td class="text-center cell-brand cell-brand-${ item.brandName } ">${ item.brandName }</td>
                        <td class="text-center cell-des ">${ item.description }</td>
                        <td class="text-center cell-qty ">${ item.quantity }</td>
                        <td class="text-center cell-seller" style="width:180px">${ item.sellerName }</td>
                        <td class="text-center cell-customer ">${ item.customer }</td>
                        <td class="text-center cell-time ">${ item.invoice_date }</td>
                        <td  class="text-center cell-date " style="width:80px">${item.invoice_number}</td>
                        <td class="text-center cell-stock ">${ item.stockName }</td>
                        <td class="text-center cell-user ">${ item.username }</td>
                        <td class="text-center cell-user ">
                            <p style="color:white; background-color:seagreen; border-radius:5px; padding:10px">
                            ورود
                            </p>
                        </td>
                    </tr>
                    `;
                            } else {
                                resultBox.innerHTML += `
                    <tr style="background-color:lightyellow">
                        <td class="text-center cell-shakhes ">${ counter }</td>
                        <td class="text-center cell-code ">${ (item.partnumber) }</td>
                        <td class="text-center cell-brand cell-brand-${ item.brandName } ">${ item.brandName }</td>
                        <td class="text-center cell-des ">${ item.description }</td>
                        <td class="text-center cell-qty ">${ item.quantity }</td>
                        <td class="text-center cell-seller" style="width:180px">${ item.sellerName }</td>
                        <td class="text-center cell-customer ">${ item.customer }</td>
                        <td class="text-center cell-date ">${ item.invoice_date }</td>
                        <td class="text-center cell-time ">${ item.invoice_number }</td>
                        <td class="text-center cell-stock ">${ item.stockName }</td>
                        <td class="text-center cell-user ">${ item.username }</td>
                        <td class="text-center cell-user ">
                            <p style="color:white; background-color:red; border-radius:5px; padding:10px">
                                خروج
                            </p>
                        </td>
                    </tr>
                    `;
                            }

                            counter++;
                        }
                    } else {
                        resultBox.innerHTML += `
                    <tr style="background-color:lightyellow">
                        <td colspan="12" class="text-center">نتیجه ای دریافت نشد</td>
                    </tr>
                    `;
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    }

    <?php
    if (isset($code)) {
        echo "search('$code');";
        echo "searchGoods('$code');";
        echo "filterExport('$code');";
    }
    ?>
</script>