<?php  require_once("header.php") ?>


<div>
    <div>

        <div class="filter">
            <?php include("php/filter.php") ?>


        </div>




        <table class="report-table">
            <tr>
                <th>#</th>
                <th>شماره فنی</th>
                <th>برند</th>
                <th>توضیحات</th>
                <th>تعداد</th>
                <th>راهرو</th>
                <th>قفسه</th>
                <th>فروشنده</th>
                <th>زمان ورود</th>
                <th>تاریخ ورود</th>

                <th>تحویل دهنده</th>
                <th>فاکتور</th>
                <th>شماره فاکتور</th>
                <th>تاریخ فاکتور</th>
                <th>ورود به انبار</th>
                <th>انبار</th>
                <th>کاربر</th>
                <?php if(userRoll() < 3){ ?>
                <th>قیمت</th>

                <?php } ?>

                <th>عملیات</th>
            </tr>
            <?php include("php/vorodkala-report-geter-anbargard.php") ?>
        </table>
    </div>



    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>
                <iframe width="100%" height="370px" src=""></iframe>
            </p>
        </div>
    </div>




</div>


<?php include("footer.php") ?>
