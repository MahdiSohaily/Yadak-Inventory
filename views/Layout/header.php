<?php
// Initialize the session
require_once './app/Middleware/Authorize.php';
require_once './php/function.php';
require_once './php/jdf.php';
require_once './bootstrap/init.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel='stylesheet' href='./css/style.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
    <link rel='stylesheet' href='./css/modal.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
    <link type="text/css" rel="stylesheet" href="css/persianDatepicker.css" />
    <link rel="stylesheet" href="./css/exit_record/exit.css?v=<?php echo rand() ?>" type="text/css" media="all" />
    <link rel="stylesheet" href="./css/assets/select2.css?v=<?php echo (rand()) ?>" />
    <link rel="stylesheet" href="./public/css/mojodi_kala.css?v=<?php echo (rand()) ?>" />
    <link rel="stylesheet" href="./public/css/nav.css?v=<?php echo (rand()) ?>" type="text/css" media="all" />
    <link href="./public/css/material_icons.css" rel="stylesheet">

    <script src=" ./js/jquery-1.11.3.min.js?v=<?php echo (rand()) ?>">
    </script>
    <script type="text/javascript" src="./js/assets/table2excel.js?v=<?php echo (rand()) ?>"></script>
    <script src="js/font.min.js?v=<?php echo (rand()) ?>"></script>
    <script src="./js/assets/select2.js?v=<?php echo (rand()) ?>"></script>
    <?php
    switch (basename($_SERVER['PHP_SELF'])) {
        case 'price.php':
            $title = "سامانه قیمت";
            echo '<link rel="stylesheet" href="css/price.css?v=' . rand() . '" type="text/css" media="all" />';
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'khorojkala-index.php':
            $title = "خروج کالا";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'vorodkala-index.php':
            $title = "ورود کالا";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'khorojkala-report.php':
            $title = "گزارش خروج";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'vorodkala-report.php':
            $title = "گزارش ورود";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'shomaresh-index.php':
            $title = "انبار گردانی";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'newcode-index.php':
            $title = "کد فنی جدید";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'mojodikala-report.php':
            $title = "موجودی کالا";
            echo '<link rel="shortcut icon" href="./img/inventory.png" type="image/x-icon">';
            break;
        case 'index.php':
            $title = "صفحه اصلی";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'customer-index.php':
            $title = "مشتری";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'invoice-index.php':
            $title = "فاکتور فروش";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
        case 'file-index.php':
            $title = "مدیریت فایل";
            break;
        case 'mojodikala-report-simple.php':
            $title = "موجودی کالا نسخه سبک";
            echo '<link rel="shortcut icon" href="./img/inventory.png" type="image/x-icon">';
            break;
        default:
            $title = "سامانه قیمت";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
    }
    echo "<title>$title</title>";
    ?>
    <script src="./js/assets/axios.js"></script>
    <script src="./public/js/helper.js"></script>
</head>

<body style="padding-block: 10px">
    <nav id="main_nav">
        <ul id="main_menu" style="display:flex;">
            <li>
                <i id="open_aside_icon" class="fas fa-bars open_menu" onclick="toggleSidebar()"></i>
            </li>
            <li><a class="menu_item" href="vorodkala-index.php">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    ورود کالا </a></li>
            <li><a class="menu_item" href="khorojkala-index.php">
                    <i class="fa fa-minus-circle" aria-hidden="true"></i>
                    خروج کالا
                </a></li>
            <li class="dropdown">
                <a class="menu_item" href="vorodkala-report.php?interval=10">
                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                    گزارش ورود
                    <i class="fa fa-caret-left" aria-hidden="true"></i>
                </a>
                <ul class="drop_down_menu">
                    <li><a class="menu_item_dropdown" href="vorodkala-report.php?interval=3">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            3 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="vorodkala-report.php?interval=10">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            10 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="vorodkala-report.php?interval=30">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            30 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="vorodkala-report.php?interval=60">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            60 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="vorodkala-report.php?interval=120">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            120 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="vorodkala-report.php">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            گزارش کامل
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="menu_item" href="khorojkala-report.php?interval=10">
                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                    گزارش خروج
                    <i class="fa fa-caret-left" aria-hidden="true"></i>
                </a>
                <ul class="drop_down_menu">
                    <li><a class="menu_item_dropdown" href="khorojkala-report.php?interval=3">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            3 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="khorojkala-report.php?interval=10">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            10 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="khorojkala-report.php?interval=30">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            30 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="khorojkala-report.php?interval=60">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            60 روز اخیر</a></li>
                    <li><a class="menu_item_dropdown" href="khorojkala-report.php?interval=120">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            120 روز اخیر</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="khorojkala-report.php">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            گزارش کامل
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="menu_item" href="mojodikala-report.php">
                    <i class="fa fa-university" aria-hidden="true"></i>
                    موجودی کالا
                </a>
            </li>

            <li><a class="menu_item" target="_blank" href="../callcenter/">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    مرکز تماس
                </a>
            </li>
        </ul>
        <div class="profile_action">
            <i onclick="toggleTV()" class="fa fa-desktop tv_control" aria-hidden="true"></i>
            <?php
            $profile = '../userimg/default.png';
            if (file_exists("../userimg/" . $_SESSION['id'] . ".jpg")) {
                $profile = "../userimg/" . $_SESSION['id'] . ".jpg";
            }
            ?>
            <img class="userImage mx-2" src="<?= $profile ?>" title="<?= $_SESSION['username'] ?>" alt="userimage">
            <!-- <a id="active" class="hidden" href="./report/notification.php">
                <i class="fa fa-bell" aria-hidden="true"></i>
            </a>
            <a id="deactive" class="" href="./report/notification.php">
                <i class="fa fa-bell" aria-hidden="true"></i>
            </a> -->
        </div>
    </nav>
    <aside id="side_bar">
        <ul>
            <li style="display: flex; justify-content: end;">
                <i id="close_aside_icon" class="fa fa-times close_menu" aria-hidden="true" onclick="toggleSidebar()"></i>
            </li>
            <li>
                <a class="aside_item" href="../callcenter/report/registerGood.php">
                    <i class="fa fa-folder" aria-hidden="true"></i>
                    ثبت کدفنی
                </a>
            </li>
            <li>
                <a class="aside_item" href="../callcenter/report/index.php">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    جستجوی کدفنی
                </a>
            </li>
            <li><a class="aside_item" href="file-index.php">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    مدیریت فایل </a>
            </li>
            <li><a class="aside_item" href="shomaresh-index.php">
                    <i class="fa fa-building" aria-hidden="true"></i>
                    انبارگردانی</a>
            </li>
            <li><a class="aside_item" href="singleItemReport.php">
                    <i class="fa fa-flag-checkered" aria-hidden="true"></i>
                    بررسی تک آیتم</a>
            </li>
            <li class="dropdown">
                <a class="aside_item" href="price.php" style="display: flex; justify-content: space-between;">
                    <span>
                        <i class="fa fa-cube" aria-hidden="true"></i>
                        سامانه قیمت
                    </span>
                    <i class="fa fa-caret-left" aria-hidden="true"></i>
                </a>
                <ul class="drop_down_menu_aside">
                    <li><a class="menu_item_dropdown" target="_self" href="price.php"> سامانه قیمت</a></li>
                    <li><a class="menu_item_dropdown" target="_blank" href="https://yadakinfo.com/projects/price/">قیمت موبیز</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="aside_item" href="./transfer_index.php" style="display: flex; justify-content: space-between;">
                    <span>
                        <i class="fa fa-truck" aria-hidden="true"></i>
                        انتقال به انبار
                    </span>
                    <i class="fa fa-caret-left" aria-hidden="true"></i>
                </a>
                <ul class="drop_down_menu_aside">
                    <li><a class="menu_item_dropdown" href="./transfer_index.php">
                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                            انتقال به انبار
                        </a>
                    </li>
                    <li><a class="menu_item_dropdown" href="transfer_report.php">
                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                            گزارش انتقالات</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="goodLimitReport.php">
                            <i class="fa fa-balance-scale" aria-hidden="true"></i>
                            نیاز به انتقال</a>
                    </li>
                    <li><a class="menu_item_dropdown" href="goodLimitReportAll.php">
                            <i class="fa fa-sticky-note" aria-hidden="true"></i>
                            گزارش کسرات</a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul>
            <li>
                <a class="aside_item" href="./logout.php">
                    <i class="fa fa-power-off" aria-hidden="true"></i>
                    خروج از حساب کاربری
                </a>
            </li>
        </ul>
    </aside>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('side_bar');
            sidebar.classList.toggle('open');
        }

        function toggleTV() {
            const params = new URLSearchParams();
            params.append('toggle', 'toggle');
            axios
                .post("./app/controller/tvController.php", params)
                .then(function(response) {
                    alert(response.data);
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    </script>