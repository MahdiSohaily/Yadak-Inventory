<?php require_once("./views/Layout/header.php") ?>
<div>
    <div class="price-page">

        <form>
            <input onkeyup="convertToEnglish(this)" class="input-value" type="text" placeholder="کد فنی قطعه را وارد کنید ..." onkeyup="showPrice(this.value),showAnbar(this.value)">
            <div class="price-table">
                <table>
                    <tr>
                        <th class="first-th">شماره فنی</th>
                        <th>دلار پایه</th>
                        <th>+10%</th>
                        <th class="border">+20%</th>

                        <th class="red">27</th>
                        <th>28</th>
                        <th>29</th>
                        <th>30</th>
                        <th class="red">31</th>
                        <th>+10%</th>
                        <th class="red2">+20%</th>
                        <th>+30%</th>

                        <th class="Action"></th>
                        <th></th>

                    </tr>

                </table>
                <table id="price-txtHint">

                </table>

                <table id="anbarHint-head">
                    <tr>

                        <th>شماره فنی</th>
                        <th>برند</th>
                        <th>تعداد موجود</th>
                        <th>فروشنده</th>
                        <th>توضیحات</th>
                        <th>انبار</th>

                        <th>راهرو</th>

                        <th>قفسه</th>
                    </tr>

                </table>

                <table id="anbarHint">

                </table>
            </div>
        </form>
    </div>
</div>
<?php require_once("./views/Layout/footer.php") ?>