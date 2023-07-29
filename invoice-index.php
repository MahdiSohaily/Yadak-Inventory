<?php include("header.php") ?>


<div id="Invoice-Page">









    <div class="side A-side">
        <label for="customer-inv-select">انتخاب مشتری</label>
        <input type="text" name="customer-inv-select" id="customer-inv-select" onkeyup="selectCustomer(this.value)">
        <div class="hint" id="customer-inv-hint">...</div>
    </div>
    <div class="side B-side">
        <label for="code-inv-select">انتخاب کد فنی</label>
        <input type="text" name="code-inv-select" id="code-inv-select" onkeyup="selectInvCode(this.value)">
        <div class="hint" id="code-inv-hint">...</div>
    </div>
    <div class="side C-side">
        <label for="qty-inv-select">انتخاب کالای موجود</label>
        <input type="text" name="qty-inv-select" id="qty-inv-select" onkeyup="selectInvQty(this.value)">
        <div class="hint" id="qty-inv-hint">...</div>
    </div>


    <div class="output-inv">

        <div class="invoice-table">
            <div class="invoice-first-row">
                <div class="invoice-row-id">ردیف</div>
                <div class="invoice-row-code">کد فنی</div>
                <div class="invoice-row-name">نام قطعه</div>
                <div class="invoice-row-brand">برند</div>
                <div class="invoice-row-stock">انبار</div>
                <div class="invoice-row-qty">تعداد</div>
                <div class="invoice-row-price">قیمت</div>
                <div class="invoice-row-rowtotal">قیمت کل</div>
            </div>
        </div>

    </div>

    <div class="bottom-bar">
        <a class="print-btn">پیش نمایش</a>
        <a class="print-btn">ذخیره فایل</a>
        <a class="print-btn">پرینت همکار</a>
        <a class="print-btn">پرینت یدک شاپ</a>
        <a class="print-btn">پرینت کره اتو پارت</a>
        <a class="print-btn">پرینت یدک پلاس</a>
        <a class="print-btn">پرینت بیمه</a>
        <div class="error">
        </div>
    </div>


</div>


<?php include("footer.php") ?>
