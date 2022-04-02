<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access_Control_Allow_Methods: POST');
header('Access_Control_Allow_Headers: Access_Control_Allow_Headers, Content-Type, Access_Control_Allow_Methods, Authorization, X-Requested_With');

// initializing our api
include_once('../core/initialize.php');


// instantiate product
$product = new Product($db);

// get raw posted data
$data = json_decode(file_get_contents("php://input"));

$product->product_name  = $data->product_name;
$product->category_name = $data->category_name;  
$product->description   = $data->description;   
$product->price         = $data->price;        

// create product
if($product->create()){
    echo json_encode(
        array('message' => 'Product created.')
    );
}else{
    echo json_encode(
        array('message' => 'Product not created.')
    );
}