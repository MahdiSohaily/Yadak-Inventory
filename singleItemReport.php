<?php
require_once("./views/Layout/header.php");
require_once("./app/controller/SingleItemReportController.php");
$interval = '553113f';
if (isset($_GET['interval'])) {
}
?>
<link rel="stylesheet" href="./public/css/singleItem.css">
<link rel="stylesheet" href="./public/css/singleItem.css">
<section class="flex justify-center">
    <input class="form-controller" type="text" name="code" id="code" onkeyup="convertToEnglish(this); search(this.value)" placeholder="کد مد نظر خود را بصورت کامل وارد کنید">
</section>

<section id="price">
    <h2>قیمت قطعه</h2>
    <table class="">
        <thead class="font-medium dark:border-neutral-500">
            <tr class="bg-green-700">
                <th scope="col" class="px-3 py-3 bg-black text-white w-52 text-center">
                    شماره فنی
                </th>
                <th scope="col" class="px-3 py-3 text-white w-20">
                    دلار پایه
                </th>
                <th scope="col" class="px-3 py-3 text-white border-black border-r-2">
                    +10%
                </th>
                <?php foreach ($rates as $rate) : ?>
                    <th class='<?= $rate['status']; ?> px-3 py-3 text-white text-center ' scope='col'>
                        <?= $rate['amount'] ?>
                    </th>
                <?php endforeach; ?>
                <th scope="col" class="px-3 py-3 text-white w-32 text-center">
                    عملیات
                </th>
                <th scope="col" class="px-3 py-3 text-white">
                    وزن
                </th>
            </tr>
        </thead>
        <tbody id="results">
        </tbody>
    </table>
</section>
<section id="import">
    <h2>گزارش ورود</h2>
</section>
<section id="export">
    <h2>گزارش خروج</h2>
</section>
<script>
    let result = null;

    const search = (val) => {
        let pattern = val;
        const resultBox = document.getElementById("results");



        if (pattern.length > 6) {
            pattern = pattern.replace(/\s/g, "");
            pattern = pattern.replace(/-/g, "");
            pattern = pattern.replace(/_/g, "");

            resultBox.innerHTML = `<tr class=''>
            <td colspan='14' class='py-10 text-center'> 
                <img class=' block w-10 mx-auto h-auto' src='./public/img/loading.png' alt='loading'>
                </td>
        </tr>`;
            var params = new URLSearchParams();
            params.append('pattern', pattern);

            axios.post("../callcenter/report/app/Controllers/SearchController.php", params)
                .then(function(response) {
                    resultBox.innerHTML = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            resultBox.innerHTML = "";
        }
    };

    <?php
    if ($interval) {
        echo "search('$interval')";
    }
    ?>
</script>