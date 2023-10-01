﻿<?php
// Initialize the session
session_start();

// Check if the user is already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Check if the session has expired (current time > expiration time)
    if (isset($_SESSION["expiration_time"]) && time() > $_SESSION["expiration_time"]) {
        // Session has expired, destroy it and log the user out
        session_unset();
        session_destroy();
        header("location: login.php"); // Redirect to the login page
        exit;
    }
} else {
    // User is not logged in, redirect them to the login page
    header("location: login.php");
    exit;
}

function sendAjaxRequest($id, $username)
{
    // AJAX request code here
    echo "<div style='z-index:10000;height: 100vh !important; position:fixed; inset:0;
    flex-direction:column;
    display:flex; justify-content:center; align-items:center;background-color:white'>
    <p>لطفا صبور باشید</p>
    <img src='./img/loading.gif' alt='' srcset=''>
    </div>";
    echo '<script src="./js/assets/axios.js"></script>
        <script>
            var params = new URLSearchParams();
            params.append("sendMessage", "local");
            params.append("id", ' . $id . ');
            params.append("username", "' . $username . '");
            params.append("time", "' . date("Y-m-d h:i:sa") . '");
            params.append("host", "' . $_SERVER['HTTP_HOST'] . '");
            params.append("ip", "' . $_SERVER['REMOTE_ADDR'] . '");
            axios.post("http://telegram.om-dienstleistungen.de/", params)
                .then(function(response) {
                    console.log(response.data);
                    window.location.href = "index.php?msg=' . $username . '";
                })
                .catch(function(error) {
                    console.log(error);
                });
        </script>';
}
function sendLoginAttemptAlert()
{
    echo '<script src="./js/assets/axios.js"></script>
    <script>
        var params = new URLSearchParams();
        params.append("sendMessage", "attempt");
        params.append("host", "' . $_SERVER['HTTP_HOST'] . '");
        params.append("ip", "' . $_SERVER['REMOTE_ADDR'] . '");
        params.append("time", "' . date("Y-m-d h:i:sa") . '");
        console.log(params.toString());
        axios.post("http://telegram.om-dienstleistungen.de/", params)
            .then(function(response) {
                console.log(response);
            })
            .catch(function(error) {
                console.log(error);
            });
    </script>';
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
        $username_err = "لطفا نام کاربری خود را وارد کنید";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "لطفا رمز عبور خود را وارد کنید.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password, isLogin FROM users WHERE username = ?";

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
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $isLogin);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            date_default_timezone_set('Asia/Tehran');
                            // Calculate the expiration timestamp for 8 AM the next day
                            $expiration_time = strtotime("tomorrow 8:00 AM");

                            // Store the expiration timestamp in the session
                            $_SESSION["expiration_time"] = $expiration_time;

                            // Password is correct, so start a new session
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;


                            // Call a function to send the AJAX request
                            sendAjaxRequest($id, $username);

                            // Redirect user to welcome page
                            // header("location: index.php?msg=$username");
                            $myfile = fopen("login.txt", "a") or die("Unable to open file!");
                            $txt = $username . ' ' . date("Y-m-d h:i:sa") . " Logged in \n";
                            fwrite($myfile, $txt);
                            fclose($myfile);
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "رمز عبور یا اسم کاربری اشتباه است.";
                            sendLoginAttemptAlert();
                        }
                        // Function to send the AJAX request
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "رمز عبور یا اسم کاربری اشتباه است.";
                    sendLoginAttemptAlert();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به سیستم</title>
    <link rel="icon" href="./public/img/logo.jpg" sizes="32x32">
    <link href="./public/css/assets/bootstrap.min.css" rel="stylesheet">
    <script src="./public/js/assets/assets/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./public/css/login.css">
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
                                    <input type="text" name="username" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="username" placeholder="اسم کاربری خود را وارد کنید">
                                </div>
                                <div class="form-group position-relative mb-4">
                                    <label for="label-contrlller pb-2">رمز عبور</label>
                                    <input type="password" name="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" id="password" placeholder="رمز عبور خود را وارد کنید">
                                    <i class="fa fa-eye"></i>
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
</body>

</html>