﻿<?php require_once("./views/Layout/header.php") ?>
<div>
    <div>
        <div class="search_container" style="display: flex; justify-content: space-between;">
            <div>
                <span for="MojodiSearch">جستجو</span>
                <input id="MojodiSearch" onkeyup="convertToEnglish(this); searchGoods(this.value)" type="text" placeholder="جستجو به اساس کدفنی">
            </div>
            <a href="./existing_excel.php" class="excel">اکسل</a>
        </div>
        <table style="width: 98%;" class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>شماره فنی</th>
                    <th>برند</th>
                    <th>تعداد موجود</th>
                    <th>فروشنده</th>
                    <th>راهرو</th>
                    <th>قفسه</th>
                    <th>توضیحات</th>
                    <th>انبار</th>
                </tr>
            </thead>
            <tbody id="mojodiResult" class="mojodi-table">
                <script src="./public/js/mojodi_kala.js?v=<?= rand() ?>"></script>
                <?php require_once './php/mojodikala-report-geter.php'; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once("./views/Layout/footer.php") ?>