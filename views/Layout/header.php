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
    <script src="./js/jquery-1.11.3.min.js?v=<?php echo (rand()) ?>"></script>
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
            $title = "صفحه اصلی";
            echo '<link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">';
            break;
    }

    echo "<title>$title</title>";

    ?>
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 6px !important;
            height: 4px !important;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey !important;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: rgb(105, 104, 104) !important;
            border-radius: 5px !important;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #6d6c6c !important;
        }
    </style>
    <script src="./js/assets/axios.js"></script>
    <script>
        function convertToPersian(element) {
            // Define a mapping of English keyboard keys to Persian characters
            const persianCharMap = {
                'a': 'ش',
                'b': 'ذ',
                'c': 'ز',
                'd': 'ی',
                'e': 'ث',
                'f': 'ب',
                'g': 'ل',
                'h': 'ا',
                'i': 'ه',
                'j': 'ت',
                'k': 'ن',
                'l': 'م',
                'm': 'پ',
                'n': 'د',
                'o': 'خ',
                'p': 'ح',
                'q': 'ض',
                'r': 'ق',
                's': 'س',
                't': 'ف',
                'u': 'ع',
                'v': 'ر',
                'w': 'ص',
                'x': 'ط',
                'y': 'غ',
                'z': 'ظ',
                ',': 'و',
                "'": 'گ',
                ";": 'ک',
                "]": 'چ',
                '1': '۱',
                '2': '۲',
                '3': '۳',
                '4': '۴',
                '5': '۵',
                '6': '۶',
                '7': '۷',
                '8': '۸',
                '9': '۹',
                '0': '۰'
            };
            const customInput = element;
            let customText = '';
            const inputText = customInput.value.toLowerCase();
            for (let i = 0; i < inputText.length; i++) {
                const char = inputText[i];
                if (char in persianCharMap) {
                    customText += persianCharMap[char];
                } else {
                    customText += char;
                }
            }
            customInput.value = customText;
        }

        function convertToEnglish(element) {
            const englishCharMap = {
                'ش': 'a',
                'ذ': 'b',
                'ز': 'c',
                'ی': 'd',
                'ث': 'e',
                'ب': 'f',
                'ل': 'g',
                'ا': 'h',
                'ه': 'i',
                'ت': 'j',
                'ن': 'k',
                'م': 'l',
                'پ': 'm',
                'د': 'n',
                'خ': 'o',
                'ح': 'p',
                'ض': 'q',
                'ق': 'r',
                'س': 's',
                'ف': 't',
                'ع': 'u',
                'ر': 'v',
                'ص': 'w',
                'ط': 'x',
                'غ': 'y',
                'ظ': 'z',
                'و': ':',
                'گ': "'",
                'ک': ";",
                'چ': "]",
                '۱': '1',
                '۲': '2',
                '۳': '3',
                '۴': '4',
                '۵': '5',
                '۶': '6',
                '۷': '7',
                '۸': '8',
                '۹': '9',
                '۰': '0'
            };

            const customInput = element;
            let customText = '';
            const inputText = customInput.value.toLowerCase();
            for (let i = 0; i < inputText.length; i++) {
                const char = inputText[i];
                if (char in englishCharMap) {
                    customText += englishCharMap[char];
                } else {
                    customText += char;
                }
            }
            customInput.value = customText;
        }
    </script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        nav#main_nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: rgb(229 229 229);
            box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
            z-index: 1000000;
        }

        ul#main_menu {
            display: flex;
            flex-wrap: wrap;
        }

        .dropdown {
            position: relative;
        }

        .drop_down_menu,
        .drop_down_menu_aside {
            position: absolute;
            display: none;
            z-index: 10000000000000000000000000000 !important;
        }

        .drop_down_menu {
            top: 100%;
            width: 200px;
            background-color: rgb(124 58 237);
            border: 1px solid rgb(124 58 237);
        }

        .drop_down_menu_aside {
            width: 100%;
            top: 0%;
            right: 100%;
            border: 1px solid rgb(139 92 246);
            background-color: rgb(139 92 246);
        }

        .menu_item_dropdown {
            display: block;
            text-decoration: none;
            color: #fff;
            padding: 15px 30px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .menu_item_dropdown:hover {
            background-color: rgb(109 40 217);
            color: white;
        }

        .dropdown:hover>.drop_down_menu,
        .dropdown:hover>.drop_down_menu_aside {
            display: block;
        }

        .dropdown:hover>.drop_down_menu::after {
            content: " ";
            position: absolute;
            bottom: 100%;
            /* At the top of the tooltip */
            left: 80%;
            margin-left: -8px;
            border-width: 8px;
            border-style: solid;
            border-color: transparent transparent rgb(124 58 237) transparent;
        }

        .open_menu,
        .close_menu {
            font-size: 20px;
            padding: 10px;
            cursor: pointer;
        }

        .menu_item {
            text-decoration: none;
            color: white;
            display: inline-block;
            background-color: rgb(124 58 237);
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            font-size: 14px;
        }

        .menu_item:hover {
            background-color: rgb(109 40 217);
        }

        aside#side_bar {
            position: fixed;
            top: 0;
            bottom: 0;
            right: -500px;
            width: 300px;
            z-index: 1000;
            height: 100vh;
            padding-block: 20px;
            background-color: rgb(229 229 229);
            transition: all 0.5s ease-in-out;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px;
        }

        aside#side_bar.open {
            right: 0;
        }

        .aside_item {
            text-decoration: none;
            padding: 15px 30px;
            display: block;
            color: #333;
        }

        .aside_item:hover {
            background-color: rgb(139 92 246);
            color: white;
        }

        .close_menu {
            color: red;
            text-decoration: none;
            padding: 15px 30px;
            display: block;
        }

        .userImage {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        .profile_action {
            display: flex;
            justify-content: space-around;
            align-items: center;
            gap: 5px
        }

        .tv_control {
            cursor: pointer;
            font-size: 20px;
            color: rgb(79 70 229);
        }
    </style>
</head>

<body style="padding-block: 80px">
    <nav id="main_nav">
        <ul id="main_menu" style="display:flex;">
            <li>
                <i class="fas fa-bars open_menu" onclick="toggleSidebar()"></i>
            </li>
            <li><a class="menu_item" href="vorodkala-index.php">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    ورود کالا </a></li>
            <li><a class="menu_item" href="khorojkala-index.php">
                    <i class="fa fa-minus-circle" aria-hidden="true"></i>
                    خروج کالا
                </a></li>
            <li class="dropdown">
                <a class="menu_item" href="vorodkala-report.php">
                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                    گزارش ورود
                    <i class="fa fa-caret-left" aria-hidden="true"></i>
                </a>
                <ul class="drop_down_menu">
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
                </ul>
            </li>
            <li class="dropdown">
                <a class="menu_item" href="khorojkala-report.php">
                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                    گزارش خروج
                    <i class="fa fa-caret-left" aria-hidden="true"></i>
                </a>
                <ul class="drop_down_menu">
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
            <i class="fa fa-desktop tv_control" aria-hidden="true"></i>
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
                <i class="fa fa-times close_menu" aria-hidden="true" onclick="toggleSidebar()"></i>
            </li>
            <li><a class="aside_item" href="file-index.php">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    مدیریت فایل </a></li>
            <li><a class="aside_item" href="shomaresh-index.php">
                    <i class="fa fa-building" aria-hidden="true"></i>
                    انبارگردانی</a>
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
    </aside>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('side_bar');
            sidebar.classList.toggle('open');
        }
    </script>