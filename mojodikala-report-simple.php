<?php include("./views/Layout/header.php") ?>

<div>
    <div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>شماره فنی</th>
                    <th>برند</th>
                    <th>تعداد موجود</th>
                    <th>فروشنده</th>
                    <th>توضیحات</th>
                </tr>
            </thead>
            <tbody class="mojodi-table">
                <?php include("php/mojodikala-report-simple-geter.php") ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("./views/Layout/footer.php") ?>