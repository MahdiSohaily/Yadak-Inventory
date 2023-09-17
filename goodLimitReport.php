<?php include("header.php") ?>
<div>
    <div>
        <div class="search_container">
            <span for="MojodiSearch">جستجو</span>
            <input id="MojodiSearch" onkeyup="searchGoods(this.value)" type="text" placeholder="جستجو به اساس کدفنی">
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>شماره فنی</th>
                    <th>تعداد اصلی مورد نیاز</th>
                    <th>تعداد کپی مورد نیاز</th>
                    <th>اصلی موجود</th>
                    <th>کپی موجود</th>
                </tr>
            </thead>
            <tbody id="mojodiResult" class="mojodi-table">
                <script src="./public/js/mojodi_kala.js?v=<?= rand() ?>"></script>
                <?php include_once './php/limit-report-getter.php'; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include("footer.php") ?>