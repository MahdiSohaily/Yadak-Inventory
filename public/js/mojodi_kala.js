// START ------- SEARCH FOR MOJODI KALA SCRIPT --------------------------------
const resultContainer = document.getElementById("mojodiResult");

function searchGoods(value) {
  let pattern = value;

  console.log(value);

  if (pattern.length > 5) {
    pattern = pattern.replace(/\s/g, "");
    pattern = pattern.replace(/-/g, "");
    pattern = pattern.replace(/_/g, "");

    destination = "./app/controller/MojodiKalaControllerAjax.php";
    var params = new URLSearchParams();
    params.append("pattern", pattern);
    params.append("search", "search");
    setTimeout(() => {
      sendRequest(destination, params);
    }, 1000);
  }
}

function getGoods() {
  destination = "./php/mojodikala-report-geter.php";
  sendRequest(destination);
}

function sendRequest(destination, params = "") {
  resultContainer.innerHTML = `
  <tr class='full-page'>
      <td colspan='18'>
      <img style='width: 60px; margin-block:30px' src='../callcenter/report/public/img/loading.png' alt='google'>
      <p class="pt-2 text-gray-500">لطفا صبور باشید</p>
      </td>
  </tr>`;

  axios
    .post(destination, params)
    .then(function (response) {
      resultContainer.innerHTML = response.data;
    })
    .catch(function (error) {
      console.log(error);
    });
}
// END ---------- SEARCH FOR MOJODI KALA SCRIPT --------------------------------

// START REDIRECT TO THE MOJODI KALA JS SCRIPTS

let redirect_to = null;
function redirectTo(url, namespace) {
  const redirect = document.getElementById("redirect");
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
  const redirect = document.getElementById("redirect");
  redirect.style.display = "none";
}
// END REDIRECT TO THE MOJODI KALA JS SCRIPTS
