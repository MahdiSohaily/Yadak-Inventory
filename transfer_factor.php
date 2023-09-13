<!-- Print preview modal -->
<link rel="stylesheet" href="./public/css/transfer.css?v=<?= rand() ?>">

<div id="print_modal">
    <div id="print_container">
        <div id="invoiceholder">
            <div id="invoice" class="effect2">
                <div id="invoice-top">
                    <div class="title">
                        <h1>فروشگاه یدک شاپ</h1>
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
                                        <label id="currency">
                                            انبار دار:
                                        </label>
                                        <span>علی اکبر</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="note">
                                            یادداشت:
                                        </label>
                                        <span>Note</span>
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
                            <tbody>
                                <tr class="list-item">
                                    <td data-label="Type" class="tableitem">553113F650</td>
                                    <td data-label="Type" class="tableitem">GEN</td>
                                    <td data-label="Quantity" class="tableitem">46.6</td>
                                    <td data-label="Unit Price" class="tableitem">1</td>
                                    <td data-label="Taxable Amount" class="tableitem">46.6</td>
                                    <td data-label="Tax Code" class="tableitem">DP20</td>
                                    <td data-label="%" class="tableitem">20</td>
                                    <td data-label="Tax Amount" class="tableitem">9.32</td>
                                </tr>
                                <tr class="list-item total-row">
                                    <th colspan="7" class="tableitem">Grand Total</th>
                                    <td data-label="Grand Total" class="tableitem">111.84</td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!--End Table-->
                    <div class="cta-group">
                        <a href="javascript:void(0);" class="btn-primary">Approve</a>
                        <a href="javascript:void(0);" class="btn-default">Reject</a>
                    </div>

                </div><!--End InvoiceBot-->
                <footer>
                    <div id="legalcopy" class="clearfix">
                        <p class="col-right">Our mailing address is:
                            <span class="email"><a href="mailto:supplier.portal@almonature.com">supplier.portal@almonature.com</a></span>
                        </p>
                    </div>
                </footer>
            </div><!--End Invoice-->
        </div><!-- End Invoice Holder-->
    </div>
</div>