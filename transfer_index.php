<?php require_once("./views/Layout/header.php") ?>
<style>
    .custom-header {
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        margin-inline: 20px;
        background-color: #bbbbbb;
        border-radius: 10px;
    }
</style>

<style>
    .add-to-basket {
        padding: 0;
        margin: 0;
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
        color: black;
    }

    .fa-trash {
        color: red !important;
    }

    .factor_details tbody {
        min-height: 50px !important;
    }
</style>
<div id="QTY-Page">
    <h1 class="custom-header">انتقال اجناس به انبار جدید</h1>
    <form id="khorojkala" method="post" action="php/khorojkala-save.php" autocomplete="off">
        <div class="left-form">
            <?php require_once("php/qtybank.php") ?>
        </div>
        <div class="right-form">
            <input type="hidden" name="action" value="move">
            <label class="" for="getter">تحویل گیرنده</label>
            <select class="" name="getter" id="getter">
                <?php require_once("php/getter-form.php") ?>
            </select>
            <label for="stock">انبار مقصد</label>
            <select name="stock" id="stock">
                <?php require_once("php/stock-form.php") ?>
            </select>

            <label for="invoice_time">زمان فاکتور</label>
            <input value="<?php echo (jdate("Y/m/d", time(), "", "Asia/Tehran", "en")) ?>" type="text" name="invoice_time" id="invoice_time">
            <span id="span_invoice_time"></span>
            <label for="jamkon">جمع کننده</label>
            <input type="text" name="jamkon" id="jamkon">

            <label for="des">توضیحات</label>
            <textarea name="des" id="des"></textarea>
            <div class="add-to-basket">
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
            <div class="bottom-bar">
                <input type="submit" value="ذخیره" id="">
                <div class="error"></div>
            </div>
        </div>
    </form>
</div>

<?php require_once("./views/Layout/footer.php") ?>