 $(document).ready(function () {


     $(".filter select").prop("selectedIndex", -1);


     var frm = $("#vorod-filter");

     frm.submit(function (e) {



     });



     $("#excel").click(function () {


         $(".report-table").table2excel({
             filename: "vorodkala-report.xls"
         });

     });



 });
