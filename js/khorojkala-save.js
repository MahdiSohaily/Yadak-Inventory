$(document).ready(function () {
  const form = $("#khorojkala");

  form.submit(function (e) {
    e.preventDefault();

    $(".bottom-bar").addClass("msg-loading");
    $("#sabt").prop("disabled", true);
    $.ajax({
      type: form.attr("method"),
      url: form.attr("action"),
      data: form.serialize(),
      success: function (data) {
        $(".error").text("Submission was successful.");
        $(".error").html(data);
        $(".bottom-bar").removeClass("msg-loading");
        $("#qty").val(null);
        $("#des").val(null);
        $("#sabt").prop("disabled", false);

        $(".add-to-basket .item").remove();
      },
      error: function (data) {
        $(".error").text("An error occurred.");
        $(".error").html(data);
        $(".bottom-bar").removeClass("msg-loading");
        $("#sabt").prop("disabled", false);
      },
    });
  });
});
