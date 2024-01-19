<?php
require_once("../../config/db_connect.php");
require_once("../../utilities/helpers.php");
require_once("../../php/jdf.php");
$successfulOperation = false;

if (isset($_GET['record'])) {
    $record_id = $_GET['record'];
    $selected_record = getRecord($record_id);
    $brands = getBrands();
    $sellers = getSellers();
    $stocks = getStocks();
    $deliverers = getDeliverers();
}

if (isset($_POST['selected_record_id'])) {
    $record_id = $_POST['selected_record_id'];

    $successfulOperation = saveChanges($_POST);
    $selected_record = getRecord($record_id);
    $brands = getBrands();
    $sellers = getSellers();
    $stocks = getStocks();
    $deliverers = getDeliverers();
}
?>
<!DOCTYPE html>
<html style="margin-top:0">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='../../../callcenter/report/public/css/styles.css?v=<?= rand() ?>' type='text/css' media='all' />
    <script src="../../../callcenter/report/public/js/index.js?v=<?= rand() ?>"></script>
    <link type="text/css" rel="stylesheet" href="../../css/persianDatepicker.css" />

    <script src="../../js/jquery-1.11.3.min.js"></script>
    <script src="../../public/js/assets/assets/axios.js"></script>
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
</head>


<?php
function getRecord($record_id)
{
    try {
        $statement = DB_CONNECTION->prepare("SELECT 
        qtybank.id AS purchase_id,
        qtybank.des AS purchase_description,
        qtybank.qty AS purchase_quantity,
        qtybank.anbarenter AS purchase_isEntered,
        nisha.id AS partNumber_id,
        nisha.partnumber,
        users.username AS username,
        seller.name AS seller_name,
        seller.id AS slid AS seller_id,
        stock.name AS stock_name,
        brand.name AS brand_name,
        exitrecord.qty AS sold_quantity,
        exitrecord.id AS sold_id,
        exitrecord.customer AS sold_customer,
        exitrecord.des AS sold_description,
        exitrecord.exit_time AS sold_time,
        exitrecord.jamkon,
        exitrecord.invoice_number AS sold_invoice_number,
        exitrecord.invoice_date AS sold_invoice_date,
        getter.id AS getter_id,
        getter.name AS getter_name,
        deliverer.id AS deliverer_id,
        deliverer.name AS deliverer_name,
        callcenter.shomarefaktor.kharidar AS customer
        FROM qtybank
        INNER JOIN nisha ON qtybank.codeid = nisha.id
        INNER JOIN exitrecord ON qtybank.id = exitrecord.qtyid
        LEFT JOIN seller ON qtybank.seller = seller.id
        LEFT JOIN brand ON qtybank.brand = brand.id
        LEFT JOIN stock ON qtybank.stock_id = stock.id
        LEFT JOIN users ON exitrecord.user = users.id
        LEFT JOIN deliverer ON qtybank.deliverer = deliverer.id
        LEFT JOIN getter ON exitrecord.getter = getter.id
        LEFT JOIN callcenter.shomarefaktor ON exitrecord.invoice_number = shomarefaktor.shomare
        WHERE exitrecord.id = '$q'");

        $statement->bindParam(':record_id', $record_id);
        $statement->execute();

        $purchaseList = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $purchaseList ? $purchaseList[0] : [];
    } catch (\Throwable $th) {
        die('ریکارد مد نظر شما در سیستم موجود نمی باشد.');
    }
}
