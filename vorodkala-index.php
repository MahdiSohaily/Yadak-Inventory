<?php include("./views/Layout/header.php");
require_once "./utilities/helpers.php";
?>
<script src="../callcenter/report/public/js/index.js"></script>
<style>
    .right-form td {
        padding: 10px !important;
    }

    .right-form td:first-child {
        width: 150px !important;
    }

    .right-form select {
        display: block !important;
    }

    .right-form input {
        padding: 10px !important;
        margin: 0 !important;
        float: none !important;
    }

    .right-form input[type=radio] {
        width: auto !important;
    }

    .right-form textarea {
        float: none !important;
    }

    .right-form li span {
        padding-inline: 10px;
    }

    .right-form label {
        width: auto !important;
        float: none !important;
        cursor: pointer;
    }

    .right-form .factor_details {
        opacity: 0;
        transition: opacity 0.5s;
    }
</style>

<div class="grid grid-cols-2 px-5">
    <form id="vorodkala" method="post" action="php/vorodkala-save.php" autocomplete="off">
        <div class="left-form">
            <?php include("php/codeid.php") ?>
        </div>
        <div class="right">
            <input type="hidden" name="brand-box" id="brand-box">
            <table style="width: 100% !important;">
                <tbody>
                    <tr>
                        <td>
                            <p for="brand">اصالت</p>
                        </td>
                        <td>
                            <select name="brand" id="esalat">
                                <?php include("php/brand-form.php") ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>فروشنده</p>
                        </td>
                        <td>
                            <select name="seller" id="seller">
                                <option selected="true" disabled="disabled">انتخاب فروشنده</option>
                                <?php
                                foreach (getSellers() as $seller) : ?>
                                    <option value='<?= $seller["id"] ?>'><?= $seller["name"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            تحویل دهنده
                        </td>
                        <td>
                            <select name="deliverer" id="deliverer">
                                <?php include("php/deliverer-form.php") ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>تعداد</p>
                        </td>
                        <td>
                            <input required min="0" type="number" name="qty" id="qty">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>
                                قفسه
                            </p>
                        </td>
                        <td>
                            <input onkeydown="upperCaseF(this)" type="text" name="pos2" id="pos2">
                        </td>
                    </tr>
                    <tr>
                        <td>راهرو</td>
                        <td>
                            <input onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1">
                        </td>
                    </tr>
                    <tr>
                        <td>انبار</td>
                        <td>
                            <select name="stock" id="stock">
                                <?php include("php/stock-form.php") ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;">

                            توضیحات
                        </td>
                        <td>
                            <textarea name="des" id="des"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>آیا فاکتور دارد ؟</p>
                        </td>
                        <td>
                            <ul>
                                <br>
                                <li style="margin-bottom: 10px;">
                                    <label for="invoice">
                                        <input type="radio" name="invoice" data-name="yes" id="invoice" value="1" checked>
                                        بله
                                    </label>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <label for="invoiceNO">
                                        <input type="radio" name="invoice" data-name="no" id="invoiceNO" value="0">
                                        خیر
                                    </label>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr class="factor_details">
                        <td>
                            <p>شماره فاکتور</p>
                        </td>
                        <td>
                            <input type="number" name="invoice_number" id="invoice_number">
                        </td>
                    </tr>
                    <tr class="factor_details">
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
                            <p>آیا وارد انبار شده ؟</p>
                        </td>
                        <td>
                            <ul>
                                <li style="margin-bottom: 10px;">
                                    <label for="anbarenter">
                                        <input type="radio" name="anbarenter" id="anbarenter" value="0">
                                        خیر
                                    </label>
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <label for="anbarenterNo">
                                        <input type="radio" name="anbarenter" id="anbarenterNo" value="1" checked>
                                        بله
                                    </label>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>



        </div>

        <div class="bottom-bar">
            <input type="submit" value="ذخیره" id="">
            <div class="error">
            </div>
        </div>

    </form>
    <div></div>
</div>

<script>
    let factor_info = {
        seller: '',
        date: '',
        bill_number: '',
        is_entered: false
    }

    let factor_items = [];
</script>
</div>
<?php include("./views/Layout/footer.php") ?>