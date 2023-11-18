<?php require_once("./views/Layout/header.php") ?>
<style>
    .custom-header {
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        padding-block: 40px;
        margin-inline: 20px;
        background-color: #bbbbbb;
        border-radius: 10px;
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
            </div>
            <div class="bottom-bar">
                <input type="submit" value="ذخیره" id="sabt">
                <div class="error"></div>
            </div>
        </div>
    </form>
</div>

<?php require_once("./views/Layout/footer.php") ?>