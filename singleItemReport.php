<?php
require_once("./views/Layout/header.php");
require_once("./app/controller/SingleItemReportController.php");

if (isset($_GET['code'])) {
    $code = $_GET['code'] ?? '';
}
?>
<link rel="stylesheet" href="./public/css/singleItem.css">
<link rel="stylesheet" href="./public/css/singleItem.css">
<div class="flex justify-center">
    <input class="form-controller" type="text" name="code" id="code" onkeyup="convertToEnglish(this);
    search(this.value);
    searchGoods(this.value);
    filter(this.value);
    filterExport(this.value);
    " ; placeholder="کد مد نظر خود را بصورت کامل وارد کنید">
</div>

<section id="price">
    <h2 style="font-size: 18px; font-weight: bold; text-align: center;">قیمت قطعه</h2>
    <table class="">
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
    <h2 style="font-size: 18px; font-weight: bold; text-align: center;">گزارش ورود</h2>
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
        <tbody id="mojodiResult" class="mojodi-table">
        </tbody>
    </table>
</section>
<section id="import">
    <h2 style="font-size: 18px; font-weight: bold; text-align: center;">گزارش ورود</h2>
    <table>
        <thead>
            <tr>
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
            </tr>
        </thead>
        <tbody id="resultBox">
        </tbody>
    </table>
</section>
<section id="export">
    <h2 style="font-size: 18px; font-weight: bold; text-align: center;">گزارش خروج</h2>
    <table style="background-color: white;">
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
                <img class=' block w-10 mx-auto h-auto' src='./public/img/loading.png' alt='loading'>
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

    function filter(partNumber_value = null) {
        var params = new URLSearchParams();
        params.append('submit_filter', 'submit_filter');
        params.append('partNumber', partNumber_value);

        const resultBox = document.getElementById('resultBox');
        resultBox.innerHTML = `
                            <tr class='full-page'>
                                <td colspan='18'>
                                <img style='width: 60px; margin-block:30px' src='../callcenter/report/public/img/loading.png' alt='google'>
                                <p class="pt-2 text-gray-500">لطفا صبور باشید</p>
                                </td>
                            </tr>`;
        axios.post("./singleImportReport.php", params)
            .then(function(response) {
                const data = response.data;
                resultBox.innerHTML = '';
                let counter = 1;
                for (item of data) {
                    resultBox.innerHTML += `
                    <tr class="left_right">
                        <td class="cell-shakhes ">${ counter }</td>
                        <td class="cell-code ">${item.partnumber.toUpperCase() }</td>
                        <td class="cell-brand cell-brand-${ item.name } ">${ item.name }</td>
                        <td class="cell-des ">${ item.des }</td>
                        <td class="cell-qty ">${ item.qty }</td>
                        <td class="cell-pos1 ">${ item.pos1 }</td>
                        <td class="cell-pos2 ">${ item.pos2 }</td>
                        <td class="cell-seller cell-seller-${ item.slid }">${ item.sln }</td>
                        <td class="cell-time ">${ item.invoice_date }</td>
                        <td class="cell-date ">${ item.invoice_date }</td>
                        <td class="cell-dlname ">${ item.dn }</td>
                        <td class="tik-inv-${ item.invoice }"></td>
                        <td>${ item.invoice_number }</td>
                        <td class="cell-date ">${ item.invoice_date }</td>
                        <td class="tik-anb-${ item.anbarenter }"></td>
                        <td class="cell-stock ">${ item.stn }</td>
                        <td class="cell-user ">${ item.un }</td>
                    </tr>
                    `;
                }
                counter++;
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    function filterExport(partNumber_value = null) {
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
                for (item of data) {
                    resultBox.innerHTML += `
                    <tr class="left_right">
                        <td class="text-center cell-shakhes ">${ counter }</td>
                        <td class="text-center cell-code ">${ (item.partnumber) }</td>
                        <td class="text-center cell-brand cell-brand-${ item.brn } ">${ item.brn }</td>
                        <td class="text-center cell-des ">${ item.des }</td>
                        <td class="text-center cell-des ">${ item.exdes }</td>
                        <td class="text-center cell-qty ">${ item.extqty }</td>
                        <td class="text-center cell-seller" style="width:180px">${ item.name }</td>
                        <td class="text-center cell-customer ">${ item.customer }</td>
                        <td class="text-center cell-gtname ">${ item.gtn }</td>
                        <td class="text-center cell-date ">${ item.exit_time }</td>
                        <td  class="cell-date " style="width:80px">${item.invoice_number}</td>
                        <td class="text-center cell-date ">${ item.invoice_date }</td>
                        <td class="text-center tik-anb-${ item.anbarenter }"></td>
                        <td class="text-center cell-time ">${ item.qty_invoice_number }</td>
                        <td class="text-center cell-time ">${ item.qty_invoice_date }</td>
                        <td class="text-center cell-stock ">${ item.stn }</td>
                        <td class="text-center cell-user ">${ item.usn }</td>
                    </tr>
                    `;
                    counter++;
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    <?php
    if (isset($code)) {
        echo "search('$code');";
        echo "searchGoods('$code');";
        echo "filter('$code');";
        echo "filterExport('$code');";
    }
    ?>
</script>