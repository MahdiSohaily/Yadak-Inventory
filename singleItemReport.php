<?php
require_once("./views/Layout/header.php");
require_once("php/seller-form.php");

if (isset($_GET['interval'])) {
    $interval = $_GET['interval'];
}
?>
<section class="flex">
<input type="text" name="code" id="code" onkeyup="convertToEnglish(this); searchCode(this.value)">
</section>