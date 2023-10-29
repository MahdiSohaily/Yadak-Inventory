var page = location.pathname.split("/").pop();

$('.link a[href="' + page + '"]').addClass("active");

$("#frame").on("load", function () {
  this.contentWindow.scrollBy(0, 100000);
});
