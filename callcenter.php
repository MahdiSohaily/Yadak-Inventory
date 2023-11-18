<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "callcenter";

// Set the path where you want to save the backup file
$backupPath = './backup/';

try {
    // Establish database connection
    $connection = new mysqli($server, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Set the backup file name
    $backupFileName = $database . '_' . date('Y-m-d_H-i-s') . '.sql';
    $backupFilePath = $backupPath . $backupFileName;

    // Open a file handle for writing
    $fileHandle = fopen($backupFilePath, 'w');

    // Perform MySQL dump
    $result = $connection->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $table = $row[0];
        $query = "SELECT * FROM `$table`";
        $tableData = $connection->query($query);

        // Write table structure to the backup file
        fwrite($fileHandle, "DROP TABLE IF EXISTS `$table`;\n");
        $createTableQuery = $connection->query("SHOW CREATE TABLE `$table`")->fetch_row()[1];
        fwrite($fileHandle, $createTableQuery . ";\n");

        // Write table data to the backup file
        while ($row = $tableData->fetch_assoc()) {
            $values = implode("','", array_map([$connection, 'real_escape_string'], $row));
            fwrite($fileHandle, "INSERT INTO `$table` VALUES ('$values');\n");
        }
    }

    fclose($fileHandle);
    $connection->close();

    // Send appropriate headers for file download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($backupFilePath) . '"');
    header('Content-Length: ' . filesize($backupFilePath));

    // Output the file contents
    readfile($backupFilePath);

    // Delete the backup file after download (optional)
    unlink($backupFilePath);

    exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
