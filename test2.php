<script src="js/jquery-1.11.3.min.js"></script>

<link rel="stylesheet" href="css/persianDatepicker.css" />


<label for="invoice_time">زمان فاکتور</label>
<input id="input1">

<script>
    $("#input1").persianDatepicker({
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
        isRTL: !1,
        calendarPosition: {
            x: 0,
            y: 0,
        },
        onShow: function() {},
        onHide: function() {},
        onSelect: function() {},
        onRender: function() {}
    });

</script>

<script src="js/persianDatepicker.min.js"></script>
