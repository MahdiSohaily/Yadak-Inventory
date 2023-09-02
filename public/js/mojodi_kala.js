// START ------- SEARCH FOR MOJODI KALA SCRIPT --------------------------------
const resultBox = document.getElementById("mojodiResult");

function searchGoods(value) {
  let pattern = value;

  if (pattern.length > 5) {
    pattern = pattern.replace(/\s/g, "");
    pattern = pattern.replace(/-/g, "");
    pattern = pattern.replace(/_/g, "");
    sendRequest("search", pattern);
  }
}

function sendRequest(action, pattern) {
  var params = new URLSearchParams();
  params.append("pattern", pattern);
  params.append("search", action);

  resultBox.innerHTML = `
  <tr class='full-page'>
      <td colspan='18'>
      <img style='width: 60px; margin-block:30px' src='../callcenter/report/public/img/loading.png' alt='google'>
      <p class="pt-2 text-gray-500">لطفا صبور باشید</p>
      </td>
  </tr>`;

  axios
    .post("./app/controller/MojodiKalaControllerAjax.php", params)
    .then(function (response) {
      console.log(response.data);
      resultBox.innerHTML = response.data;
    })
    .catch(function (error) {
      console.log(error);
    });
}
// END ---------- SEARCH FOR MOJODI KALA SCRIPT --------------------------------

// START REDIRECT TO THE MOJODI KALA JS SCRIPTS
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
// END REDIRECT TO THE MOJODI KALA JS SCRIPTS
