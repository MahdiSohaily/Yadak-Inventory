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
            <h1>به نرم افزار تحت وب یدک شاپ خوش آمدید</h2>

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
                    <iframe id="frame" src="login.txt"></iframe>
                </div>
        </div>
    </div>
</div>
<style>
    body {
        background-color: red !important;
    }

    * {
        font-family: 'montserrat', sans-serif;
    }

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
    .py-5{
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
        position: relative;
    }

    .countdown-col {
        background: url(https://images.pexels.com/photos/3457780/pexels-photo-3457780.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1) no-repeat center;
        background-size: cover;
    }

    .time {
        color: #fff;
        text-transform: uppercase;
        width: 90%;
        display: flex;
        justify-content: center;
    }

    .middle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .time span {
        padding: 0 14px;
        font-size: 10px;
    }

    .time span div {
        font-size: 40px;
    }

    .newslatter {
        width: 90%;
    }

    .newslatter h4 {
        font-style: italic;
        font-size: 12px;
    }

    .newslatter input,
    .newslatter button {
        display: block;
        margin: 12px auto;
        width: 100%;
        max-width: 400px;
        box-sizing: border-box;
        padding: 14px 20px;
        border-radius: 30px;
        border: 1px solid #ddd;
        outline: none;
    }

    .newslatter-button {
        background: linear-gradient(125deg, #3498db, #34495e);
        color: #fff;
        cursor: pointer;
        transition: 0.4s;
    }

    .newslatter-button:hover {
        opacity: 0.7;
    }


    @media screen and (max-width: 900px) {
        .col {
            flex: 100%;
        }
    }
</style>

<?php include("footer.php") ?>