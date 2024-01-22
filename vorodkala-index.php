<?php include("./views/Layout/newHeader.php");
require_once "./utilities/helpers.php";
?>
<script src="../callcenter/report/public/js/index.js"></script>
<script src="../callcenter/report/public/js/jalaliMoment.js"></script>
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

<div class="flex justify-center px-5">
    <div class="w-1/2">
        <table class="w-full border border-1 border-gray-800">
            <thead class="bg-gray-100 border-b border-gray-800">
                <tr class="bg-gray-800">
                    <th class="p-3 text-white" colspan="8">فاکتور ورود</th>
                </tr>
                <tr>
                    <th colspan="2" class="text-right p-3 text-sm">
                        <label class="cursor-pointer" for="bill_number">شماره فاکتور</label>
                    </th>
                    <th colspan="2" class="p-3">
                        <input onkeyup="convertToEnglish(this);" onblur="setBillNumber(this.value)" class="p-2 border w-full" type="text" name="bill_number" id="bill_number">
                    </th>
                    <th colspan="2" class="text-right p-3 text-sm">
                        <label class="cursor-pointer" for="invoice_time">تاریخ</label>
                    </th>
                    <th colspan="2" class="p-3">
                        <input onchange="setFactorDate(this.value)" class="p-2 w-full h-full" type="text" name="invoice_time" id="invoice_time" value="<?php echo (jdate("Y/m/d", time(), "", "Asia/Tehran", "en")) ?>">
                        <span id="span_invoice_time"></span>
                    </th>
                </tr>
                <tr>
                    <th colspan="2" class="text-right p-3 text-sm">
                        <label class="cursor-pointer" for="seller">فروشنده</label>
                    </th>
                    <th colspan="2" class="p-3 relative">
                        <input class="p-2 border w-full" type="text" name="seller" id="seller" onkeyup="searchSellers(this.value)">
                        <div id="seller_container" style="top:85%" class="hidden absolute shadow-lg mx-3 bg-white right-0 left-0 max-h-80 p-3 rounded border  overflow-y-auto">
                            <!-- matched sellers will be appended here -->
                        </div>
                    </th>
                    <th colspan="2" class="text-right p-3 text-sm">
                        <label class="cursor-pointer" for="is_entered">وارد انبار شده؟</label>
                    </th>
                    <th colspan="2" class="p-3 text-sm">
                        <div class="flex justify-center">
                            <label class="cursor-pointer" for="is_entered_true">بلی</label>
                            <input checked onclick="setIsEntered(true)" class="p-2 w-full h-full" type="radio" name="is_entered" id="is_entered_true">
                            <label class="cursor-pointer" for="is_entered_false">خیر</label>
                            <input onclick="setIsEntered(false)" class="p-2 w-full h-full" type="radio" name="is_entered" id="is_entered_false">
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="bill_items_container" class="m-h-12">
                <tr class="bg-teal-600">
                    <td class="p-3 text-sm text-white">ردیف</td>
                    <td class="p-3 text-sm text-white">کد فنی</td>
                    <td class="p-3 text-sm text-white">اصالت</td>
                    <td class="p-3 text-sm text-white">تعداد</td>
                    <td class="p-3 text-sm text-white">قفسه</td>
                    <td class="p-3 text-sm text-white">راهرو</td>
                    <td class="p-3 text-sm text-white">توضیحات</td>
                    <td class="p-3 text-sm text-white w-16"> <img src="./public/img/settings.svg" /></td>
                </tr>
                <tr>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                </tr>
                <tr>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                    <td class="p-3"></td>
                </tr>
            </tbody>
            <tfoot class="bg-gray-100 border-t border-gray-800">
                <tr>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <label for="partNumber"> کدفنی</label>
                        <span class="text-red-500">*</span>
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold relative">
                        <input onkeyup="convertToEnglish(this);searchParts(this.value)" class="p-2 w-full" type="text" name="partNumber" id="partNumber">
                        <div id="part_container" style="top:85%" class="hidden absolute shadow-lg mx-3 bg-white right-0 left-0 max-h-80 p-3 rounded border  overflow-y-auto">
                            <!-- matched sellers will be appended here -->
                        </div>
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <label for="brand">اصالت</label>
                        <span class="text-red-500">*</span>
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold relative">
                        <input onkeyup="convertToEnglish(this);searchBrand(this.value)" class="p-2 w-full" type="text" name="brand" id="brand">
                        <div id="brand_container" style="top:85%" class="hidden absolute shadow-lg mx-3 bg-white right-0 left-0 max-h-80 p-3 rounded border  overflow-y-auto">
                            <!-- matched sellers will be appended here -->
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <label for="quantity">تعداد</label>
                        <span class="text-red-500">*</span>
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="number" min='1' name="quantity" id="quantity">
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <label for="position1">قفسه</label>
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="text" name="position1" id="position1">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <label for="position2">راهرو</label>
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <input class="p-2 w-full" type="text" name="position2" id="position2">
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <label for="description">توضیحات</label>
                    </td>
                    <td colspan="2" class="p-3 text-sm font-bold">
                        <textarea name="description" id="description" class="w-full" rows="2"></textarea>
                    </td>
                </tr>
            </tfoot>
        </table>
        <img src="./public/img/addIcon.svg" onclick="addItem()" class="w-8 h-8 cursor-pointer" alt="add item to the bill">
    </div>
</div>

<script>
    const sellerContainer = document.getElementById('seller_container');
    const part_container = document.getElementById('part_container');
    const brand_container = document.getElementById('brand_container');

    const partNumber = document.getElementById('partNumber');
    const brand = document.getElementById('brand');
    const quantity = document.getElementById('quantity');
    const position1 = document.getElementById('position1');
    const position2 = document.getElementById('position2');
    const description = document.getElementById('description');


    let factor_info = {
        seller_id: null,
        seller_name: null,
        date: moment().locale('fa').format('YYYY/MM/DD'),
        bill_number: null,
        is_entered: false
    }

    let factor_items = [{
        partNumber: '1',
        part_id: '',
        brand_id: 'brand.getAttribute()',
        brand: ' brand.value',
        quantity: 'quantity.value',
        position1: 'position1.value',
        position2: 'position2.value',
        description: 'description.value',
    }, {
        partNumber: '2',
        part_id: '',
        brand_id: 'brand.getAttribute()',
        brand: ' brand.value',
        quantity: 'quantity.value',
        position1: 'position1.value',
        position2: 'position2.value',
        description: 'description.value',
    }, {
        partNumber: '3',
        part_id: '',
        brand_id: 'brand.getAttribute()',
        brand: ' brand.value',
        quantity: 'quantity.value',
        position1: 'position1.value',
        position2: 'position2.value',
        description: 'description.value',
    }, {
        partNumber: '4',
        part_id: '',
        brand_id: 'brand.getAttribute()',
        brand: ' brand.value',
        quantity: 'quantity.value',
        position1: 'position1.value',
        position2: 'position2.value',
        description: 'description.value',
    }, {
        partNumber: '5',
        part_id: '',
        brand_id: 'brand.getAttribute()',
        brand: ' brand.value',
        quantity: 'quantity.value',
        position1: 'position1.value',
        position2: 'position2.value',
        description: 'description.value',
    }, ];

    function searchSellers(pattern = '') {

        if (pattern.length >= 3) {
            var params = new URLSearchParams();
            params.append('searchForSeller', 'searchForSeller');
            params.append('pattern', pattern);

            sellerContainer.innerHTML = '';
            sellerContainer.classList.remove('hidden');
            axios.post("./app/controller/PurchaseGoodsAjax.php", params)
                .then(function(response) {
                    const sellers = response.data;

                    for (const seller of sellers) {
                        sellerContainer.innerHTML += `
                            <div class="flex justify-between py-2 my-1 bg-gray-100 px-3" onclick=SelectSeller(this) 
                            data-id="${seller.id}"
                            data-name="${seller.name}"
                            >
                                <p class="text-xs">${seller.name}</p>
                                <img src="./public/img/addIcon.svg" />
                            </div>`;
                    }


                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            sellerContainer.classList.add('hidden');
        }
    }

    function SelectSeller(element) {
        const id = element.getAttribute('data-id');
        const name = element.getAttribute('data-name');
        document.getElementById('seller').value = name;

        factor_info.seller_id = id;
        factor_info.seller_name = name;
        sellerContainer.classList.add('hidden');
    }


    function searchParts(pattern = '') {

        if (pattern.length >= 6) {
            var params = new URLSearchParams();
            params.append('searchForPart', 'searchForPart');
            params.append('pattern', pattern);

            part_container.innerHTML = '';
            part_container.classList.remove('hidden');
            axios.post("./app/controller/PurchaseGoodsAjax.php", params)
                .then(function(response) {
                    const parts = response.data;

                    for (const part of parts) {
                        part_container.innerHTML += `
                            <div class="flex justify-between py-2 my-1 bg-gray-100 px-3 cursor-pointer" onclick=SelectPart(this) 
                            data-id="${part.id}"
                            data-name="${part.partnumber}">
                                <p class="text-xs">${part.partnumber}</p>
                                <img src="./public/img/addIcon.svg" />
                            </div>`;
                    }


                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            part_container.classList.add('hidden');
        }
    }

    function SelectPart(element) {
        const id = element.getAttribute('data-id');
        const name = element.getAttribute('data-name');
        partNumber.value = name;
        partNumber.setAttribute('data-id', id);
        part_container.classList.add('hidden');
    }

    function searchBrand(pattern) {
        if (pattern.length >= 2) {
            var params = new URLSearchParams();
            params.append('searchForBrand', 'searchForBrand');
            params.append('pattern', pattern.toUpperCase());

            brand_container.innerHTML = '';
            brand_container.classList.remove('hidden');
            axios.post("./app/controller/PurchaseGoodsAjax.php", params)
                .then(function(response) {
                    const parts = response.data;

                    for (const part of parts) {
                        brand_container.innerHTML += `
                            <div class="flex justify-between py-2 my-1 bg-gray-100 px-3 cursor-pointer" onclick=SelectBrand(this) 
                            data-id="${part.id}"
                            data-name="${part.name}">
                                <p class="text-xs">${part.name}</p>
                                <img src="./public/img/addIcon.svg" />
                            </div>`;
                    }


                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            brand_container.classList.add('hidden');
        }
    }

    function SelectBrand(element) {
        const id = element.getAttribute('data-id');
        const name = element.getAttribute('data-name');
        brand.value = name;
        brand.setAttribute('data-id', id);
        brand_container.classList.add('hidden');
    }


    $(function() {
        $("#invoice_time").persianDatepicker({
            months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
            dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
            shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
            showGregorianDate: !1,
            persianNumbers: !0,
            formatDate: "YYYY/MM/DD",
            selectedBefore: !1,
            selectedDate: null,
            startDate: null,
            endDate: null,
            prevArrow: '\u25c4',
            nextArrow: '\u25ba',
            theme: 'default',
            alwaysShow: !1,
            selectableYears: null,
            selectableMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            cellWidth: 25, // by px
            cellHeight: 20, // by px
            fontSize: 13, // by px
            isRTL: 1,
            calendarPosition: {
                x: 0,
                y: 0,
            },
            onShow: function() {},
            onHide: function() {},
            onSelect: function() {
                const date = ($("#invoice_time").val());
                factor_info.date = date;
            },
            onRender: function() {}
        });
    });

    function setBillNumber(billNumber) {
        factor_info.bill_number = billNumber;
    }

    function setIsEntered(isEntered) {
        factor_info.is_entered = isEntered;
    }

    function addItem() {
        if (partNumber.getAttribute('data-id') != null && brand.getAttribute('data-id') != null && quantity.value != '') {
            factor_items.push({
                partNumber: partNumber.value,
                part_id: partNumber.getAttribute('data-id'),
                brand_id: brand.getAttribute('data-id'),
                brand: brand.value,
                quantity: quantity.value,
                position1: position1.value,
                position2: position2.value,
                description: description.value,
            });
            partNumber.value = null;
            partNumber.setAttribute('data-id', null);
            brand.value = null;
            brand.setAttribute('data-id', null);
            quantity.value = null;;
            position1.value = null;
            position2.value = null;
            description.value = null;
            displayBill();
        } else {
            console.log('problem');
        }
    }

    function displayBill() {
        const bill_items_container = document.getElementById('bill_items_container');

        bill_items_container.innerHTML = `
                 <tr class="bg-teal-600">
                    <td class="p-3 text-sm text-white">ردیف</td>
                    <td class="p-3 text-sm text-white">کد فنی</td>
                    <td class="p-3 text-sm text-white">اصالت</td>
                    <td class="p-3 text-sm text-white">تعداد</td>
                    <td class="p-3 text-sm text-white">قفسه</td>
                    <td class="p-3 text-sm text-white">راهرو</td>
                    <td class="p-3 text-sm text-white">توضیحات</td>
                    <td class="p-3 text-sm text-white w-16"> <img src="./public/img/settings.svg" /></td>
                </tr>`;
        let counter = 1;
        for (const item of factor_items) {
            bill_items_container.innerHTML += `
                <tr class="odd:bg-blue-50 even:bg-blue-100">
                    <td class="p-3 text-sm">${counter}</td>
                    <td class="p-3 text-sm">${item.partNumber}</td>
                    <td class="p-3 text-sm">${item.brand}</td>
                    <td class="p-3 text-sm">${item.quantity}</td>
                    <td class="p-3 text-sm">${item.position1}</td>
                    <td class="p-3 text-sm">${item.position2}</td>
                    <td class="p-3 text-sm">${item.description}</td>
                    <td class="p-3 text-sm">
                        <img class="cursor-pointer" onclick=deleteItem('${counter-1}') src="./public/img/delete.svg" />
                    </td>
                </tr>`;
            counter++;
        }
    }

    function deleteItem(index) {
        if (index >= 0 && index < factor_items.length) {
            factor_items.splice(index, 1);
            displayBill();
        }
    }
    displayBill();
</script>
</div>
<?php include("./views/Layout/footer.php") ?>