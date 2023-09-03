<?php include("header.php");
$dateTime = jdate('Y-m-d') ?>
<div class="page">
    <div class="countdown-col col">
        <div class="time middle">

            <span>
                <div id="days"><?php echo explode('-', $dateTime)[0]; ?> /</div><?php echo jdate('V') ?>
            </span>

            <span>
                <div id="hours"><?php echo explode('-', $dateTime)[1]; ?> /</div><?php echo jdate('F') ?>
            </span>
            <span>
                <div id="minutes"><?php echo explode('-', $dateTime)[2]; ?></div> <?php echo jdate('J') ?>
            </span>
        </div>
    </div>
    <div class="newsletter-col col">
        <div class="newslatter middle">
            <div class="card">
                <h1>به نرم افزار تحت وب یدک شاپ خوش آمدید</h1>

                <div class="py-5">
                    <strong>رمز قیمت موبیز</strong>
                    <hr>
                    <code>RaHiMi1408NR1408###3</code>
                    <br>
                    <code>RaHiMi1408@400@1408###7</code>
                </div>

                <div class="py-5">
                    <strong>فعالیت کاربران</strong>
                    <hr>
                    <iframe src="login.txt"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    body,
    html {
        margin: 0 !important;
        padding: 0 !important;
    }

    h1 {
        font-size: 18px !important;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .py-5 {
        padding-block: 10px;
    }

    .page {
        background: #f1f1f1;
        display: flex;
        flex-wrap: wrap;
        direction: ltr;
    }

    .col {
        flex: 1;
        height: 100vh;
    }

    .countdown-col {
        background: url('./img/pxfuel.jpg') no-repeat top left;
        background-size: cover;
    }


    .middle {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .time {
        color: #fff;
        flex-direction: row;
    }


    .time span {
        padding: 0 14px;
        font-size: 12px;
    }

    .time span div {
        font-size: 40px;
    }

    .card {
        width: 600px !important;
        text-align: center;
    }

    @media screen and (max-width: 900px) {
        .col {
            flex: 100%;
        }
    }
</style>

<?php include("footer.php") ?>