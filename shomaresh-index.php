<?php require_once("./views/Layout/header.php") ?>
<div>
    <div>
        <form id="shomaresh" method="post" action="php/shomaresh-save.php" autocomplete="off">
            <div class="left-form">
                <?php require_once("php/codeid.php") ?>
            </div>
            <div class="right-form">
                <label for="brand">اصالت</label>
                <select name="brand" id="esalat">
                    <?php require_once("php/brand-form.php") ?>
                </select>
                <input type="hidden" name="brand-box" id="brand-box">
                <label class="small-label" for="qty">تعداد</label>
                <input required min="0" class="small-input" type="number" name="qty" id="qty">

                <label class="small-label" for="pos2">قفسه</label>
                <input onkeydown="upperCaseF(this)" class="small-input" type="text" name="pos2" id="pos2">

                <label class="small-label" for="pos1">راهرو</label>
                <input onkeydown="upperCaseF(this)" class="small-input" type="text" name="pos1" id="pos1">



                <label for="stock">انبار</label>
                <select name="stock" id="stock">
                    <?php require_once("php/stock-form.php") ?>
                </select>


                <label for="des">توضیحات</label>
                <textarea name="des" id="des"></textarea>

                <div class="bottom-bar">
                    <input type="submit" value="ذخیره" id="sabt">
                    <div class="error"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require_once("./views/Layout/footer.php") ?>