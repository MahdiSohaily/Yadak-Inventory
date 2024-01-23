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
    <script src="../callcenter/report/public/js/index.js"></script>
    <link href="./public/css/material_icons.css" rel="stylesheet">
    <style>
        body {
            margin-top: 0 !important;
            background: url('./public/img/loginbg.svg') center center no-repeat;
            background-size: cover;
        }

        @font-face {
            font-family: "IranSans";
            src: url("./public/fonts/IRANSans-Light-web.woff") format("woff"),
                url("./public/fonts/IRANSans-Light-web.ttf") format("truetype");
            font-weight: normal;
        }

        @font-face {
            font-family: "IranSans";
            src: url("./public/fonts/IRANSans-Bold-web.woff") format("woff"),
                url("./public/fonts/IRANSans-Bold-web.ttf") format("truetype");
            font-weight: bold;
        }

        * {
            font-family: IranSans, sans-serif;
            direction: rtl !important;
        }
    </style>
</head>

<body class="rtl">
    <section class="login_bg rtl">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto min-h-screen lg:py-0">
            <a href="" class="flex items-center mb-6 text-3xl font-semibold text-white rtl">
                مجموعه یدک شاپ
            </a>
            <div class="w-full bg-white rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0 border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        ورود به حساب کاربری
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900"> نام کاربری</label>
                            <input onkeyup="convertToEnglish(this)" type="text" name="username" id="username" minlength="3" maxlength="20" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder-gray-400  focus:ring-blue-500 focus:border-blue-500" placeholder="user" required="">
                        </div>
                        <div class="relative">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">رمز عبور</label>
                            <i onclick="togglePass(this)" class="material-icons cursor-pointer" style="position: absolute; left:5px; top: 50%">remove_red_eye</i>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500" required="">
                        </div>
                        <div>
                            <?= !empty($login_err) ? "<p class='text-sm text-red-700'>نام کاربری و یا رمز عبور اشتباه است.</p>" : "" ?>
                        </div>
                        <button type="submit" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">ورود به حساب</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
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