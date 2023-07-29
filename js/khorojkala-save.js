  $(document).ready(function () {



      var frm = $('#khorojkala');

      frm.submit(function (e) {

          e.preventDefault();

          $(".bottom-bar").addClass("msg-loading");
          $("#sabt").prop('disabled', true);
          $.ajax({
              type: frm.attr('method'),
              url: frm.attr('action'),
              data: frm.serialize(),
              success: function (data) {
                  $(".error").text('Submission was successful.');
                  $(".error").html(data);
                  $(".bottom-bar").removeClass("msg-loading");
                  $("#qty").val(null);
                  $("#des").val(null);
                  $("#sabt").prop('disabled', false);

                  $(".add-to-basket .item").remove();



              },
              error: function (data) {
                  $(".error").text('An error occurred.');
                  $(".error").html(data);
                  $(".bottom-bar").removeClass("msg-loading");
                  $("#sabt").prop('disabled', false);


              },
          });
      });



  });
