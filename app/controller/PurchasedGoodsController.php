<?php
require_once("./config/db_connect.php");

if (isset($_GET['interval'])) {
    $interval = $_GET['interval'];
}

if (isset($interval)) {
    date_default_timezone_set('Asia/Tehran');
    // Get today's date
    $todayDate = date('Y-m-d');

    // Calculate the date from 10 days ago
    $previousDate = date('Y-m-d', strtotime('-' . $interval . ' days'));

    $todayDate .= " 23:00:00";
    $previousDate .= " 00:00:00";

    $condition = " WHERE qtybank.create_time >= '$previousDate'
    AND qtybank.create_time <= '$todayDate'";
} else {
    $condition = 'WHERE 1=1';
}

$purchaseList = getPurchaseReport($condition);
$sellers = getSellers();

function getPurchaseReport($condition)
{
    $statement = DB_CONNECTION->prepare("SELECT qtybank.id AS purchase_id,
            qtybank.des As purchase_description,
            qtybank.qty AS purchase_quantity,
            qtybank.pos1 AS purchase_position1,
            qtybank.pos2 AS purchase_position2,
            qtybank.create_time AS purchase_time,
            qtybank.anbarenter AS purchase_isEntered,
            qtybank.invoice AS purchase_hasBill,
            qtybank.invoice_number,
            qtybank.invoice_date,
            nisha.partnumber,
            nisha.price AS good_price,
            seller.id AS seller_id,
            seller.name AS seller_name,
            brand.name AS brand_name,
            deliverer.name AS deliverer_name,
            users.username AS username,
            stock.name AS stock_name
            FROM qtybank
            INNER JOIN nisha ON qtybank.codeid = nisha.id
            INNER JOIN brand ON qtybank.brand = brand.id
            LEFT JOIN seller ON qtybank.seller = seller.id
            LEFT JOIN deliverer ON qtybank.deliverer = deliverer.id
            LEFT JOIN users ON qtybank.user = users.id
            LEFT JOIN stock ON qtybank.stock_id = stock.id 
            $condition
            AND qtybank.is_transfered = 0
            ORDER BY qtybank.create_time DESC");

    $statement->execute();
    return $statement->fetchAll();
}

function getSellers()
{
    $statement = DB_CONNECTION->prepare("SELECT id, name FROM yadakshop1402.seller ORDER BY sort DESC");
    $statement->execute();
    $data = $statement->fetchAll();
    return ($data);
}

function persianSort($array)
{
    $persianAlphabet = array(
        'آ', 'ا', 'ب', 'پ', 'ت', 'ث', 'ج', 'چ', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'ژ', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'گ', 'ل', 'م', 'ن', 'و', 'ه', 'ی'
    );

    uasort($array, function ($a, $b) use ($persianAlphabet) {
        $aLength = mb_strlen($a);
        $bLength = mb_strlen($b);
        $maxLength = max($aLength, $bLength);

        for ($i = 0; $i < $maxLength; $i++) {
            $aChar = mb_substr($a, $i, 1);
            $bChar = mb_substr($b, $i, 1);

            $aIndex = array_search($aChar, $persianAlphabet);
            $bIndex = array_search($bChar, $persianAlphabet);

            if ($aIndex !== false && $bIndex !== false) {
                if ($aIndex < $bIndex) {
                    return -1;
                } elseif ($aIndex > $bIndex) {
                    return 1;
                }
            } elseif ($aIndex !== false) {
                return -1;
            } elseif ($bIndex !== false) {
                return 1;
            }
        }

        return 0;
    });

    return $array;
}
