<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// initializing our api
include_once('../core/initialize.php');


// instantiate product
$product = new Product($db);

$product->id = isset($_GET['id']) ? $_GET['id'] : die();
$product->read_single();

$product_arr = array(
            'id'           => $product->id,
            'product_name' => $product->product_name,
            'description'  => $product->description,
            'category_name'=> $product->category_name,
            'price'        => $product->price,
            'created_at'   => $product->created_at
);

// make a json
print_r(json_encode($product_arr));


