<?php
require_once("header.php");
include("php/seller-form.php")
?>



<div>
    <form id="parent" method="post" onsubmit="event.preventDefault(); filterReport(); return false" autocomplete="off">
        <div class="div1">
            <input type="text" name="partNumber" id="partNumber" placeholder="کد فنی">
        </div>

        <div class="div2">
            <select name="seller" id="seller">
                <option selected="true" disabled="disabled">انتخاب فروشنده</option>
                <?php
                foreach ($data as $key => $value) {
                    echo "<option value='$key'>$value</option>";
                }

                ?>
            </select>
        </div>

        <div class="div3">
            <select name="brand" id="brand">
                <option selected="true" disabled="disabled">انتخاب برند جنس</option>
                <?php include("php/brand-form.php") ?>
            </select>
        </div>

        <div class="div4">
            <input type="text" name="pos2" id="pos2" placeholder="قفسه">
        </div>

        <div class="div5">
            <input onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1" placeholder="راهرو">
        </div>

        <div class="div6">
            <select name="stock" id="stock">
                <option selected="true" disabled="disabled">انتخاب انبار</option>
                <?php include("php/stock-form.php") ?>
            </select>
        </div>

        <div class="div7">
            <select name="user" id="user">
                <option selected="true" disabled="disabled">انتخاب کاربر</option>
                <?php include("php/user-form.php") ?>
            </select>
        </div>

        <div class="div8">
            <input type="number" name="invoice_number" id="invoice_number" placeholder="شماره فاکتور">
        </div>

        <div class="div9">
            <input type="text" name="invoice_time" id="invoice_time" placeholder="زمان فاکتور">
        </div>
        <div class="div10">

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
        </div>
    </form>
    <table id="report-table" class="report-table">
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
                <?php if (userRoll() < 3) { ?>
                    <th>قیمت</th>

                <?php } ?>

                <th>عملیات</th>
            </tr>
        </thead>
        <tbody id="resultBox">
            <?php include("php/vorodkala-report-geter.php") ?>
        </tbody>
    </table>
</div>
<div id="updateModal">
    <div class="modalContent">
        <div class="modalHeader">
            <h2>ویرایش فاکتور ورودی</h2>
            <i onclick="closeModal()" class="fa fa-times closeModal" aria-hidden="true"></i>
        </div>
        <iframe id="updateModalIframe" width="1400" height="500" src="./php/khorojkala-report-edit.php" frameborder="0"></iframe>
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
    const exit_time = document.getElementById('exit_time');
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
        const exit_time_value = exit_time.value === '' ? null : exit_time.value;

        filter(partNumber_value, seller_value, brand_value, pos1_value, pos2_value,
            stock_value, user_value, invoice_number_value, invoice_time_value, exit_time_value);
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
        exit_time.value = '';
        document.getElementById('select2-seller-container').innerHTML = 'انتخاب فروشنده';
        document.getElementById('select2-brand-container').innerHTML = 'انتخاب برند جنس';
        document.getElementById('select2-stock-container').innerHTML = 'انتخاب انبار';
        document.getElementById('select2-user-container').innerHTML = 'انتخاب کاربر';
    }

    function displayModal(element) {
        id = element.getAttribute('id');
        updateModal.style.display = 'flex';
        updateModalIframe.src = './php/khorojkala-report-edit.php?q=' + id;
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
                    filename: "Exit Report " + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xlsx",
                    fileext: ".xlsx",
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
        exit_time_value = null
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
                console.log(response.data);
                resultBox.innerHTML = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>


<?php include("footer.php") ?>