function upperCaseF(a) {
    setTimeout(function () {
        a.value = a.value.toUpperCase();
    }, 1);
}


$(function () {
    $("#invoice_time, #span_invoice_time").persianDatepicker({
        cellWidth: 50,
        cellHeight: 20,
        fontSize: 14,
        formatDate: "YYYY/0M/0D"

    });
});
