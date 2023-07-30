<?php
require_once("header.php");
include("php/seller-form.php")

?>
<div>
    <div class="">
        <?php
        require_once("./php/filter.php");
        ?>
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
                <th title="عملیات">عملیات</th>
            </tr>
        </thead>
        <tbody id="resultBox">
            <?php include("php/khorojkala-report-geter.php") ?>
        </tbody>
    </table>
</div>




<?php include("footer.php") ?>