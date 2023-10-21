<?php include("header.php");
?>


<style>
    .right-form td {
        padding: 10px !important;
    }

    .right-form td:first-child {
        width: 150px !important;
    }

    .right-form select {
        display: block !important;
    }

    .right-form input {
        padding: 10px !important;
        margin: 0 !important;
        float: none !important;
    }

    .right-form input[type=radio] {
        width: auto !important;
    }

    .right-form textarea {
        float: none !important;
    }

    .right-form li span {
        padding-inline: 10px;
    }

    .right-form label {
        width: auto !important;
        float: none !important;
        cursor: pointer;
    }

    .right-form .factor_details {
        opacity: 0;
        transition: opacity 0.5s;
    }
</style>

<div id="Enter-Page">
    <div>
        <form id="vorodkala" method="post" action="php/vorodkala-save.php" autocomplete="off">
            <div class="left-form">
                <?php include("php/codeid.php") ?>

            </div>
            <div class="right-form">
                <input type="hidden" name="brand-box" id="brand-box">
                <table style="width: 100% !important;">
                    <tbody>
                        <tr>
                            <td>
                                <p for="brand">اصالت</p>
                            </td>
                            <td>
                                <select name="brand" id="esalat">
                                    <?php include("php/brand-form.php") ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>فروشنده</p>
                            </td>
                            <td>
                                <select name="seller" id="seller">
                                    <?php include("php/seller-form.php");
                                    foreach ($data as $key => $value) {
                                        echo "<option value='$key'>$value</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                تحویل دهنده
                            </td>
                            <td>
                                <select name="deliverer" id="deliverer">
                                    <?php include("php/deliverer-form.php") ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>تعداد</p>
                            </td>
                            <td>
                                <input required min="0" type="number" name="qty" id="qty">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    قفسه
                                </p>
                            </td>
                            <td>
                                <input onkeydown="upperCaseF(this)" type="text" name="pos2" id="pos2">
                            </td>
                        </tr>
                        <tr>
                            <td>راهرو</td>
                            <td>
                                <input onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1">
                            </td>
                        </tr>
                        <tr>
                            <td>انبار</td>
                            <td>
                                <select name="stock" id="stock">
                                    <?php include("php/stock-form.php") ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">

                                توضیحات
                            </td>
                            <td>
                                <textarea name="des" id="des"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>آیا فاکتور دارد ؟</p>
                            </td>
                            <td>
                                <ul>
                                    <br>
                                    <li style="margin-bottom: 10px;">
                                        <label for="invoice">
                                            <input type="radio" name="invoice" data-name="yes" id="invoice" value="1" onchange="displayCheck(this)" checked>
                                            بله
                                        </label>
                                    </li>
                                    <li style="margin-bottom: 10px;">
                                        <label for="invoiceNO">
                                            <input type="radio" name="invoice" data-name="no" id="invoiceNO" value="0" onchange="displayCheck(this)">
                                            خیر
                                        </label>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr class="factor_details">
                            <td>
                                <p>شماره فاکتور</p>
                            </td>
                            <td>
                                <input type="number" name="invoice_number" id="invoice_number">
                            </td>
                        </tr>
                        <tr class="factor_details">
                            <td>
                                <p>زمان فاکتور</p>
                            </td>
                            <td>
                                <input value="<?php echo (jdate("Y/m/d", time(), "", "Asia/Tehran", "en")) ?>" type="text" name="invoice_time" id="invoice_time">
                                <span id="span_invoice_time"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>آیا وارد انبار شده ؟</p>
                            </td>
                            <td>
                                <ul>
                                    <li style="margin-bottom: 10px;">
                                        <label for="anbarenter">
                                            <input type="radio" name="anbarenter" id="anbarenter" value="0">
                                            خیر
                                        </label>
                                    </li>
                                    <li style="margin-bottom: 10px;">
                                        <label for="anbarenterNo">
                                            <input type="radio" name="anbarenter" id="anbarenterNo" value="1" checked>
                                            بله
                                        </label>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>



            </div>

            <div class="bottom-bar">
                <input type="submit" value="ذخیره" id="sabt">
                <div class="error">
                </div>
            </div>
    </div>
    </form>
</div>

<script>
    // Get the radio buttons by their name attribute
    const invoiceRadioButtons = document.querySelectorAll('input[name="invoice"]');

    // Get the factor_details rows
    const factorDetailsRows = document.querySelectorAll('.factor_details');


    const invoice_time = document.getElementById("invoice_time");

    // Function to toggle the visibility and opacity of factor_details rows
    function toggleFactorDetailsVisibility(show) {
        factorDetailsRows.forEach(function(row) {
            if (show) {
                row.style.display = 'table-row';
                setTimeout(function() {
                    row.style.opacity = 1;
                }, 10);
            } else {
                row.style.opacity = 0;
                setTimeout(function() {
                    row.style.display = 'none';
                    invoice_time.value = null;
                }, 500); // Adjust the duration as needed
            }
        });
    }

    // Initial check and setup based on the radio button's checked status
    toggleFactorDetailsVisibility(invoiceRadioButtons[0].checked);

    // Add change event listener to the radio buttons
    invoiceRadioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            var isChecked = radio.dataset.name === 'yes';
            toggleFactorDetailsVisibility(isChecked);
        });
    });
    $(document).ready(function() {
        $('#seller').select2({
            matcher: function matchCustom(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                if (data.text.indexOf(params.term.toUpperCase()) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.text += '';

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });
        $('#esalat').select2({
            matcher: function matchCustom(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                if (data.text.indexOf(params.term.toUpperCase()) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.text += '';

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });
        $('#deliverer').select2({
            matcher: function matchCustom(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                if (data.text.indexOf(params.term.toUpperCase()) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.text += '';

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });
        $('#stock').select2({
            matcher: function matchCustom(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                if (data.text.indexOf(params.term.toUpperCase()) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.text += '';

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });
    });
</script>





</div>


<?php include("footer.php") ?>