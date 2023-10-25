$(document).on("ready", function () {
  $("#MojodiSearch").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $(".mojodi-table tr").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
});
