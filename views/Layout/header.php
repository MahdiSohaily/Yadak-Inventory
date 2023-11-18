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
</head>

<body>
    <div id="page_header" style="position: fixed; z-index:100" class="top-bar">
        <div class="link">
            <li><a href="vorodkala-index.php">ورود کالا <i class="fas fa-arrow-circle-right"></i></a></li>
            <li><a href="khorojkala-index.php">خروج کالا <i class="fas fa-arrow-circle-left"></i></a></li>
            <li><a href="shomaresh-index.php">انبارگردانی <i class="fas fa-expand-arrows-alt"></i></a></li>
            <li>
                <a href="vorodkala-report.php">گزارش ورود <i class="far fa-caret-square-right"></i></a>
                <ul class="under-link">
                    <li><a href="vorodkala-report.php?interval=10">10 روز اخیر</a></li>
                    <li><a href="vorodkala-report.php?interval=30">30 روز اخیر</a></li>
                    <li><a href="vorodkala-report.php?interval=60">60 روز اخیر</a></li>
                    <li><a href="vorodkala-report.php?interval=120">120 روز اخیر</a></li>
                </ul>
            </li>
            <li>
                <a href="khorojkala-report.php">گزارش خروج <i class="far fa-caret-square-left"></i></a>
                <ul class="under-link">
                    <li><a href="khorojkala-report.php?interval=10">10 روز اخیر</a></li>
                    <li><a href="khorojkala-report.php?interval=30">30 روز اخیر</a></li>
                    <li><a href="khorojkala-report.php?interval=60">60 روز اخیر</a></li>
                    <li><a href="khorojkala-report.php?interval=120">120 روز اخیر</a></li>
                </ul>
            </li>
            <li>
                <a href="mojodikala-report.php">موجودی کالا <i class="fas fa-compress-arrows-alt"></i></a>

                <ul class="under-link">
                    <li><a href="mojodikala-report-simple.php">موجودی سبک</a></li>
                </ul>
            </li>
            <li>
                <a href="price.php">سامانه قیمت <i class="fas fa-dollar-sign"></i></a>
                <ul class="under-link">
                    <li><a target="_blank" href="https://yadakinfo.com/projects/price/">قیمت موبیز</a></li>

                </ul>
            </li>
            <li><a href="file-index.php">مدیریت فایل <i class="fas fa-file-excel"></i></a></li>
            <li><a target="_blank" href="../callcenter/">مرکز تماس <i class="fas fa-headphones"></i></a></li>
            <li>
                <a href="./transfer_index.php">
                    انتقال به انبار
                    <i class="far fa-caret-square-right"></i>
                </a>
                <ul class="under-link">
                    <li><a href="transfer_report.php">گزارش انتقالات</a></li>
                    <li><a href="goodLimitReport.php"> نیاز به انتقال</a></li>
                    <li><a href="goodLimitReportAll.php">گزارش کسرات</a></li>
                </ul>
            </li>
            <li class="sale-mali">سال 1402</li>
        </div>
        <div class="user-box">
            <?php echo $_SESSION["username"]; ?>
            <a href="logout.php">خروج<i class="fas fa-sign-out-alt"></i>
            </a>

        </div>
    </div>
    <div id="redirect">
        <div class="alertMessage">
            <p id='redirectMessage'></p>
            <div>
                <button onclick="confirm()" class="btn btn-confirm">تایید</button>
                <button onclick="decline()" class="btn btn-decline">انصراف</button>
            </div>
        </div>
    </div>