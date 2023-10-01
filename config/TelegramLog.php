<?php


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
