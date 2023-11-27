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
$sql = "SELECT qtybank.id AS qtyidsss, nisha.partnumber ,nisha.price AS nprice,seller.id AS slid, brand.name , qtybank.des ,qtybank.id, qtybank.qty , qtybank.pos1 , qtybank.pos2 , qtybank.create_time , seller.name AS sln, deliverer.name AS dn , qtybank.anbarenter ,qtybank.invoice , users.username AS un , qtybank.invoice_number,qtybank.invoice_date ,stock.name AS stn
FROM qtybank
LEFT JOIN nisha ON qtybank.codeid=nisha.id
LEFT JOIN brand ON qtybank.brand=brand.id
LEFT JOIN seller ON qtybank.seller=seller.id
LEFT JOIN deliverer ON qtybank.deliverer=deliverer.id
LEFT JOIN users ON qtybank.user=users.id
LEFT JOIN stock ON qtybank.stock_id=stock.id 
$condition
AND qtybank.is_transfered = 0
ORDER BY qtybank.create_time DESC";

$result = $conn->query($sql);

// Set the active sheet to the first sheet
$sheet = $spreadsheet->getActiveSheet();

// Set column headers
$col = 1;
foreach (range('A', 'Z') as $letter) {
    $sheet->setCellValueByColumnAndRow($col, 1, $letter);
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

// Close the database connection
$conn->close();

// Set the header for the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="excel_output.xlsx"');
header('Cache-Control: max-age=0');

// Clean the output buffer
ob_clean();

// Create Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
