 $(document).ready(function () {

     $(".edit-rec2").click(function () {
         $(".modal").css("display", "block");
         $(this).attr("id");
         $("iframe").attr("src", "php/khorojkala-report-edit.php?q=" + $(this).attr("id"));

     });

 });
