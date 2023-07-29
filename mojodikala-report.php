<?php include("header.php") ?>


<div>









    <div>

        <div class="filter">
            <?php include("php/filter.php") ?>


        </div>



        <input id="MojodiSearch" type="text" placeholder="Search..">

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
                    <?php if(userRoll() < 3){ ?>
                    <th>قیمت</th>

                    <?php } ?>










                </tr>
            </thead>
            <tbody class="mojodi-table">
                <?php include("php/mojodikala-report-geter.php") ?>
            </tbody>

        </table>




    </div>







</div>


<?php include("footer.php") ?>
