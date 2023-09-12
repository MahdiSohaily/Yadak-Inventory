<?php
require_once("header.php");

if (isset($_GET['interval'])) {
    $interval = $_GET['interval'];
}
?>
<style>
    tr:nth-child(odd) {
        background-color: lightgray;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination_item {
        text-decoration: none !important;
        background-color: purple;
        color: white;
        margin: 5px !important;
        width: 30px !important;
        height: 30px !important;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .action_bar {
        position: fixed;
        height: 60px;
        bottom: 0 !important;
        right: 0;
        left: 0;
        background-color: #dae5eb;
        display: flex;
        align-items: center;
    }

    .print-btn {
        padding-inline: 20px;
        background-color: seagreen;
    }

    #print_modal {
        position: fixed;
        background-color: rgba(0, 0, 0, 0.8);
        inset: 0;
        z-index: 100000;
        display: none;
        justify-content: center;
        align-items: center;
    }

    #print_container {
        background-color: white;
        width: 90vw;
        height: 95vh;
        border-radius: 10px;
        position: relative;
    }

    .signature {
        /* position: absolute; */
        bottom: 0;
        padding: 10px;
    }

    .text {
        font-size: 12px !important;
    }

    @media print {
        #page_header {
            display: none;
        }

        @page :footer {
            display: none !important;
        }

        @page :header {
            display: none !important;
        }

        @page {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        html {
            margin: 0;
            padding: 0;
        }

        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        main {
            padding: 0 !important;
        }

        #print_container {
            width: 100vw !important;
            height: 100vh !important;
        }

        table,
        td,
        th {
            border: 1px solid #ccc !important;
            color: black !important;
        }
    }

    .factor_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
    }

    .factor_logo {
        width: 100px;
    }
</style>

<div>
    <table id="report-table" class="report-table">
        <thead>
            <tr>
                <th>#</th>
                <th>شماره فنی</th>
                <th>برند</th>
                <th>توضیحات</th>
                <th>انبار مبدا</th>
                <th> تعداد قبلی</th>
                <th>انبار مقصد</th>
                <th>تعداد منتقل شده</th>
                <th>فروشنده</th>
                <th>تحویل گیرنده</th>
                <th>تاریخ انتقال </th>
                <th>کاربر</th>
                <th style="color: red;"> &#10084;</th>
            </tr>
        </thead>
        <tbody id="resultBox">
            <?php include("php/transfer_report_getter.php") ?>
        </tbody>
    </table>
</div>
<div class="action_bar">
    <button class="print-btn" onclick="makePreview()">پرنت</button>
</div>

<!-- Print preview modal -->
<div id="print_modal">
    <div id="print_container">
        <div class="factor_header">
            <div>
                <p>
                    شماره فاکتور: ۱
                </p>
                <p>
                    تاریخ:‌۱۴۰۲/۰۶/۲۱
                </p>
            </div>
            <div>
                <p>فاکتور جابجای انبار</p>
                <p>فروشگاه یدک شاپ</p>
            </div>
            <div>
                <img src="./public/img/logo.jpg" alt="logo" class="factor_logo">
            </div>
        </div>
        <div class="factor_info">
            انبار دار: علی اکبر
            <br>
            
        </div>
        <table id="report-table" class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>شماره فنی</th>
                    <th>برند</th>
                    <th>توضیحات</th>
                    <th>انبار مبدا</th>
                    <th> تعداد قبلی</th>
                    <th>انبار مقصد</th>
                    <th>تعداد منتقل شده</th>
                    <th>فروشنده</th>
                    <th>تحویل گیرنده</th>
                    <th>تاریخ انتقال </th>
                    <th>کاربر</th>
                </tr>
            </thead>
            <tbody id="print_result">

            </tbody>
        </table>

        <div class="signature">
            Signature
        </div>
    </div>
</div>

<script>
    const partNumber = document.getElementById('partNumber');
    const seller = document.getElementById('seller');
    const brand = document.getElementById('brand');
    const pos1 = document.getElementById('pos1');
    const pos2 = document.getElementById('pos2');
    const stock = document.getElementById('stock');
    const user = document.getElementById('user');
    const invoice_number = document.getElementById('invoice_number');
    const invoice_time = document.getElementById('invoice_time');
    const updateModal = document.getElementById('updateModal');

    function filterReport() {
        const partNumber_value = partNumber.value === '' ? null : partNumber.value;
        const seller_value = seller.value === 'انتخاب فروشنده' ? null : seller.value;
        const brand_value = brand.value === 'انتخاب برند جنس' ? null : brand.value;
        const pos1_value = pos1.value === '' ? null : pos1.value;
        const pos2_value = pos2.value === '' ? null : pos2.value;
        const stock_value = stock.value === 'انتخاب انبار' ? null : stock.value;
        const user_value = user.value === 'انتخاب کاربر' ? null : user.value;
        const invoice_number_value = invoice_number.value === '' ? null : invoice_number.value;
        const invoice_time_value = invoice_time.value === '' ? null : invoice_time.value;

        filter(partNumber_value, seller_value, brand_value, pos1_value, pos2_value,
            stock_value, user_value, invoice_number_value, invoice_time_value);
    }

    function clearFilter() {
        partNumber.value = '';
        seller.value = 'انتخاب فروشنده';
        brand.value = 'انتخاب برند جنس';
        pos1.value = '';
        pos2.value = '';
        stock.value = 'انتخاب انبار';
        user.value = 'انتخاب کاربر';
        invoice_number.value = '';
        invoice_time.value = '';
        document.getElementById('select2-seller-container').innerHTML = 'انتخاب فروشنده';
        document.getElementById('select2-brand-container').innerHTML = 'انتخاب برند جنس';
        document.getElementById('select2-stock-container').innerHTML = 'انتخاب انبار';
        document.getElementById('select2-user-container').innerHTML = 'انتخاب کاربر';
    }

    function displayModal(element) {
        id = element.getAttribute('id');
        updateModal.style.display = 'flex';
        updateModalIframe.src = './php/vorodkala-report-edit.php?q=' + id;
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
                    // This includes matching the `children` how you want in nested data sets
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
            // This includes matching the `children` how you want in nested data sets
            return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    function filter(partNumber_value = null,
        seller_value = null,
        brand_value = null,
        pos1_value = null,
        pos2_value = null,
        stock_value = null,
        user_value = null,
        invoice_number_value = null,
        invoice_time_value = null,
    ) {
        var params = new URLSearchParams();
        params.append('submit_filter', 'submit_filter');
        params.append('partNumber', partNumber_value);
        params.append('seller', seller_value);
        params.append('brand', brand_value);
        params.append('pos1', pos1_value);
        params.append('pos2', pos2_value);
        params.append('stock', stock_value);
        params.append('user', user_value);
        params.append('invoice_number', invoice_number_value);
        params.append('invoice_time', invoice_time_value);

        const resultBox = document.getElementById('resultBox');
        resultBox.innerHTML = `
                            <tr class='full-page'>
                                <td colspan='18'>
                                <img style='width: 60px; margin-block:30px' src='../callcenter/report/public/img/loading.png' alt='google'>
                                <p class="pt-2 text-gray-500">لطفا صبور باشید</p>
                                </td>
                            </tr>`;
        axios.post("./vorodkala-report-ajax.php", params)
            .then(function(response) {
                resultBox.innerHTML = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>
<script src="./public/js/transform_page.js?v=<?= rand() ?>"></script>


<?php include("footer.php") ?>