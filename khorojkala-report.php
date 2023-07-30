<?php
require_once("header.php");
include("php/seller-form.php")

?>
<div>
    <div class="">
        <form id="parent" method="post" onsubmit="event.preventDefault(); filterReport(); return false" autocomplete="off">
            <div class="div1">
                <input type="text" name="partNumber" id="partNumber" placeholder="کد فنی">
            </div>

            <div class="div2">
                <select name="seller" id="seller">
                    <option selected="true" disabled="disabled">انتخاب فروشنده</option>
                    <?php
                    foreach ($data as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }

                    ?>
                </select>
            </div>

            <div class="div3">
                <select name="brand" id="brand">
                    <option selected="true" disabled="disabled">انتخاب برند جنس</option>
                    <?php include("php/brand-form.php") ?>
                </select>
            </div>

            <div class="div4">
                <input type="text" name="pos2" id="pos2" placeholder="قفسه">
            </div>

            <div class="div5">
                <input onkeydown="upperCaseF(this)" type="text" name="pos1" id="pos1" placeholder="راهرو">
            </div>

            <div class="div" 6>
                <select name="stock" id="stock">
                    <option selected="true" disabled="disabled">انتخاب انبار</option>
                    <?php include("php/stock-form.php") ?>
                </select>
            </div>

            <div class="div7">
                <select name="user" id="user">
                    <option selected="true" disabled="disabled">انتخاب کاربر</option>
                    <?php include("php/user-form.php") ?>
                </select>
            </div>

            <div class="div8">
                <input type="number" name="invoice_number" id="invoice_number" placeholder="شماره فاکتور">
            </div>

            <div class="div9">
                <input type="text" name="invoice_time" id="invoice_time" placeholder="زمان فاکتور">
            </div>
            <div class="div10">
                <input type="text" name="exit_time" id="exit_time" placeholder="زمان خروج">
            </div>
            <div>
                <input type="submit" value="فیلتر" name="submit_filter">
                <button class="exportToExcel">Export to XLS</button>
            </div>
        </form>
    </div>


    <table id="report-table" class="report-table">
        <thead>
            <tr>
                <th title="">#</th>
                <th title="شماره فنی">شماره فنی</th>
                <th title="برند">برند</th>
                <th title="توضیحات ورود">توضیحات و</th>
                <th title="توضیحات خروج">توضیحات خ</th>
                <th title="تعداد">تعداد</th>

                <th title="فروشنده">فروشنده</th>
                <th title="خریدار">خریدار</th>
                <th title="تحویل گیرنده">تحویل گیرنده</th>
                <th title="جمع کننده">جمع کننده</th>
                <th title="زمان خروج">زمان خ</th>
                <th title="تاریخ خروج">تاریخ خ</th>

                <th title="شماره فاکتور خروج">ش ف خروج</th>
                <th title="تاریخ فاکتور خروج">تاریخ ف خ</th>

                <th title="ورود به انبار">ورود به انبار</th>

                <th title="شماره فاکتور ورود">ش ف و</th>
                <th title="تاریخ فاکتور ورود">تاریخ ف و</th>
                <th title="انبار">انبار</th>
                <th title="کاربر">کاربر</th>
                <th title="عملیات">عملیات</th>
            </tr>
        </thead>
        <tbody id="resultBox">
            <?php include("php/khorojkala-report-geter.php") ?>
        </tbody>
    </table>
</div>
<script>
    /*
     *  jQuery table2excel - v1.1.2
     *  jQuery plugin to export an .xls file in browser from an HTML table
     *  https://github.com/rainabba/jquery-table2excel
     *
     *  Made by rainabba
     *  Under MIT License
     */
    //table2excel.js
    (function($, window, document, undefined) {
        var pluginName = "table2excel",

            defaults = {
                exclude: ".noExl",
                name: "Table2Excel",
                filename: "table2excel",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true,
                preserveColors: false
            };

        // The actual plugin constructor
        function Plugin(element, options) {
            this.element = element;
            // jQuery has an extend method which merges the contents of two or
            // more objects, storing the result in the first object. The first object
            // is generally empty as we don't want to alter the default options for
            // future instances of the plugin
            //
            this.settings = $.extend({}, defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype = {
            init: function() {
                var e = this;

                var utf8Heading = "<meta http-equiv=\"content-type\" content=\"application/vnd.ms-excel; charset=UTF-8\">";
                e.template = {
                    head: "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\">" + utf8Heading + "<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets>",
                    sheet: {
                        head: "<x:ExcelWorksheet><x:Name>",
                        tail: "</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>"
                    },
                    mid: "</x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>",
                    table: {
                        head: "<table>",
                        tail: "</table>"
                    },
                    foot: "</body></html>"
                };

                e.tableRows = [];

                // Styling variables
                var additionalStyles = "";
                var compStyle = null;

                // get contents of table except for exclude
                $(e.element).each(function(i, o) {
                    var tempRows = "";
                    $(o).find("tr").not(e.settings.exclude).each(function(i, p) {

                        // Reset for this row
                        additionalStyles = "";

                        // Preserve background and text colors on the row
                        if (e.settings.preserveColors) {
                            compStyle = getComputedStyle(p);
                            additionalStyles += (compStyle && compStyle.backgroundColor ? "background-color: " + compStyle.backgroundColor + ";" : "");
                            additionalStyles += (compStyle && compStyle.color ? "color: " + compStyle.color + ";" : "");
                        }

                        // Create HTML for Row
                        tempRows += "<tr style='" + additionalStyles + "'>";

                        // Loop through each TH and TD
                        $(p).find("td,th").not(e.settings.exclude).each(function(i, q) { // p did not exist, I corrected

                            // Reset for this column
                            additionalStyles = "";

                            // Preserve background and text colors on the row
                            if (e.settings.preserveColors) {
                                compStyle = getComputedStyle(q);
                                additionalStyles += (compStyle && compStyle.backgroundColor ? "background-color: " + compStyle.backgroundColor + ";" : "");
                                additionalStyles += (compStyle && compStyle.color ? "color: " + compStyle.color + ";" : "");
                            }

                            var rc = {
                                rows: $(this).attr("rowspan"),
                                cols: $(this).attr("colspan"),
                                flag: $(q).find(e.settings.exclude)
                            };

                            if (rc.flag.length > 0) {
                                tempRows += "<td> </td>"; // exclude it!!
                            } else {
                                tempRows += "<td";
                                if (rc.rows > 0) {
                                    tempRows += " rowspan='" + rc.rows + "' ";
                                }
                                if (rc.cols > 0) {
                                    tempRows += " colspan='" + rc.cols + "' ";
                                }
                                if (additionalStyles) {
                                    tempRows += " style='" + additionalStyles + "'";
                                }
                                tempRows += ">" + $(q).html() + "</td>";
                            }
                        });

                        tempRows += "</tr>";

                    });
                    // exclude img tags
                    if (e.settings.exclude_img) {
                        tempRows = exclude_img(tempRows);
                    }

                    // exclude link tags
                    if (e.settings.exclude_links) {
                        tempRows = exclude_links(tempRows);
                    }

                    // exclude input tags
                    if (e.settings.exclude_inputs) {
                        tempRows = exclude_inputs(tempRows);
                    }
                    e.tableRows.push(tempRows);
                });

                e.tableToExcel(e.tableRows, e.settings.name, e.settings.sheetName);
            },

            tableToExcel: function(table, name, sheetName) {
                var e = this,
                    fullTemplate = "",
                    i, link, a;

                e.format = function(s, c) {
                    return s.replace(/{(\w+)}/g, function(m, p) {
                        return c[p];
                    });
                };

                sheetName = typeof sheetName === "undefined" ? "Sheet" : sheetName;

                e.ctx = {
                    worksheet: name || "Worksheet",
                    table: table,
                    sheetName: sheetName
                };

                fullTemplate = e.template.head;

                if ($.isArray(table)) {
                    Object.keys(table).forEach(function(i) {
                        //fullTemplate += e.template.sheet.head + "{worksheet" + i + "}" + e.template.sheet.tail;
                        fullTemplate += e.template.sheet.head + sheetName + i + e.template.sheet.tail;
                    });
                }

                fullTemplate += e.template.mid;

                if ($.isArray(table)) {
                    Object.keys(table).forEach(function(i) {
                        fullTemplate += e.template.table.head + "{table" + i + "}" + e.template.table.tail;
                    });
                }

                fullTemplate += e.template.foot;

                for (i in table) {
                    e.ctx["table" + i] = table[i];
                }
                delete e.ctx.table;

                var isIE = navigator.appVersion.indexOf("MSIE 10") !== -1 || (navigator.userAgent.indexOf("Trident") !== -1 && navigator.userAgent.indexOf("rv:11") !== -1); // this works with IE10 and IE11 both :)
                //if (typeof msie !== "undefined" && msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // this works ONLY with IE 11!!!
                if (isIE) {
                    if (typeof Blob !== "undefined") {
                        //use blobs if we can
                        fullTemplate = e.format(fullTemplate, e.ctx); // with this, works with IE
                        fullTemplate = [fullTemplate];
                        //convert to array
                        var blob1 = new Blob(fullTemplate, {
                            type: "text/html"
                        });
                        window.navigator.msSaveBlob(blob1, getFileName(e.settings));
                    } else {
                        //otherwise use the iframe and save
                        //requires a blank iframe on page called txtArea1
                        txtArea1.document.open("text/html", "replace");
                        txtArea1.document.write(e.format(fullTemplate, e.ctx));
                        txtArea1.document.close();
                        txtArea1.focus();
                        sa = txtArea1.document.execCommand("SaveAs", true, getFileName(e.settings));
                    }

                } else {
                    var blob = new Blob([e.format(fullTemplate, e.ctx)], {
                        type: "application/vnd.ms-excel"
                    });
                    window.URL = window.URL || window.webkitURL;
                    link = window.URL.createObjectURL(blob);
                    a = document.createElement("a");
                    a.download = getFileName(e.settings);
                    a.href = link;

                    document.body.appendChild(a);

                    a.click();

                    document.body.removeChild(a);
                }

                return true;
            }
        };

        function getFileName(settings) {
            return (settings.filename ? settings.filename : "table2excel");
        }

        // Removes all img tags
        function exclude_img(string) {
            var _patt = /(\s+alt\s*=\s*"([^"]*)"|\s+alt\s*=\s*'([^']*)')/i;
            return string.replace(/<img[^>]*>/gi, function myFunction(x) {
                var res = _patt.exec(x);
                if (res !== null && res.length >= 2) {
                    return res[2];
                } else {
                    return "";
                }
            });
        }

        // Removes all link tags
        function exclude_links(string) {
            return string.replace(/<a[^>]*>|<\/a>/gi, "");
        }

        // Removes input params
        function exclude_inputs(string) {
            var _patt = /(\s+value\s*=\s*"([^"]*)"|\s+value\s*=\s*'([^']*)')/i;
            return string.replace(/<input[^>]*>|<\/input>/gi, function myFunction(x) {
                var res = _patt.exec(x);
                if (res !== null && res.length >= 2) {
                    return res[2];
                } else {
                    return "";
                }
            });
        }

        $.fn[pluginName] = function(options) {
            var e = this;
            e.each(function() {
                if (!$.data(e, "plugin_" + pluginName)) {
                    $.data(e, "plugin_" + pluginName, new Plugin(this, options));
                }
            });

            // chain jQuery functions
            return e;
        };

    })(jQuery, window, document);
</script>

<script>
    $(function() {
        $(".exportToExcel").click(function(e) {
            var table = $('#report-table');
            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Exit Report",
                    filename: "Exit Report " + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });
</script>
<div id="updateModal">
    <div class="modalContent">
        <div class="modalHeader">
            <h2>ویرایش فاکتور خروجی</h2>
            <i onclick="closeModal()" class="fa fa-times closeModal" aria-hidden="true"></i>
        </div>
        <iframe id="updateModalIframe" width="1400" height="500" src="./php/khorojkala-report-edit.php" frameborder="0"></iframe>
    </div>

</div>

<script>
    const updateModal = document.getElementById('updateModal');

    function filterReport() {
        const partNumber = document.getElementById('partNumber').value === '' ? null : document.getElementById('partNumber').value;
        const seller = document.getElementById('seller').value === 'انتخاب فروشنده' ? null : document.getElementById('seller').value;
        const brand = document.getElementById('brand').value === 'انتخاب برند جنس' ? null : document.getElementById('brand').value;
        const pos1 = document.getElementById('pos1').value === '' ? null : document.getElementById('pos1').value;
        const pos2 = document.getElementById('pos2').value === '' ? null : document.getElementById('pos2').value;
        const stock = document.getElementById('stock').value === 'انتخاب انبار' ? null : document.getElementById('stock').value;
        const user = document.getElementById('user').value === 'انتخاب کاربر' ? null : document.getElementById('user').value;
        const invoice_number = document.getElementById('invoice_number').value === '' ? null : document.getElementById('invoice_number').value;
        const invoice_time = document.getElementById('invoice_time').value === '' ? null : document.getElementById('invoice_time').value;
        const exit_time = document.getElementById('exit_time').value === '' ? null : document.getElementById('exit_time').value;


        var params = new URLSearchParams();
        params.append('submit_filter', 'submit_filter');
        params.append('partNumber', partNumber);
        params.append('seller', seller);
        params.append('brand', brand);
        params.append('pos1', pos1);
        params.append('pos2', pos2);
        params.append('stock', stock);
        params.append('user', user);
        params.append('invoice_number', invoice_number);
        params.append('invoice_time', invoice_time);
        params.append('exit_time', exit_time);

        const resultBox = document.getElementById('resultBox');
        axios.post("./khorojkala-report-ajax.php", params)
            .then(function(response) {
                console.log(response.data);
                resultBox.innerHTML = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    function displayModal(element) {
        id = element.getAttribute('id');
        updateModal.style.display = 'flex';
        updateModalIframe.src = './php/khorojkala-report-edit.php?q=' + id;
    }

    function closeModal() {
        updateModal.style.display = 'none';
    }
    var modal = document.getElementById("updateModal");
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<?php include("footer.php") ?>