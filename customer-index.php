<?php include("./views/Layout/header.php") ?>

<div id="Customer-Page">
    <div class="right-side">

        <form id="customersave" method="post" action="php/customer-save.php" autocomplete="off">


            <div class="left-form">
                <label for="name">نام</label>
                <input required type="text" name="name" id="name">

                <label for="lastname">نام خانوادگی</label>
                <input type="text" name="lastname" id="lastname">

                <label for="mobile">موبایل</label>
                <input type="text" name="mobile" id="mobile">


            </div>

            <div class="right-form">

                <label for="phone">تلفن</label>
                <input type="text" name="phone" id="phone">

                <label for="address">آدرس</label>
                <input type="text" name="address" id="address">

                <label for="car">خودرو</label>
                <input type="text" name="car" id="car">


            </div>



            <div class="bottom-bar">
                <input type="submit" value="ذخیره مشتری" id="sabt">
                <div class="error"></div>
            </div>

        </form>

    </div>

    <div class="left-side">


        <table class="report-table customer-list">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>موبایل</th>
                    <th>تلفن</th>
                    <th>آدرس</th>
                    <th>خودرو</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php include("php/customer-list.php") ?>
            </tbody>
        </table>

    </div>





</div>


<?php include("footer.php") ?>