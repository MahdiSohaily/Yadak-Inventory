$(document).on("ready", function () {
  var frm = $("#shomaresh");

  frm.on("submit", function (e) {
    e.preventDefault();

    $("#brand-box").val($("#esalat option:selected").html());

    $(".bottom-bar").addClass("msg-loading");
    $("#sabt").prop("disabled", true);
    $.ajax({
      type: frm.attr("method"),
      url: frm.attr("action"),
      data: frm.serialize(),
      success: function (data) {
        $(".error").html(data);
        $(".bottom-bar").removeClass("msg-loading");
        $("#qty").val(null);
        $("#des").val(null);
        $("#codeid-box").val(null);
        $("#sabt").prop("disabled", false);
      },
      error: function (data) {
        $(".error").html(data);
        $(".bottom-bar").removeClass("msg-loading");
        $("#sabt").prop("disabled", false);
      },
    });
  });
});
