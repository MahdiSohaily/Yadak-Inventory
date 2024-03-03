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

$sanitizedData = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $finalQuantity = $row["entqty"];

        $exit_sql = " SELECT qty FROM exitrecord WHERE qtyid = '" . $row["qtyid"] . "'";

        $exitResult = $conn->query($exit_sql);

        if (mysqli_num_rows($exitResult) > 0) {
            while ($record = mysqli_fetch_assoc($exitResult)) {
                $finalQuantity =  $finalQuantity - $record["qty"];
            }
        }

        if ($finalQuantity > 0) {
            if ($row['is_transfered'] !== '1') {
                $sanitizedData[] = [
                    'partnumber' => strtoupper($row["partnumber"]),
                    'brand' => $row["brn"],
                    'quantity' => $finalQuantity,
                    'seller' => $row["name"],
                    'pos1' => $row["pos1"],
                    'pos2' => $row["pos2"],
                    'description' => $row["des"],
                    'stock' => $row["stckname"]
                ];
            }
        }
    }
}

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
foreach ($sanitizedData as $row_data) {
    $col = 1;
    foreach ($row_data as $key => $value) {
        // Set the cell format to Text for the "partnumber" column
        if ($key === 'partnumber') {
            $sheet->getCellByColumnAndRow($col, $row)->setValueExplicit($value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        } else {
            $sheet->setCellValueByColumnAndRow($col, $row, $value);
        }
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
?>
