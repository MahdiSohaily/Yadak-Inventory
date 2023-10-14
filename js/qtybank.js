const resultBox = document.getElementById("txtHint-khoroj");

function showQty(str) {
  str = str.replace(/\s/g, "");
  str = str.replace(/-/g, "");
  str = str.replace(/_/g, "");

  if (str.length > 6) {
    resultBox.innerHTML = "<img style='width:30px' src='./img/loading.png' />";

    const xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint-khoroj").innerHTML = this.responseText;
      }
    };
    xmlHttp.open("GET", "php/qtybank-geter.php?q=" + str, true);
    xmlHttp.send();
  }
}

let notAllowed = [];

$(document).ready(function () {
  $("#txtHint-khoroj").on("click", "div", function () {
    $("#txtHint-khoroj div").removeClass("clickedcode");
    $(this).addClass("clickedcode");
    $("#codeid").val($(this).attr("codeid"));
  });

  $(".add-to-basket").on("click", ".remove-basket", function () {
    $(this).parent().remove();
  });

  $("#txtHint-khoroj").on("click", ".add-to-khoroj", function () {
    $(this).css("pointer-events", "none");
    const prev_qty = $(this).prev().attr("data-amount");
    const qty = Math.abs($(this).prev().val());

    if (qty !== 0 && qty <= prev_qty) {
      document.getElementById("sabt").disabled = false;

      const code = $(this).prev().attr("code");
      const brand = $(this).prev().attr("brand");
      const seller = $(this).prev().attr("seller");
      const qtyid = $(this).prev().attr("qtyid");
      const stock = $(this).prev().attr("stock");

      notAllowed.push(stock);

      var xqty = $(this).parent().parent().find(".qtybank-first").text();

      var xqty = xqty - qty;

      $(this).parent().parent().find(".qtybank-first").text(xqty);

      $(".add-to-basket").append(
        '<div class="item"><input type="hidden" name="prev_qty" value="' +
          prev_qty +
          '" /> <div>' +
          code +
          "</div> <div>" +
          seller +
          "</div> <div>" +
          brand +
          '</div> <input type="hidden" name="qtyid[]" value="' +
          qtyid +
          '"><div class="remove-basket"><input type="number" name="qty[]" value="' +
          qty +
          '" readonly><a>حذف <i class="fas fa-times"></i></a></div> </div>'
      );
    } else {
      alert("مقدار انتخاب شده درست نیست");
      document.getElementById("sabt").disabled = true;
    }
  });
});
