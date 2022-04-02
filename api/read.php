<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// initializing our api
include_once('../core/initialize.php');


// instantiate product
$product = new Product($db);

// blog product query
$result = $product->read();
// get the row count
$num = $result->rowCount();

if($num > 0){
    $product_arr = array();
    $product_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $product_item = array(
            'id'           => $id,
            'product_name' => $product_name,
            'description'  => html_entity_decode($description),
            'category_name'=> $category_name,
            'price'        => $price,
            'created_at'   => $created_at
        ); 
        array_push($product_arr['data'], $product_item);
    }
    // convert to JSON and output
    echo json_encode($product_arr);
}else{
    echo json_encode(array('message' => 'No products found.'));
}



