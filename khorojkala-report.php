<?php require_once("header.php");
?>
<style>
    th {
        cursor: pointer;
    }

    #parent {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(3, 1fr);
        grid-column-gap: 6px;
        grid-row-gap: 6px;
        background-color: lightgray;
        padding: 10px !important;
        margin: 10px !important;
        border-radius: 10px;
    }

    .div1 {
        grid-area: 1 / 1 / 2 / 2;
    }

    .div2 {
        grid-area: 1 / 2 / 2 / 3;
    }

    .div3 {
        grid-area: 1 / 3 / 2 / 4;
    }

    .div4 {
        grid-area: 1 / 4 / 2 / 5;
    }

    .div5 {
        grid-area: 1 / 5 / 2 / 6;
    }

    .div6 {
        grid-area: 2 / 1 / 3 / 2;
    }

    .div7 {
        grid-area: 2 / 2 / 3 / 3;
    }

    .div8 {
        grid-area: 2 / 3 / 3 / 4;
    }

    .div9 {
        grid-area: 2 / 4 / 3 / 5;
    }

    .div10 {
        grid-area: 2 / 5 / 3 / 6;
    }

    select,
    option,
    input,
    label {
        font-size: 14px !important;
    }
</style>
<div>
    <div>
        <div class="">
            <form id="parent" method="post" action="./khorojkala-report-ajax.php" autocomplete="off">
                <div class="div1">
                    <input type="text" name="partNumber" id="codeid">
                    <label for="codeid">کد فنی</label>
                </div>

                <div class="div2">
                    <select name="seller" id="seller">
                        <option selected="true" disabled="disabled">انتخاب فروشنده</option>
                        <?php include("php/seller-form.php") ?>
                    </select>
                    <label for="seller">فروشنده</label>
                </div>

                <div class="div3">
                    <select name="brand" id="esalat">
                        <option selected="true" disabled="disabled">انتخاب برند جنس</option>
                        <?php include("php/brand-form.php") ?>
                    </select>
                    <label for="brand">اصالت</label>
                </div>

                <div class="div4">
                    <input onkeydown="upperCaseF(this)" type="text" name="pos2" id="pos2">
                    <label for="pos2">قفسه</label>
                </div>

                <div class="div5">
                    <input onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1">
                    <label for="pos1">راهرو</label>
                </div>

                <div class="div" 6>
                    <select name="stock" id="stock">
                        <option selected="true" disabled="disabled">انتخاب انبار</option>
                        <?php include("php/stock-form.php") ?>
                    </select>
                    <label for="stock">انبار</label>
                </div>

                <div class="div7">
                    <select name="user" id="user">
                        <option selected="true" disabled="disabled">انتخاب کاربر</option>
                        <?php include("php/user-form.php") ?>
                    </select>
                    <label for="user">کاربر</label>
                </div>

                <div class="div8">
                    <input type="number" name="invoice_number" id="invoice_number">
                    <label for="invoice_number">شماره فاکتور</label>
                </div>

                <div class="div9">
                    <input type="text" name="invoice_time" id="invoice_time">
                    <label for="invoice_time">زمان فاکتور</label>
                </div>
                <div class="div10">
                    <input type="text" name="exit_time" id="exit_time">
                    <label for="exit_time">زمان خروج </label>
                </div>
                <div>
                    <input type="submit" value="فیلتر" name="submit_filter">
                    <a id="excel">اکسل <i class="fas fa-file-excel"></i></a>
                </div>
            </form>
        </div>
        <table class="report-table">
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
                    <th title="عملیات">عملیات</th>
                </tr>
            </thead>
            <tbody id="resultBox">
                <?php include("php/khorojkala-report-geter.php") ?>
            </tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>
            <iframe width="100%" height="370px" src=""></iframe>
        </p>
    </div>
</div>

<?php include("footer.php") ?>