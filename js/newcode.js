var frm = $("#newcode");

frm.on("submit", function (e) {
  e.preventDefault();

  $(".bottom-bar").addClass("msg-loading");
  $("#sabt").prop("disabled", true);
  $.ajax({
    type: frm.attr("method"),
    url: frm.attr("action"),
    data: frm.serialize(),
    success: function (data) {
      $(".error").text("Submission was successful.");
      $(".error").html(data);
      $(".bottom-bar").removeClass("msg-loading");

      $("#sabt").prop("disabled", false);
      $("#doll-gen").val(null);
      $("#doll-psq").val(null);
      $("#doll-mob").val(null);
      $("#doll-pm").val(null);
      $("#newcode-in").val(null);
    },
    error: function (data) {
      $(".error").text("An error occurred.");
      $(".error").html(data);
      $(".bottom-bar").removeClass("msg-loading");
      $("#sabt").prop("disabled", false);
    },
  });
});
