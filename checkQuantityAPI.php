<?php
require_once './config/db_connect.php';

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow specified HTTP methods
header("Access-Control-Allow-Methods:POST");

// Allow specified headers
header("Access-Control-Allow-Headers: Content-Type");

// Allow credentials (cookies, authorization headers, etc.)
header("Access-Control-Allow-Credentials: true");

// Set content type to JSON
header("Content-Type: application/json"); // Allow requests from any origin

if (isset($_POST['code'])) {

    try {
        // remove all the special characters from the user input
        $code = htmlspecialchars($_POST['code']);

        $existingGoods = getExistingGoods($code);

        $existingGoods = array_map(function ($record) {

            $record['entqty'] = getSanitizedData($record["entqty"], $record["qtyid"]);
            return $record;
        }, $existingGoods);


        $existingGoods = array_filter($existingGoods, function ($record) {
            if ($record["entqty"] > 0)
                return $record;
        });

        if (!empty($existingGoods)) {
            // Assuming everything went well
            $response = [
                'success' => true,
                'message' => 'Form data received successfully.',
                'data' => $existingGoods,
            ];
            // Send the JSON response
            echo json_encode($response);
        }
    } catch (\Throwable $th) {
        throw $th;
    }
} else {
    echo "not ajax request";
}


function echoRial($x, $y)
{
    if (!empty($x)) {
        if ($y == "GEN") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3) * 10000), 0);
        }
        if ($y == "MOB") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3 * 0.9) * 10000), 0);
        }
        if ($y != "GEN" && $y != "MOB") {
            return number_format((round($x * 100 / 243.5 * 1.2 * 26 * 1.3 * 0.5) * 10000), 0);
        }
    }
}

function getExistingGoods($pattern)
{
    $statement = DB_CONNECTION->prepare("SELECT nisha.partnumber , nisha.id,stock.name AS stckname ,nisha.price AS nprice,
                seller.name , brand.name AS brn , qtybank.qty,qtybank.pos1,qtybank.pos2 ,qtybank.des,qtybank.id AS qtyid,
                qtybank.qty AS entqty, qtybank.is_transfered
    FROM qtybank
    LEFT JOIN nisha ON qtybank.codeid=nisha.id
    LEFT JOIN seller ON qtybank.seller=seller.id
    LEFT JOIN brand ON qtybank.brand=brand.id
    LEFT JOIN stock ON qtybank.stock_id=stock.id
    WHERE nisha.partnumber LIKE :pattern
    ORDER BY nisha.partnumber DESC");

    $code = $pattern . '%';

    $statement->bindParam(":pattern", $code);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    return $statement->fetchAll();
}

function getSanitizedData($quantity, $id)
{
    $statement = DB_CONNECTION->prepare("SELECT qty FROM exitrecord WHERE qtyid = :id");

    $statement->bindParam(":id", $id);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    $allExit =  $statement->fetchAll();

    foreach ($allExit as $record) {
        $quantity -= $record["qty"];
    }
    return $quantity;
}
