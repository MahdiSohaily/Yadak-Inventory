$(document).ready(function () {
  $("#getter").val($("#getter").attr("data")).change();

  $(".del-vorod").click(function () {
    var str = $(this).attr("data");

    var r = confirm("حذف شود ؟");
    if (r == true) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          $(".error").text(this.responseText);
        }
      };
      xmlhttp.open("GET", "khorojkala-report-edit-del.php?q=" + str, true);
      xmlhttp.send();
    }
  });

  var frm = $("#khoroj-edit");

  frm.submit(function (e) {
    e.preventDefault();

    $(".bottom-bar").addClass("msg-loading");
    $("#sabt").prop("disabled", true);
    $.ajax({
      type: frm.attr("method"),
      url: frm.attr("action"),
      data: frm.serialize(),
      success: function (data) {
        $(".error").text("Submission was successful.");
        $(".error").text(data);
        $(".bottom-bar").removeClass("msg-loading");

        $("#sabt").prop("disabled", false);
      },
      error: function (data) {
        $(".error").text("An error occurred.");
        $(".error").text(data);
        $(".bottom-bar").removeClass("msg-loading");
        $("#sabt").prop("disabled", false);
      },
    });
  });
});
