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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
        }

        ul#main_menu {
            display: flex;
            flex-wrap: wrap;
        }

        .menu_item {
            text-decoration: none;
            color: white;
            display: inline-block;
            background-color: rgb(79 70 229);
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            font-size: 14px;
        }

        .drop_down_menu {
            display: none;
        }
    </style>
</head>

<body>
    <nav id="main_nav">
        <ul id="main_menu" style="display:flex;">
            <li><i class="material-icons">apps</i></li>
            <li><a class="menu_item" href="vorodkala-index.php">ورود کالا </a></li>
            <li><a class="menu_item" href="khorojkala-index.php">خروج کالا </a></li>
            <li><a class="menu_item" href="shomaresh-index.php">انبارگردانی</a></li>
            <li>
                <a class="menu_item" href="vorodkala-report.php">گزارش ورود </a>
                <ul class="drop_down_menu">
                    <li><a class="menu_item" href="vorodkala-report.php?interval=10">10 روز اخیر</a></li>
                    <li><a class="menu_item" href="vorodkala-report.php?interval=30">30 روز اخیر</a></li>
                    <li><a class="menu_item" href="vorodkala-report.php?interval=60">60 روز اخیر</a></li>
                    <li><a class="menu_item" href="vorodkala-report.php?interval=120">120 روز اخیر</a></li>
                </ul>
            </li>
            <li>
                <a class="menu_item" href="khorojkala-report.php">گزارش خروج </a>
                <ul class="drop_down_menu">
                    <li><a class="menu_item" href="khorojkala-report.php?interval=10">10 روز اخیر</a></li>
                    <li><a class="menu_item" href="khorojkala-report.php?interval=30">30 روز اخیر</a></li>
                    <li><a class="menu_item" href="khorojkala-report.php?interval=60">60 روز اخیر</a></li>
                    <li><a class="menu_item" href="khorojkala-report.php?interval=120">120 روز اخیر</a></li>
                </ul>
            </li>
            <li>
                <a class="menu_item" href="mojodikala-report.php">موجودی کالا <i class="fas fa-compress-arrows-alt"></i></a>
            </li>
            <li>
                <a class="menu_item" href="price.php">سامانه قیمت <i class="fas fa-dollar-sign"></i></a>
                <ul class="drop_down_menu">
                    <li><a class="menu_item" target="_blank" href="https://yadakinfo.com/projects/price/">قیمت موبیز</a></li>
                </ul>
            </li>
            <li><a class="menu_item" href="file-index.php">مدیریت فایل </a></li>
            <li><a class="menu_item" target="_blank" href="../callcenter/">مرکز تماس </a></li>
            <li>
                <a class="menu_item" href="./transfer_index.php">
                    انتقال به انبار
                </a>
                <ul class="drop_down_menu">
                    <li><a class="menu_item" href="transfer_report.php">گزارش انتقالات</a></li>
                    <li><a class="menu_item" href="goodLimitReport.php"> نیاز به انتقال</a></li>
                    <li><a class="menu_item" href="goodLimitReportAll.php">گزارش کسرات</a></li>
                </ul>
            </li>
        </ul>
        <div>
            <?php echo $_SESSION["username"]; ?>
            <a href="logout.php">خروج
            </a>

        </div>
    </nav>
    <aside></aside>