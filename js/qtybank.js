function showQty(str) {
  str = str.replace(/\s/g, "");
  str = str.replace(/-/g, "");
  str = str.replace(/_/g, "");

  const resultBox = document.getElementById("txtHint-khoroj");

  if (str.length < 7) {
    resultBox.innerHTML = "...";
  } else {
    document.getElementById("txtHint-khoroj").innerHTML = "";
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

    if (qty <= prev_qty) {
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
        '<div class="item" style="padding-block:10px"><input type="hidden" name="prev_qty" value="' +
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
    }
  });
});
