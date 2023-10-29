$(document).ready(function () {
  $(".price-page table").on("click", ".Save", function () {
    console.log($(this).attr("msg"));
    $(this).addClass("msg-loading");

    url =
      "https://api.telegram.org/bot1681398960:AAGykdRX-71G0PcK2X_yf3uVQOFWKVNMxoc/sendMessage?chat_id=-522041592&text=" +
      $(this).attr("msg");

    $.get(
      url, // url
      function (data, textStatus, jqXHR) {
        if (textStatus == "success") $(".Save").removeClass("msg-loading");
      }
    );
  });
});

function showPrice(str) {
  str = str.replace(/\s/g, "");
  str = str.replace(/-/g, "");
  str = str.replace(/_/g, "");

  if (str == "") {
    document.getElementById("price-txtHint").innerHTML = "";
    return;
  } else if (str.length < 7) {
  } else {
    document.getElementById("price-txtHint").innerHTML = "";
    $("#price-txtHint").addClass("pricehint-loading");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("price-txtHint").innerHTML = this.responseText;
        $("#price-txtHint").removeClass("pricehint-loading");
      }
    };
    xmlhttp.open("GET", "php/price-get.php?q=" + str, true);
    xmlhttp.send();
  }
}

function showAnbar(str) {
  str = str.replace(/\s/g, "");
  str = str.replace(/-/g, "");
  str = str.replace(/_/g, "");

  if (str == "") {
    document.getElementById("anbarHint").innerHTML = "";
    return;
  } else if (str.length < 5) {
  } else {
    document.getElementById("anbarHint").innerHTML = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("anbarHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "php/anbar.php?q=" + str, true);
    xmlhttp.send();
  }
}
