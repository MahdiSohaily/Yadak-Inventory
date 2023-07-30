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

        <div class="div" 6>
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
            <input type="text" name="exit_time" id="exit_time" placeholder="زمان خروج">
        </div>
        <div>
            <input type="submit" value="فیلتر" name="submit_filter">
            <button class="exportToExcel excel">
                <i class="fas fa-file-excel"></i>
                اکسل</button>
        </div>
    </form>
    <table id="resultBox" class="report-table">
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
        <?php include("php/vorodkala-report-geter.php") ?>
    </table>
</div>
<div id="updateModal">
    <div class="modalContent">
        <div class="modalHeader">
            <h2>ویرایش فاکتور خروجی</h2>
            <i onclick="closeModal()" class="fa fa-times closeModal" aria-hidden="true"></i>
        </div>
        <iframe id="updateModalIframe" width="1400" height="500" src="./php/khorojkala-report-edit.php" frameborder="0"></iframe>
    </div>

</div>
<script>
    const updateModal = document.getElementById('updateModal');

    function filterReport() {
        const partNumber = document.getElementById('partNumber').value === '' ? null : document.getElementById('partNumber').value;
        const seller = document.getElementById('seller').value === 'انتخاب فروشنده' ? null : document.getElementById('seller').value;
        const brand = document.getElementById('brand').value === 'انتخاب برند جنس' ? null : document.getElementById('brand').value;
        const pos1 = document.getElementById('pos1').value === '' ? null : document.getElementById('pos1').value;
        const pos2 = document.getElementById('pos2').value === '' ? null : document.getElementById('pos2').value;
        const stock = document.getElementById('stock').value === 'انتخاب انبار' ? null : document.getElementById('stock').value;
        const user = document.getElementById('user').value === 'انتخاب کاربر' ? null : document.getElementById('user').value;
        const invoice_number = document.getElementById('invoice_number').value === '' ? null : document.getElementById('invoice_number').value;
        const invoice_time = document.getElementById('invoice_time').value === '' ? null : document.getElementById('invoice_time').value;
        const exit_time = document.getElementById('exit_time').value === '' ? null : document.getElementById('exit_time').value;


        var params = new URLSearchParams();
        params.append('submit_filter', 'submit_filter');
        params.append('partNumber', partNumber);
        params.append('seller', seller);
        params.append('brand', brand);
        params.append('pos1', pos1);
        params.append('pos2', pos2);
        params.append('stock', stock);
        params.append('user', user);
        params.append('invoice_number', invoice_number);
        params.append('invoice_time', invoice_time);
        params.append('exit_time', exit_time);

        const resultBox = document.getElementById('resultBox');
        axios.post("./vorodkala-report-ajax.php", params)
            .then(function(response) {
                console.log(response.data);
                resultBox.innerHTML = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });
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
</script>


<?php include("footer.php") ?>