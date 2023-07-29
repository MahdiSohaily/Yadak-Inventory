<?php
// Initialize the session
require_once './php/function.php';
require_once './php/jdf.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="js/font.min.js"></script>
    <script src="js/jquery-1.11.3.min.js"></script>

    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <link rel='stylesheet' href='css/style.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
    <link rel='stylesheet' href='css/modal.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
    <link type="text/css" rel="stylesheet" href="css/persianDatepicker.css" />

    <?php
    switch (basename($_SERVER['PHP_SELF'])) {
        case 'price.php':
            $title = "سامانه قیمت";
            echo '<link rel="stylesheet" href="css/price.css?v=' . rand() . '" type="text/css" media="all" />';
            break;
        case 'khorojkala-index.php':
            $title = "خروج کالا";
            break;
        case 'vorodkala-index.php':
            $title = "ورود کالا";
            break;
        case 'khorojkala-report.php':
            $title = "گزارش خروج";
            break;
        case 'vorodkala-report.php':
            $title = "گزارش ورود";
            break;
        case 'shomaresh-index.php':
            $title = "انبار گردانی";
            break;
        case 'newcode-index.php':
            $title = "کد فنی جدید";
            break;
        case 'mojodikala-report.php':
            $title = "موجودی کالا";
            break;
        case 'index.php':
            $title = "صفحه اصلی";
            break;
        case 'customer-index.php':
            $title = "مشتری";
            break;
        case 'invoice-index.php':
            $title = "فاکتور فروش";
            break;
        case 'file-index.php':
            $title = "مدیریت فایل";
            break;
        case 'mojodikala-report-simple.php':
            $title = "موجودی کالا نسخه سبک";
            break;
        default:
            $title = "صفحه اصلی";
            break;
    }

    echo "<title>$title</title>";

    ?>
</head>

<body>
    <div style="position: fixed; z-index:100" class="top-bar">
        <div class="link">
            <li><a href="vorodkala-index.php">ورود کالا <i class="fas fa-arrow-circle-right"></i></a></li>
            <li><a href="khorojkala-index.php">خروج کالا <i class="fas fa-arrow-circle-left"></i></a></li>
            <li><a href="shomaresh-index.php">انبارگردانی <i class="fas fa-expand-arrows-alt"></i></a></li>
            <li>
                <a href="vorodkala-report.php">گزارش ورود <i class="far fa-caret-square-right"></i></a>

                <ul class="under-link">
                    <li><a href="#">10 روز اخیر</a></li>
                    <li><a href="#">30 روز اخیر</a></li>
                    <li><a href="#">60 روز اخیر</a></li>
                    <li><a href="#">120 روز اخیر</a></li>
                </ul>
            </li>
            <li>
                <a href="khorojkala-report.php">گزارش خروج <i class="far fa-caret-square-left"></i></a>
                <ul class="under-link">
                    <li><a href="#">10 روز اخیر</a></li>
                    <li><a href="#">30 روز اخیر</a></li>
                    <li><a href="#">60 روز اخیر</a></li>
                    <li><a href="#">120 روز اخیر</a></li>
                </ul>
            </li>
            <li>
                <a href="mojodikala-report.php">موجودی کالا <i class="fas fa-compress-arrows-alt"></i></a>

                <ul class="under-link">
                    <li><a href="mojodikala-report-simple.php">موجودی سبک</a></li>
                </ul>
            </li>
            <li><a href="newcode-index.php">کد فنی جدید <i class="far fa-plus-square"></i></a></li>
            <li>
                <a href="price.php">سامانه قیمت <i class="fas fa-dollar-sign"></i></a>
                <ul class="under-link">
                    <li><a target="_blank" href="https://yadakinfo.com/projects/price/">قیمت موبیز</a></li>

                </ul>
            </li>
            <li><a href="customer-index.php">مشتری <i class="fas fa-user"></i></a></li>
            <li><a href="invoice-index.php">فاکتور فروش <i class="fas fa-file-invoice-dollar"></i></a></li>
            <li><a href="file-index.php">مدیریت فایل <i class="fas fa-file-excel"></i></a></li>
            <li><a target="_blank" href="../callcenter/">مرکز تماس <i class="fas fa-headphones"></i></a></li>
            <li class="sale-mali">سال 1402</li>
        </div>
        <div class="user-box">
            <?php echo $_SESSION["username"]; ?>
            <a href="logout.php">خروج<i class="fas fa-sign-out-alt"></i>
            </a>

        </div>
    </div>