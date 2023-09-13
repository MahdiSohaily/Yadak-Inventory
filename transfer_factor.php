<!-- Print preview modal -->
<link rel="stylesheet" href="./public/css/transfer.css?v=<?= rand() ?>">

<div id="print_modal">
    <div id="print_container">
        <div id="invoiceholder">
            <div id="invoice" class="effect2">
                <div id="invoice-top">
                    <div class="title">
                        <h1 class="bold">فروشگاه یدک شاپ</h1>
                        <br>
                        <p>تاریخ فاکتور: <span id="invoice_date">1402/06/22</span>
                        </p>
                    </div><!--End Title-->
                    <div class="logo">
                        <img src="./public/img/logo.jpg" alt="Logo" />
                    </div>
                </div><!--End InvoiceTop-->
                <div id="invoice-mid">
                    <div class="col-left">
                        <div class="clientlogo">
                            <img src="https://cdn3.iconfinder.com/data/icons/daily-sales/512/Sale-card-address-512.png" alt="Sup" />
                        </div>
                        <div class="clientinfo">
                            <h2 id="supplier">نشانی</h2>
                            <p>
                                <span id="address">
                                    تهران میدان بهارستان
                                </span>
                                <br>
                                <span id="tax_num">کوچه نظامیه</span>
                                <br>
                                <span id="country">بن بست ویژه</span> - <span id="zip">پلاک ۴</span>
                                <br>
                                <span id="tax_num">۰۲۱۳۳۹۷۹۳۷۰</span><br>
                            </p>
                            </p>
                        </div>
                    </div>
                    <div class="col-right">
                        <table class="table" style="direction: rtl;">
                            <tbody>
                                <tr>
                                    <td>
                                        <b class="bold" id="currency">
                                            انبار دار:
                                        </b>
                                        <span>علی اکبر</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b class="bold" id="note">
                                            یادداشت:
                                        </b>
                                        <span></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div><!--End Invoice Mid-->

                <div id="invoice-bot">
                    <div id="table">
                        <table class="table-main">
                            <thead>
                                <tr class="tabletitle">
                                    <th class="cell-shakhes">ردیف</th>
                                    <th>شماره فنی</th>
                                    <th>برند</th>
                                    <th>توضیحات</th>
                                    <th>انبار مقصد</th>
                                    <th>تعداد</th>
                                    <th>فروشنده</th>
                                    <th>تحویل گیرنده</th>
                                    <th>تاریخ انتقال </th>
                                </tr>
                            </thead>
                            <tbody id="print_result">
                                <!-- Data are  goings to be appended here -->
                            </tbody>
                            <tr class="list-item total-row" style="background-color: lightgray;">
                                <th class="tableitem">مجموع </th>
                                <td colspan="8" data-label="Grand Total" class="tableitem">111.84</td>
                            </tr>
                        </table>
                    </div><!--End Table-->
                    <div class="cta-group">
                        <div id="message">
                            <h2>توجه!</h2>
                            <p>
                                درج امضاء تمامی مراجع ذکر شده در فاکتور الزامی میباشد.
                            </p>

                        </div>
                    </div>

                </div><!--End InvoiceBot-->
                <footer>
                    <div id="legalcopy" class="clearfix">
                        <div class="signature" style="display: flex; align-items: center;">
                            <div style="flex-grow: 1;">
                                <span class="small">امضاء انباردار ۱</span>
                            </div>
                            <div style="flex-grow: 1;">
                                <span class="small">امضاء پیک</span>

                            </div>

                            <div style="flex-grow: 1;">
                                <span class="small">امضاء حساب داری</span>
                            </div>
                            <div style="flex-grow: 1;">
                                <span class="small">امضاء امبار دار ۲</span>

                            </div>
                        </div>
                    </div>
                </footer>
            </div><!--End Invoice-->
        </div><!-- End Invoice Holder-->
    </div>
</div>