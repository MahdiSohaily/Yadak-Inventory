<?php
// Initialize the session

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Include config file
require_once "php/db.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: index.php?msg=$username");



                            date_default_timezone_set('Iran');

                            $myfile = fopen("login.txt", "a") or die("Unable to open file!");
                            $txt = $username . ' ' . date("Y-m-d h:i:sa") . " Logged in \n";
                            fwrite($myfile, $txt);
                            fclose($myfile);
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($con);
}
?>

<?php
if (!empty($login_err)) {
    echo '<div class="alert alert-danger">' . $login_err . '</div>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <title>ورود به سیستم</title>
    <link rel="icon" href="https://yadak.shop/wp-content/uploads/2017/04/cropped-YadakShop-512-1-100x100.png" sizes="32x32">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @import url('https://v1.fontapi.ir/css/Vazir');
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style>
        * {
            font-family: Vazir, sans-serif;
        }

        @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap');

        * {
            padding: 0;
            margin: 0;
            outline: none;
        }

        body {
            font-family: 'Roboto', sans-serif !important;
            height: 100vh;
            color: #3a3e42 !important;
        }

        .AppForm {
            border-radius: 10px;
            overflow: hidden;
        }

        .AppFormLeft {
            padding: 2rem;
        }

        .AppForm .AppFormLeft h1 {
            font-size: 35px;
        }

        .AppForm .AppFormLeft input {
            margin-block: 5px;
            border: 1px solid #8D334C !important;
            border-radius: 5px !important;
        }

        .AppForm .AppFormLeft input::placeholder {
            font-size: 15px;
        }

        .AppForm .AppFormLeft i {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .AppForm .AppFormLeft a {
            color: #3a3e42;
        }

        .AppForm .AppFormLeft button {
            background: linear-gradient(45deg, #8D334C, #CF6964);
            border-radius: 30px;
        }

        .AppForm .AppFormLeft p span {
            color: #007bff;
        }

        .AppForm .AppFormRight {
            background-image: url('https://wallpapers.com/images/hd/detailed-hyundai-front-view-0ourh5sb3js38dlw.webp');
            height: 450px;
            background-size: cover;
            background-position: center;
        }

        .AppForm .AppFormRight:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #8D334C, #CF6964);
            opacity: 0.5;
        }

        .AppForm .AppFormRight h2 {
            z-index: 1;
        }

        .AppForm .AppFormRight h2::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #fff;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .AppForm .AppFormRight p {
            z-index: 1;
        }
    </style>
</head>

<body style="direction: rtl;">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <form class="col-md-11" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="AppForm shadow-lg">
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <div class="AppFormLeft">
                                <h1> ورود به سیستم</h1>
                                <p>برای ورود به سیستم اطلاعات کاربری خود را به دقت وارد کنید.</p>
                                <div class="form-group position-relative mb-4 mt-4">
                                    <label for="label-contrlller pb-2">اسم کاربری</label>
                                    <input type="text" name="username" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="username" placeholder="اسم کاربری خود را وارد کنید">
                                    <i class="fa fa-user-o"></i>
                                </div>
                                <div class="form-group position-relative mb-4">
                                    <label for="label-contrlller pb-2">رمز عبور</label>
                                    <input type="password" name="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="password" placeholder="رمز عبور خود را وارد کنید">
                                    <i class="fa fa-key"></i>

                                </div>

                                <button class="btn btn-success btn-block shadow border-0 py-2 text-uppercase ">
                                    ورود به سیستم
                                </button>

                                <p class="text-center mt-5 hidden" style="visibility: hidden;">
                                    Don't have an account?
                                    <span>
                                        Create your account
                                    </span>

                                </p>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">
                                <h2 class="position-relative px-4 pb-3 mb-4">خوش آمدید</h2>
                                <p>مجموعه ی یدک شاپ از سال ١٣٩٣ قطعات و لوازم یدکی کیا را به طور مستقیم از کشور کره جنوبی وارد ایران میکند،یدک شاپ علاوه بر لوازم اصلی خودروهای کیا که با نام کیا جنیون پارت و موبیس شناخته می شوند برای بالا بردن قدرت خرید مشتریان خود بعضی از قطعات کیا را با سایر برند های معتبر کره ای وارد کرده و حق انتخاب وسیع تری برای شما مصرف کنندگان عزیز ایجاد میکند.‌</p>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</body>

</html>