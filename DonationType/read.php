<?php

//Required headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include db and object

include_once '../config/database.php';
include_once '../objects/DonationType.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$product = new DonationType($db);

//Query products
$stmt = $product->read();
$num = $stmt->rowCount();

//Check if more than 0 record found
if($num > 0){

    //products array
    $products_arr = array();
    $products_arr["records"] = array();

    //retrieve table content
    // Difference fetch() vs fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){


        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $product_item = array(
            "donationTypeID"      =>  $donationTypeID,
            "catergory"           =>  $catergory,
            "name"                 =>  $name

        );


        array_push($products_arr["records"], $product_item);
    }

    echo json_encode($products_arr);
}else{
    echo json_encode(
        array("messege" => "No products found.")
    );
}
