function showQty(str) {
    console.log(str);
    str = str.replace(/\s/g, "");
    str = str.replace(/-/g, "");
    str = str.replace(/_/g, "");
    var element = document.getElementById("txtHint-box");
    if (str == "") {
        document.getElementById("txtHint-khoroj").innerHTML = "";
        return;
    } else if (str.length < 7) {} else {
        document.getElementById("txtHint-khoroj").innerHTML = "";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint-khoroj").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "php/qtybank-geter.php?q=" + str, true);
        xmlhttp.send();
    }
}



$(document).ready(function () {

    $("#txtHint-khoroj").on("click", "div", function () {
        $("#txtHint-khoroj div").removeClass("clickedcode");
        $(this).addClass("clickedcode");
        $("#codeid").val($(this).attr("codeid"));



    });

});


$(document).ready(function () {

    $(".add-to-basket").on("click", ".remove-basket", function () {
        $(this).parent().remove();


    });

});



$(document).ready(function () {


    $("#txtHint-khoroj").on("click", ".add-to-khoroj", function () {
        
$(this).css("pointer-events","none");


        var code = $(this).prev().attr("code");
        var brand = $(this).prev().attr("brand");
        var seller = $(this).prev().attr("seller");
        var qtyid = $(this).prev().attr("qtyid");
        var qty = $(this).prev().val();

        var xqty = $(this).parent().parent().find('.qtybank-first').text();


        var xqty = xqty - qty;

        $(this).parent().parent().find('.qtybank-first').text(xqty);


        $(".add-to-basket").append('<div class="item"> <div>' + code + '</div> <div>' + seller + '</div> <div>' + brand + '</div> <input type="hidden" name="qtyid[]" value="' + qtyid + '"><div class="remove-basket"><input type="number" name="qty[]" value="' + qty + '" readonly><a>حذف <i class="fas fa-times"></i></a></div> </div>');



    });

});
