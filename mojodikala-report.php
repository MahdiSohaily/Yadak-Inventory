<?php include("header.php") ?>
<div>
    <div>
        <input id="MojodiSearch" onkeyup="searchGoods(this.value)" type="text" placeholder="Search..">
        <table class="report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>شماره فنی</th>
                    <th>برند</th>
                    <th>تعداد موجود</th>
                    <th>فروشنده</th>
                    <th>راهرو</th>
                    <th>قفسه</th>

                    <th>توضیحات</th>
                    <th>انبار</th>
                    <th>قیمت</th>
                </tr>
            </thead>
            <tbody id="mojodiResult" class="mojodi-table">
                <?php include_once './php/mojodikala-report-geter.php'; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const resultBox = document.getElementById("mojodiResult");

    function searchGoods(value) {
        let pattern = value;
        let superMode = 0;

        if (pattern.length > 5) {
            pattern = pattern.replace(/\s/g, "");
            pattern = pattern.replace(/-/g, "");
            pattern = pattern.replace(/_/g, "");

            resultBox.innerHTML = `
                            <tr class='full-page'>
                                <td colspan='18'>
                                <img style='width: 60px; margin-block:30px' src='../callcenter/report/public/img/loading.png' alt='google'>
                                <p class="pt-2 text-gray-500">لطفا صبور باشید</p>
                                </td>
                            </tr>`;
            var params = new URLSearchParams();
            params.append('pattern', pattern);
            params.append('search', 'search');

            axios.post("./php/mojodiKalaAjax.php", params)
                .then(function(response) {
                    resultBox.innerHTML = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            resultBox.innerHTML = "";
        }
    }
</script>


<?php include("footer.php") ?>