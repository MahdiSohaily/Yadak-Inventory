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
                    <div id="message">
                        <h2></h2>
                        <p>An invoice with invoice number #<span id="invoice_num">tst-inv-23</span> is created for <span id="supplier_name">TESI S.P.A.</span> which is 100% matched with PO and is waiting for your approval. <a href="javascript:void(0);">Click here</a> to login to view the invoice.</p>
                    </div>
                    <div class="cta-group mobile-btn-group">
                        <a href="javascript:void(0);" class="btn-primary">Approve</a>
                        <a href="javascript:void(0);" class="btn-default">Reject</a>
                    </div>
                    <div class="clearfix">
                        <div class="col-left">
                            <div class="clientlogo">
                                <img src="https://cdn3.iconfinder.com/data/icons/daily-sales/512/Sale-card-address-512.png" alt="Sup" />
                            </div>
                            <div class="clientinfo">
                                <h2 id="supplier">TESI S.P.A.</h2>
                                <p><span id="address">VIA SAVIGLIANO, 48</span><br><span id="city">RORETO DI CHERASCO</span><br><span id="country">IT</span> - <span id="zip">12062</span><br><span id="tax_num">555-555-5555</span><br></p>
                            </div>
                        </div>
                        <div class="col-right">
                            <table class="table" style="direction: rtl;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label id="currency">انبار دار</label>
                                            <span>علی اکبر</span>
                                        </td>
                                        <td>
                                            <span>Invoice Total</span>
                                            <label id="invoice_total">61.2</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span>Invoice Type</span><label id="invoice_type">EXP REP INV</label></td>
                                        <td><span>Payment Term</span><label id="payment_term">60 gg DFFM</label></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label id="note">یادداشت</label>
                                            <span>Note</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--End Invoice Mid-->

                <div id="invoice-bot">

                    <div id="table">
                        <table class="table-main">
                            <thead>
                                <tr class="tabletitle">
                                    <th>ردیف</th>
                                    <th>کد فنی</th>
                                    <th>تعداد</th>
                                    <th>انبار مقصد</th>
                                    <th>Taxable Amount</th>
                                    <th>Tax Code</th>
                                    <th>%</th>
                                    <th>Tax Amount</th>
                                    <th>AWT</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tr class="list-item">
                                <td data-label="Type" class="tableitem">ITEM</td>
                                <td data-label="Quantity" class="tableitem">46.6</td>
                                <td data-label="Description" class="tableitem">Servizio EDI + Traffico mese di novembre 2017</td>
                                <td data-label="Unit Price" class="tableitem">1</td>
                                <td data-label="Taxable Amount" class="tableitem">46.6</td>
                                <td data-label="Tax Code" class="tableitem">DP20</td>
                                <td data-label="%" class="tableitem">20</td>
                                <td data-label="Tax Amount" class="tableitem">9.32</td>
                                <td data-label="AWT" class="tableitem">None</td>
                                <td data-label="Total" class="tableitem">55.92</td>
                            </tr>
                            <tr class="list-item">
                                <td data-label="Type" class="tableitem">ITEM</td>
                                <td data-label="Description" class="tableitem">Traffico mese di novembre 2017 FRESSNAPF TIERNAHRUNGS GMBH riadd. Almo DE</td>
                                <td data-label="Quantity" class="tableitem">4.4</td>
                                <td data-label="Unit Price" class="tableitem">1</td>
                                <td data-label="Taxable Amount" class="tableitem">46.6</td>
                                <td data-label="Tax Code" class="tableitem">DP20</td>
                                <td data-label="%" class="tableitem">20</td>
                                <td data-label="Tax Amount" class="tableitem">9.32</td>
                                <td data-label="AWT" class="tableitem">None</td>
                                <td data-label="Total" class="tableitem">55.92</td>
                            </tr>
                            <tr class="list-item total-row">
                                <th colspan="9" class="tableitem">Grand Total</th>
                                <td data-label="Grand Total" class="tableitem">111.84</td>
                            </tr>
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