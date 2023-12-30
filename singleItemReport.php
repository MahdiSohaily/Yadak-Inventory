<?php
require_once("./views/Layout/header.php");
require_once("php/seller-form.php");

if (isset($_GET['interval'])) {
    $interval = $_GET['interval'];
}
?>
<style>
    section {
        padding-inline: 15px;
    }

    .flex {
        display: flex;
    }

    .justify-center {
        justify-content: center;
    }

    .form-controller {
        padding: 10px;
        width: 300px;
        font-size: 12px;
        border-radius: 5px;
        border: 1px solid lightgray;
    }

    .form-controller::placeholder {
        font-size: 12px;
    }
</style>
<section class="flex justify-center">
    <input class="form-controller" type="text" name="code" id="code" onkeyup="convertToEnglish(this); searchCode(this.value)" placeholder="کد مد نظر خود را بصورت کامل وارد کنید">
</section>

<section id="price">
    <h2>قیمت قطعه</h2>
</section>
<section id="import">
    <h2>گزارش ورود</h2>
</section>
<section id="export">
    <h2>گزارش خروج</h2>
</section>