<?php

function echoRial($x, $y)
{
    if (!empty($x)) {


        if ($y == "GEN") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 32 * 1.3 * 1.3) * 10000), 0);
        }
        if ($y == "MOB") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 32 * 1.3 * 0.9 * 1.3) * 10000), 0);
        }
        if ($y != "GEN" && $y != "MOB") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 32 * 1.3 * 0.5 * 1.3) * 10000), 0);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="js/font.min.js"></script>
    <script src="js/jquery-1.11.3.min.js"></script>

    <title>موجودی آنلاین</title>
    <link rel='stylesheet' href='css/style.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
    <link rel='stylesheet' href='css/modal.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
</head>

<body>
    <div>
        <div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>#</th>

                        <th>شماره فنی</th>
                        <th>برند</th>
                        <th>تعداد موجود</th>

                        <th>توضیحات</th>
                        <th>قیمت فقط برای ذهنیت</th>
                    </tr>
                </thead>
                <tbody class="mojodi-table">
                    <?php include("php/mojodikala-report-geter-online.php") ?>
                </tbody>

            </table>

        </div>
    </div>


    <?php include("./views/Layout/footer.php") ?>