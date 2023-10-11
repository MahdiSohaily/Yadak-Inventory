<?php include("header.php") ?>


<div id="QTY-Page">
    <div>
        <form id="khorojkala" method="post" action="php/khorojkala-save.php" autocomplete="off">
            <div class="left-form">
                <?php include("php/qtybank.php") ?>
            </div>
            <div class="right-form">
                <label class="half-label" for="invoice_number">شماره فاکتور</label>
                <input type="number" name="invoice_number" id="invoice_number" onchange="checkBillNumber(this.value)">

                <label for="customer">خریدار</label>
                <input type="text" name="customer" id="customer">
                <input class="half-input" type="hidden" name="stock_hjdgshj" id="stock" value=''>

                <label class="half-label" for="getter">تحویل گیرنده</label>
                <select name="getter" id="getter">
                    <?php include("php/getter-form.php") ?>
                </select>
                <p style="Clear:both"></p>

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
                    <div class="error">
                    </div>
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
</script>

<?php include("footer.php") ?>