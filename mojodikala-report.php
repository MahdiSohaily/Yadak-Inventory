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
            </tbody>
        </table>
    </div>
</div>
<script>
    setTimeout(() => {
        getGoods();
    }, 100);
</script>
<?php include("footer.php") ?>