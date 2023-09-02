let redirect_to = null;
const redirect = document.getElementById("redirect");

function redirectTo(url, namespace) {
  redirect_to = url;
  redirect.style.display = "flex";
  document.getElementById("redirectMessage").innerHTML =
    "آیا مطمئن هستید که میخواهید به صفحه" +
    " " +
    namespace +
    " " +
    "منتقل شوید؟";
}

function confirm() {
  window.location.href = redirect_to;
}

function decline() {
  redirect.style.display = "none";
}
