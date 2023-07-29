function selectCustomer(str) {

    str = str.replace(/\s/g, "");
    str = str.replace(/-/g, "");
    str = str.replace(/_/g, "");

    if (str == "") {
        document.getElementById("customer-inv-hint").innerHTML = "";
        return;
    } else if (str.length < 3) {} else {
        document.getElementById("customer-inv-hint").innerHTML = "";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("customer-inv-hint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "php/customer-geter.php?q=" + str, true);
        xmlhttp.send();
    }
}



function selectInvCode(str) {

    str = str.replace(/\s/g, "");
    str = str.replace(/-/g, "");
    str = str.replace(/_/g, "");

    if (str == "") {
        document.getElementById("code-inv-hint").innerHTML = "";
        return;
    } else if (str.length < 7) {} else {
        document.getElementById("code-inv-hint").innerHTML = "";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("code-inv-hint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "php/code-inv-geter.php?q=" + str, true);
        xmlhttp.send();
    }
}


function selectInvQty(str) {

    str = str.replace(/\s/g, "");
    str = str.replace(/-/g, "");
    str = str.replace(/_/g, "");

    if (str == "") {
        document.getElementById("qty-inv-hint").innerHTML = "";
        return;
    } else if (str.length < 7) {} else {
        document.getElementById("qty-inv-hint").innerHTML = "";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("qty-inv-hint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "php/qty-inv-geter.php?q=" + str, true);
        xmlhttp.send();
    }
}
