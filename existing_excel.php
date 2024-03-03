<?php

require 'vendor/autoload.php'; // Include the Composer autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yadakshop1402";

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data from the database
$sql = "SELECT nisha.partnumber , nisha.id, qtybank.id as qid ,stock.name AS stckname ,nisha.price AS nprice,
seller.name , brand.name AS brn , qtybank.qty,qtybank.pos1,qtybank.pos2 ,
qtybank.des,qtybank.id AS qtyid,  qtybank.qty AS entqty, qtybank.is_transfered
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
LEFT JOIN seller ON qtybank.seller = seller.id
LEFT JOIN brand ON qtybank.brand = brand.id
LEFT JOIN stock ON qtybank.stock_id = stock.id
ORDER BY nisha.partnumber DESC";

$result = $conn->query($sql);

// Set the active sheet to the first sheet
$sheet = $spreadsheet->getActiveSheet();

// Set custom column headers
$customHeaders = [
    'شماره فنی', 'برند', 'تعداد', 'فروشنده', 'راهرو', 'قفسه', 'توضیحات', 'انبار'
];

$col = 1;
foreach ($customHeaders as $header) {
    $sheet->setCellValueByColumnAndRow($col, 1, $header);
    $col++;
}

// Set data from the database query result
$row = 2;
while ($row_data = $result->fetch_assoc()) {
    $col = 1;
    foreach ($row_data as $value) {
        $sheet->setCellValueByColumnAndRow($col, $row, $value);
        $col++;
    }
    $row++;
}

// Freeze the header row
$sheet->freezePane('A2');

// Close the database connection
$conn->close();

// Set the header for the Excel file with today's date and time
$timestamp = date('Y-m-d');
$filename = "existing_goods_report_{$timestamp}.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0');

// Clean the output buffer
ob_clean();

// Create Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
