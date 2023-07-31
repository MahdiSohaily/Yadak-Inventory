<?php include("header.php") ?>


<div id="Enter-Page">


    <div>
        <form id="vorodkala" method="post" action="php/vorodkala-save.php" autocomplete="off">
            <div class="left-form">
                <?php include("php/codeid.php") ?>

            </div>
            <div class="right-form">


                <label for="brand">اصالت</label>
                <select name="brand" id="esalat">
                    <?php include("php/brand-form.php") ?>

                </select>
                <input type="hidden" name="brand-box" id="brand-box">



                <label for="seller">فروشنده</label>
                <select name="seller" id="seller">
                    <?php include("php/seller-form.php");
                    foreach ($data as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }

                    ?>

                </select>

                <label for="deliverer">تحویل دهنده</label>
                <select name="deliverer" id="deliverer">
                    <?php include("php/deliverer-form.php") ?>

                </select>



                <label class="small-label" for="qty">تعداد</label>
                <input required min="0" class="small-input" type="number" name="qty" id="qty">



                <label class="small-label" for="pos2">قفسه</label>
                <input onkeydown="upperCaseF(this)" class="small-input" type="text" name="pos2" id="pos2">


                <label class="small-label" for="pos1">راهرو</label>
                <input onkeydown="upperCaseF(this)" class="small-input" type="text" name="pos1" id="pos1">

                <label for="stock">انبار</label>
                <select name="stock" id="stock">
                    <?php include("php/stock-form.php") ?>
                </select>



                <label for="des">توضیحات</label>
                <textarea name="des" id="des"></textarea>







                <fieldset>
                    <legend>آیا فاکتور دارد ؟</legend>
                    <label for="invoice">خیر</label>
                    <input type="radio" name="invoice" id="invoice" value="0">
                    <label for="nvoice">بله</label>
                    <input type="radio" name="invoice" id="invoice" value="1" checked>
                </fieldset>


                <label for="invoice_number">شماره فاکتور</label>
                <input type="number" name="invoice_number" id="invoice_number">

                <label for="invoice_time">زمان فاکتور</label>
                <input value="<?php echo (jdate("Y/m/d", time(), "", "Asia/Tehran", "en")) ?>" type="text" name="invoice_time" id="invoice_time">
                <span id="span_invoice_time"></span>



                <fieldset>
                    <legend>آیا وارد انبار شده ؟</legend>

                    <label for="anbarenter">خیر</label>
                    <input type="radio" name="anbarenter" id="anbarenter" value="0">

                    <label for="anbarenter">بله</label>
                    <input type="radio" name="anbarenter" id="anbarenter" value="1" checked>

                </fieldset>


                <div class="bottom-bar">
                    <input type="submit" value="ذخیره" id="sabt">
                    <div class="error">
                    </div>
                </div>


            </div>
        </form>







    </div>







</div>


<?php include("footer.php") ?>