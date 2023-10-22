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
let totalCount = document.getElementById("totalCount");
totalCount.value = 0;

$(document).ready(function () {
  $("#txtHint-khoroj").on("click", "div", function () {
    $("#txtHint-khoroj div").removeClass("clickedcode");
    $(this).addClass("clickedcode");
    $("#codeid").val($(this).attr("codeid"));
  });

  $("#result_box").on("click", ".remove-basket", function () {
    const amount = $(this).attr("data-remove");
    let totalCount = document.getElementById("totalCount");
    totalCount.value = Number(totalCount.value) - Number(amount);

    $(this).parent().parent().remove();
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

      let totalCount = document.getElementById("totalCount");
      totalCount.value = Number(totalCount.value) + Number(qty);

      $(this).parent().parent().find(".qtybank-first").text(xqty);
      $("#result_box").append(
        `
        <tr>
          <td>1</td>
          <td>
            <div class="good_amount_details">
              <input type="hidden" name="prev_qty" value="${prev_qty}" />
              <p>${code}</p>
              <p>${seller}</p>
              <p>${brand}</p>
              <input type="hidden" name="qtyid[]" value="${qtyid}">
              <input type="number" name="qty[]" value="${qty}" readonly id="good_amount">
            </div>
          </td>
          <td>
            <a class="remove-basket" data-remove="${qty}"><i class="fas fa-trash"></i></a>
          </td>
        </tr>
        `
      );
    } else {
      alert("مقدار انتخاب شده درست نیست");
      document.getElementById("sabt").disabled = true;
    }
  });
});

$(document).ready(function () {
  $("#sabt").click(function () {
    let totalCount = document.getElementById("totalCount");
    totalCount.value = 0;
    document.getElementById("result_box").innerHTML = "";
  });
});
