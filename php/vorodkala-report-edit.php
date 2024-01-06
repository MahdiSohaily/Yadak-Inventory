<!DOCTYPE html>
<html style="margin-top:0">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='../css/style.css?v=<?php echo (rand()) ?>' type='text/css' media='all' />
    <link type="text/css" rel="stylesheet" href="../css/persianDatepicker.css" />

    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
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

<body>
    <?php
    $q = $_GET['q'];
    require_once("db.php");

    $sql = "SELECT qtybank.id AS qtybankID, nisha.partnumber ,brand.id AS brnid, brand.name ,
            qtybank.des , qtybank.qty , qtybank.id , qtybank.pos1 ,
            qtybank.invoice_date, qtybank.pos2 , qtybank.create_time ,
            seller.name AS sln, 
            seller.id AS slid, 
            deliverer.name AS dn ,deliverer.id AS dlid,
            qtybank.anbarenter ,qtybank.invoice , users.username AS un ,
            qtybank.invoice_number ,stock.name AS stn,stock.id AS stid
            FROM qtybank
            LEFT JOIN nisha ON qtybank.codeid=nisha.id
            LEFT JOIN brand ON qtybank.brand=brand.id
            LEFT JOIN seller ON qtybank.seller=seller.id
            LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
            LEFT JOIN users ON qtybank.user=users.id
            LEFT JOIN stock ON qtybank.stock_id=stock.id
            WHERE qtybank.id = '" . $q . "%'";

    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $qtybankID = $row["qtybankID"];
            $mydes  = $row["des"];
            $brnid  = $row["brnid"];
            $stid  = $row["stid"];
            $dlid  = $row["dlid"];
            $date = $row["create_time"];

            $array = explode(' ', $date);
            list($year, $month, $day) = explode('-', $array[0]);
            list($hour, $minute, $second) = explode(':', $array[1]);
            $timestamp = mktime($hour, $minute, $second, $month, $day, $year);

            $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
            $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");


            $seller_id = $row["slid"];
    ?>
            <table class="report-table">
                <tr>
                    <th>شماره فنی</th>
                    <th>برند</th>
                    <th>توضیحات</th>
                    <th>تعداد</th>
                    <th>راهرو</th>
                    <th>قفسه</th>
                    <th>فروشنده</th>
                    <th>زمان ورود</th>
                    <th>تاریخ ورود</th>
                    <th>تحویل دهنده</th>
                    <th>فاکتور</th>
                    <th>شماره فاکتور</th>
                    <th>تاریخ فاکتور</th>
                    <th>ورود به انبار</th>
                    <th>انبار</th>
                    <th>کاربر</th>
                </tr>
                <tr>
                    <td class="cell-code "><?php echo $row["partnumber"] ?></td>
                    <td class="cell-brand cell-brand-<?php echo $row["name"] ?> "><?php echo $row["name"] ?></td>
                    <td class="cell-des "><?php echo $row["des"] ?></td>
                    <td class="cell-qty "><?php echo $row["qty"] ?></td>
                    <td class="cell-pos1 "><?php echo $row["pos1"] ?></td>
                    <td class="cell-pos2 "><?php echo $row["pos2"] ?></td>
                    <td class="cell-seller cell-seller-<?php echo $seller_id; ?>"><?php echo $row["sln"] ?></td>
                    <td class="cell-time "><?php echo $jalali_time ?></td>
                    <td class="cell-date "><?php echo $jalali_date ?></td>

                    <td class="cell-dlname "><?php echo $row["dn"] ?></td>
                    <td class="tik-inv-<?php echo $row["invoice"] ?>"></td>
                    <td><?php echo $row["invoice_number"] ?></td>
                    <td class="cell-date "><?php echo substr($row["invoice_date"], 5) ?></td>

                    <td class="tik-anb-<?php echo $row["anbarenter"] ?>"></td>

                    <td class="cell-stock "><?php echo $row["stn"] ?></td>
                    <td class="cell-user "><?php echo $row["un"] ?></td>
                </tr>
            </table>

            <form id="vorod-edit" method="get" action="vorodkala-report-edit-save.php" autocomplete="off">


                <div class="right-form">

                    <input value="<?php echo $qtybankID ?>" type="hidden" name="id">

                    <label for="qty">تعداد</label>
                    <input value="<?php echo $row["qty"] ?>" min="0" type="number" name="qty" id="qty">

                    <label for="pos1">راهرو</label>
                    <input value="<?php echo $row["pos1"] ?>" onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1">

                    <label for="pos2">قفسه</label>
                    <input value="<?php echo $row["pos2"] ?>" onkeydown="upperCaseF(this)" type="text" name="pos2" id="pos2">

                    <label for="invoice_number">شماره فاکتور</label>
                    <input value="<?php echo $row["invoice_number"] ?>" type="number" name="invoice_number" id="invoice_number">

                    <label for="invoice_time">زمان فاکتور</label>
                    <input value="<?php echo $row["invoice_date"] ?>" type="text" name="invoice_time" id="invoice_time">
                    <span id="span_invoice_time"></span>
                    <fieldset>
                        <legend>آیا فاکتور دارد ؟</legend>
                        <label for="invoice">خیر</label>
                        <input type="radio" name="invoice" id="invoice" value="0" <?php if ($row["invoice"] == 0) {
                                                                                        echo "checked";
                                                                                    } ?>>
                        <label for="nvoice">بله</label>
                        <input type="radio" name="invoice" id="invoice" value="1" <?php if ($row["invoice"] == 1) {
                                                                                        echo "checked";
                                                                                    } ?>>
                    </fieldset>
                    <fieldset>
                        <legend>آیا وارد انبار شده ؟</legend>

                        <label for="anbarenter">خیر</label>
                        <input type="radio" name="anbarenter" id="anbarenter" value="0" <?php if ($row["anbarenter"] == 0) {
                                                                                            echo "checked";
                                                                                        } ?>>

                        <label for="anbarenter">بله</label>
                        <input type="radio" name="anbarenter" id="anbarenter" value="1" <?php if ($row["anbarenter"] == 1) {
                                                                                            echo "checked";
                                                                                        } ?>>

                    </fieldset>
                </div>

                <div class="left-form">

                    <label for="brand">اصالت</label>
                    <select name="brand" id="esalat" data="<?php echo $brnid ?>">
                        <?php include("brand-form.php") ?>
                    </select>
                    <label>فروشنده</label>
                    <select name="seller" id="seller">
                        <?php include("./seller-form.php");
                        foreach ($data as $key => $value) :
                        ?>
                            <option <?= ($key == $seller_id) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="stock">انبار</label>
                    <select name="stock" id="stock" data="<?php echo $stid ?>">
                        <?php include("stock-form.php") ?>
                    </select>

                    <label for="deliverer">تحویل دهنده</label>
                    <select name="deliverer" id="deliverer" data="<?php echo $dlid ?>">
                        <?php include("deliverer-form.php") ?>
                    </select>

                    <label for="des">توضیحات</label>
                    <textarea name="des" id="des"><?php echo $mydes ?></textarea>

                </div>
                <div class="-bar">
                    <input type="submit" value="ذخیره" id="sabt">
                    <a data="<?php echo $qtybankID ?>" class="del-vorod"> حذف</a>
                    <div class="error"></div>
                </div>

            </form>
    <?php
        } // end while
    } else {
        echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
    }
    mysqli_close($con);
    ?>

    <script src="../js/vorodkala-edit.js?v=<?php echo (rand()) ?>"></script>
    <script src="../js/form.js?v=<?php echo (rand()) ?>"></script>
    <script src="../js/persianDatepicker.min.js?v=<?php echo (rand()) ?>"></script>
</body>

</html>