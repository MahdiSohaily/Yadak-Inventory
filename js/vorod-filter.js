$(document).on("ready", function () {
  $(".filter select").prop("selectedIndex", -1);

  var frm = $("#vorod-filter");

  frm.on("submit", function (e) {});

  $("#excel").on("click", function () {
    $(".report-table").table2excel({
      filename: "vorodkala-report.xls",
    });
  });
});
