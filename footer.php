<script src="js/mojodikala.js?v=<?php echo (rand()) ?>"></script>
<script src="js/cutomer-save.js?v=<?php echo (rand()) ?>"></script>
<script src="js/invoice.js?v=<?php echo (rand()) ?>"></script>

<script src="js/vorod-filter.js?v=<?php echo (rand()) ?>"></script>
<script src="js/shomaresh-save.js?v=<?php echo (rand()) ?>"></script>
<script src="js/codeid.js?v=<?php echo (rand()) ?>"></script>
<script src="js/vorodkala-save.js?v=<?php echo (rand()) ?>"></script>
<script src="js/khorojkala-save.js?v=<?php echo (rand()) ?>"></script>
<script src="js/form.js?v=<?php echo (rand()) ?>"></script>
<script src="js/newcode.js?v=<?php echo (rand()) ?>"></script>
<script src="js/qtybank.js?v=<?php echo (rand()) ?>"></script>
<script src="js/price.js?v=<?php echo (rand()) ?>"></script>
<script src="js/modal.js?v=<?php echo (rand()) ?>"></script>
<script src="js/vorodkala.js?v=<?php echo (rand()) ?>"></script>
<script src="js/khorojkala.js?v=<?php echo (rand()) ?>"></script>
<script src="js/all.js"></script>
<script src="js/excell.js"></script>
<script src="js/copy.js"></script>

<script type="text/javascript" src="js/persianDatepicker.min.js"></script>
<style>
    #redirect {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
    }

    .alertMessage {
        background-color: white;
        width: 600px;
        height: 300px;
        border-radius: 10px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    #redirectMessage {
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        padding-block: 50px;
    }

    .btn {
        padding: 10px 10px;
        width: 80px;
        border-radius: 10px;
        color: white;
        border: none;
    }

    .btn-confirm {
        background-color: seagreen;
    }

    .btn-decline {
        background-color: red;
    }
</style>
<div id="redirect">
    <div class="alertMessage">
        <p id='redirectMessage'></p>
        <div>
            <button onclick="confirm()" class="btn btn-confirm">تایید</button>
            <button onclick="decline()" class="btn btn-decline">انصراف</button>
        </div>
    </div>
</div>
<script>
    let redirect_to = null;
    const redirect = document.getElementById('redirect');

    function redirectTo(url, namespace) {
        redirect_to = url;
        redirect.style.display = 'flex';
        document.getElementById('redirectMessage').innerHTML = ' حاجی ناموسأ میخوای بری صفحه' + " " + namespace + '؟';
    }

    function confirm() {
        window.location.href = redirect_to;
    }

    function decline() {
        redirect.style.display = 'none';
    }
</script>


</body>

</html>