<?php
require_once "./app/controller/LoginController.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به سیستم</title>
    <link rel="icon" href="./public/img/logo.jpg" sizes="32x32">
    <link href="./public/css/assets/bootstrap.min.css" rel="stylesheet">
    <script src="../callcenter/report/public/js/index.js"></script>
    <link href="./public/css/material_icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/login.css?v=<?= rand() ?>">
</head>

<body style="direction: rtl;">
    <div style="height: 100vh !important;" class="container">
        <div class="row h-100 d-flex justify-content-center align-content-center">
            <form class="col-md-11" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="AppForm shadow-lg">
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-center align-content-center">
                            <div class="AppFormLeft">
                                <h1> ورود به سیستم</h1>
                                <p>برای ورود به سیستم اطلاعات کاربری خود را به دقت وارد کنید.</p>
                                <div class="form-group position-relative mb-4 mt-4">
                                    <label for="label-contrlller pb-2">اسم کاربری</label>
                                    <input type="text" name="username" class="form-control border-top-0" id="username" placeholder="اسم کاربری خود را وارد کنید">
                                    <p class="text-danger small"><?= $username_err ?></p>
                                </div>
                                <div class="form-group position-relative mb-4">
                                    <label for="label-contrlller pb-2">رمز عبور</label>
                                    <div class="position-relative">
                                        <span class="material-icons" onclick="togglePass(this)" style="cursor:pointer; position: absolute; left:5px; top: 25%; display:inline !important">remove_red_eye</span>
                                        <input type="password" name="password" class="form-control " id="password" placeholder="رمز عبور خود را وارد کنید">
                                        <p class="text-danger small"><?= $password_err ?></p>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-block shadow border-0 py-2 text-uppercase ">
                                    ورود به سیستم
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-content-center text-center p-5 text-white">
                                <h2 class="position-relative px-4 pb-3 mb-4">خوش آمدید</h2>
                                <p>مجموعه ی یدک شاپ از سال ١٣٩٣ قطعات و لوازم یدکی کیا را به طور مستقیم از کشور کره جنوبی وارد ایران میکند،یدک شاپ علاوه بر لوازم اصلی خودروهای کیا که با نام کیا جنیون پارت و موبیس شناخته می شوند برای بالا بردن قدرت خرید مشتریان خود بعضی از قطعات کیا را با سایر برند های معتبر کره ای وارد کرده و حق انتخاب وسیع تری برای شما مصرف کنندگان عزیز ایجاد میکند.‌</p>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script>
        function togglePass(element) {
            const target = element.nextElementSibling;
            const inputType = target.type;

            if (inputType === 'password') {
                target.type = 'test';
                return;
            }

            target.type = 'password';
        }
    </script>
</body>

</html>