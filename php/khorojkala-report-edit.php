<!DOCTYPE html>
<html style="margin-top:0">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='../css/style.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
    <link type="text/css" rel="stylesheet" href="../css/persianDatepicker.css" />

    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

</head>

<body>

    <?php
$q = $_GET['q'];
 require_once("db.php"); 

$sql = "



SELECT nisha.partnumber ,qtybank.des, nisha.id , users.username AS usn , seller.name ,seller.id AS slid, stock.name AS stn ,brand.name AS brn , qtybank.qty ,qtybank.id AS qtyid,exitrecord.qty AS extqty,exitrecord.id AS exid ,  qtybank.qty AS entqty ,exitrecord.customer,exitrecord.des AS exdes,getter.name AS gtn,getter.id AS gtid,deliverer.name AS dln,exitrecord.exit_time,exitrecord.jamkon,exitrecord.invoice_number,exitrecord.invoice_date,qtybank.anbarenter
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
INNER JOIN exitrecord ON qtybank.id=exitrecord.qtyid
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN brand ON qtybank.brand=brand.id
LEFT JOIN stock ON qtybank.stock_id=stock.id
LEFT JOIN users ON exitrecord.user=users.id
LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
LEFT JOIN getter ON exitrecord.getter=getter.id
WHERE exitrecord.id LIKE '".$q."%'

";
$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
 
 $id = $row["exid"];       
$mydes  = $row["exdes"] ;
 
$jamkon =  $row["jamkon"];
   $gtid = $row["gtid"];
        
        $date = $row["exit_time"];
            
$array = explode(' ', $date);
list($year, $month, $day) = explode('-', $array[0]);
list($hour, $minute, $second) = explode(':', $array[1]);
$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

        
$jalali_time = jdate("H:i", $timestamp,"","Asia/Tehran","en");
$jalali_date = jdate("Y/m/d", $timestamp,"","Asia/Tehran","en");
        
        
        
        
?>


    <table class="report-table">

        <tr>
            <th>شماره فنی</th>
            <th>برند</th>
            <th>توضیحات ورود</th>
            <th>توضیحات خروج</th>
            <th>تعداد</th>

            <th>فروشنده</th>
            <th>خریدار</th>
            <th>تحویل گیرنده</th>
            <th>جمع کننده</th>
            <th>زمان خروج</th>
            <th>تاریخ خروج</th>

            <th>شماره فاکتور</th>
            <th>تاریخ فاکتور</th>

            <th>ورود به انبار</th>

            <th>انبار</th>
            <th>کاربر</th>


        </tr>










        <tr>

            <td class="cell-code "><?php echo $row["partnumber"] ?></td>
            <td class="cell-brand cell-brand-<?php echo $row["brn"] ?> "><?php echo $row["brn"] ?></td>
            <td class="cell-des "><?php echo $row["des"] ?></td>
            <td class="cell-des "><?php echo $row["exdes"] ?></td>


            <td class="cell-qty "><?php echo $row["extqty"] ?></td>

            <td class="cell-seller cell-seller-<?php echo $row["slid"] ?>"><?php echo $row["name"] ?></td>







            <td class="cell-customer "><?php echo $row["customer"] ?></td>


            <td class="cell-gtname "><?php echo $row["gtn"] ?></td>
            <td class="cell-gtname "><?php echo $row["jamkon"] ?></td>



            <td class="cell-time "><?php echo $jalali_time ?></td>
            <td class="cell-date "><?php echo $jalali_date ?></td>


            <td><?php echo $row["invoice_number"] ?></td>
            <td class="cell-date "><?php echo substr($row["invoice_date"],5) ?></td>





            <td class="tik-anb-<?php echo $row["anbarenter"] ?>"></td>
            <td class="cell-stock "><?php echo $row["stn"] ?></td>
            <td class="cell-user "><?php echo $row["usn"] ?></td>




        </tr>





    </table>








    <form id="khoroj-edit" method="get" action="khorojkala-report-edit-save.php" autocomplete="off">


        <div class="right-form">

            <input value="<?php echo $id ?>" type="hidden" name="id">

            <label for="qty">تعداد</label>
            <input value="<?php echo $row["extqty"] ?>" min="0" type="number" name="qty" id="qty">


            <label for="invoice_number">شماره فاکتور</label>
            <input value="<?php echo $row["invoice_number"] ?>" type="number" name="invoice_number" id="invoice_number">



            <label for="invoice_time">زمان فاکتور</label>
            <input value="<?php echo $row["invoice_date"] ?>" type="text" name="invoice_time" id="invoice_time">
            <span id="span_invoice_time"></span>










        </div>

        <div class="left-form">


            <label for="customer">خریدار</label>
            <input type="text" name="customer" id="customer" value="<?php echo $row["customer"] ?>">


            <label class="half-label" for="getter">تحویل گیرنده</label>
            <select class="half-input" name="getter" id="getter" data="<?php echo $gtid ?>">
                <?php include("getter-form.php") ?>
            </select>


            <label for="jamkon">جمع کننده</label>
            <input value="<?php echo $jamkon ?>" type="text" name="jamkon" id="jamkon">




            <label for="des">توضیحات</label>
            <textarea name="des" id="des"><?php echo $mydes ?></textarea>

        </div>
        <div class="bottom-bar">
            <input type="submit" value="ذخیره" id="sabt">
            <a data="<?php echo $id ?>" class="del-vorod">حذف</a>
            <div class="error"></div>
        </div>

    </form>










    <?php
    } // end while
}
else {
    echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
}
mysqli_close($con);
?>

    <script src="../js/khorojkala-edit.js?v=<?php echo (rand()) ?>"></script>
    <script src="../js/form.js?v=<?php echo (rand()) ?>"></script>
    <script src="../js/persianDatepicker.min.js?v=<?php echo (rand()) ?>"></script>

</body>

</html>
