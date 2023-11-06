<?php include("header.php") ?>

<style>
    #formData * {
        float: none !important;
    }

    #formData input,
    #formData textarea {
        width: 97% !important;
    }

    .select2-container {
        width: 100% !important;
        margin: 0 !important;
    }

    td {
        padding-block: 10px;
    }

    td:first-child {
        width: 120px;
    }

    table {
        width: 100% !important;
        flex-grow: initial;
    }

    .card {
        flex: 1 !important;
        background-color: whitesmoke;
        border-radius: 10px;
        padding: 10px;
        display: flex;
        justify-content: center;
    }


    .card_items {
        width: 100% !important;
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: start;
    }

    .card_items>input {
        float: none !important;
        display: inline-block;
        margin-inline: auto;
        width: 95%;
    }

    #txtHint-khoroj {
        margin-inline: auto;
        width: 95%;
    }

    .add-to-basket {
        padding: 0;
        margin: 0;
        background-color: transparent !important;
        width: 100% !important;
        box-shadow: none;
    }

    .factor_details {
        width: 100%;
        align-self: start;
        min-height: 300px;
        background-color: white;
    }

    .factor_details thead {
        background-color: #0c637d;
        color: white;
        text-align: right;
    }

    .factor_details tr:nth-child(even) {
        background-color: #d9edef;
    }

    .factor_details tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .factor_details td,
    .factor_details th {
        padding: 10px;
    }

    #good_amount,
    #totalCount {
        width: 80px !important;
        padding: 0;
    }

    .good_amount_details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        font-size: 14px !important;
        font-weight: bold;
    }

    .fa-trash {
        color: red !important;
    }

    .factor_details tbody {
        min-height: 50px !important;
    }

    #error_message {
        display: none;
    }

    #error_message p {
        font-size: 12px !important;
        color: red;
    }

    #totalCount {
        padding: 0 !important;
        margin: 0 !important;
        outline: none !important;
        background-color: #0c637d !important;
        color: #fff;
        border: none;
    }
</style>
<div id="QTY-Page">
    <div>
        <form id="khorojkala" method="post" action="php/khorojkala-save.php" autocomplete="off">
            <div style="display:flex; gap:20px; padding: 20px; min-height:83vh">
                <div class="card">
                    <div class="card_items">
                        <input type="search" style="direction: ltr; text-alignl" name="codeid" id="codeid" onkeyup="convertToEnglish(this); showQty(this.value); " placeholder="کد فنی">
                        <div id="txtHint-khoroj">
                            <p>...</p>
                        </div>
                    </div>
                </div>
                <div class="card" id="formData">
                    <table style="align-self:flex-start">
                        <tbody>
                            <tr>
                                <td>
                                    <p>شماره فاکتور</p>
                                </td>
                                <td>
                                    <input type="number" name="invoice_number" id="invoice_number" onchange="checkBillNumber(this.value)">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>خریدار</p>
                                </td>
                                <td>
                                    <input type="text" name="customer" id="customer">
                                    <input class="half-input" type="hidden" name="stock_hjdgshj" id="stock" value=''>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>تحویل گیرنده</p>
                                </td>
                                <td>
                                    <select name="getter" id="getter">
                                        <?php include("php/getter-form.php") ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>زمان فاکتور</p>
                                </td>
                                <td>
                                    <input value="<?php echo (jdate("Y/m/d", time(), "", "Asia/Tehran", "en")) ?>" type="text" name="invoice_time" id="invoice_time">
                                    <span id="span_invoice_time"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>جمع کننده</p>
                                </td>
                                <td>
                                    <input onkeyup="convertToPersian(this)" type="text" name="jamkon" id="jamkon">
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:super;">
                                    توضیحات
                                </td>
                                <td>
                                    <textarea name="des" id="des"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card">
                    <table class="factor_details">
                        <thead>
                            <tr>
                                <th>مشخصات</th>
                                <th style="text-align:left">
                                    <i class="fas fa-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="result_box">
                        </tbody>
                        <tfoot>
                            <tr id="error_message">
                                <td colspan="2">
                                    <p>تعداد درج شده بعضی از اجناس درست نمی باشد</p>
                                </td>
                            </tr>
                            <tr style="background-color: #0c637d; color:white">
                                <td colspan="2" style=" width:100% !important">
                                    <span> مجموع اقلام
                                    </span>
                                    <input type="number" name="total" id="totalCount" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
    </div>
    <div class="bottom-bar">
        <input type="submit" value="ذخیره" id="sabt">
        <div class="error">
        </div>
    </div>
    </form>
</div>
</div>

<script>
    function checkBillNumber(value) {
        var params = new URLSearchParams();
        params.append('value', value);

        axios.post("./checkFactorAjax.php", params)
            .then(function(response) {
                const factor = response.data;
                if (factor) {
                    document.getElementById('customer').value = factor.kharidar;
                    document.getElementById('sabt').disabled = false;
                } else {
                    alert('شماره فاکتور اشتباه است');
                    document.getElementById('sabt').disabled = true;
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    $('#getter').select2({
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
</script>

<?php include("footer.php") ?>