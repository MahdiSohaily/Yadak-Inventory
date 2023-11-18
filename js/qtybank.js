const resultBox = document.getElementById("txtHint-khoroj");
const buttonDisable = document.getElementById("sabt");
if (buttonDisable) {
  document.getElementById("sabt").disabled = true;
}

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

function validateAmount(input) {
  var inputs = document.querySelectorAll('input[type="number"][name="qty[]"]');
  var totalCountInput = document.getElementById("totalCount");
  var invoiceNumberInput = document.getElementById("invoice_number");
  var total = 0;
  var invalidAmount = false;
  var error_message = document.getElementById("error_message");

  for (var i = 0; i < inputs.length; i++) {
    var currentInput = inputs[i];
    var prevQtyInput = currentInput.nextElementSibling;
    var inputValue = Number(currentInput.value);
    var prevQtyValue = Number(prevQtyInput.value);

    if (inputValue < 0 || inputValue > prevQtyValue) {
      currentInput.style.border = "2px solid red";
      invalidAmount = true;
    } else {
      currentInput.style.border = "";
      total += inputValue;
    }
  }

  if (invalidAmount) {
    document.getElementById("sabt").disabled = true;
    error_message.style.display = "table-row";
  } else {
    totalCountInput.value = total;
    error_message.style.display = "none";
    if (invoiceNumberInput.value == "") {
      document.getElementById("sabt").disabled = true;
    } else {
      document.getElementById("sabt").disabled = false;
    }
  }
}

let notAllowed = [];
let totalCount = document.getElementById("totalCount");
if (totalCount) {
  totalCount.value = 0;
}

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

    var invoiceNumberInput = document.getElementById("invoice_number");

    if (qty !== 0 && qty <= prev_qty) {
      if (invoiceNumberInput && invoiceNumberInput.value !== "")
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
      if (totalCount) {
        totalCount.value = Number(totalCount.value) + Number(qty);
      }

      $(this).parent().parent().find(".qtybank-first").text(xqty);
      $("#result_box").append(
        `
        <tr>
          <td>
            <div class="good_amount_details">
              <p>${code}</p>
              <p>${seller}</p>
              <p>${brand}</p>
              <input type="hidden" name="qtyid[]" value="${qtyid}">
              <input type="number" name="qty[]" value="${qty}" id="good_amount" onchange="validateAmount(this)">
              <input type="hidden" name="prev_qty" value="${prev_qty}" />
            </div>
          </td>
          <td style="text-align:left">
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
