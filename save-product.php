<?php
require "config.php";

if(isset($_POST['productName'],$_POST['price'])){
    $product_name = $_POST['productName'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $sales = $_POST['salesPrice'] ??=  $_POST['price'];
    $image_url   = null;
    
    if( isset( $_FILES['productImage'] )){
        $location = __DIR__ . '/images/' . $_FILES['productImage']['name'];
        move_uploaded_file($_FILES['productImage']['tmp_name'], $location);
        $image_url    = '/images/' . $_FILES['productImage']['name'];
    }

    $details = [
        'name'  => $product_name,
        'real_price' => $price,
        'price'     => $sales,
        'img'       => $image_url ??= ""
    ];

    $products = open_file(PRODUCT_LOC);
    $array = $products[$category];

    if( !is_array($array)){
        $array = [];
    }

    array_push($array, $details );

    $products[$category] = $array;
    $product_string = json_encode($products);

    $file = fopen(PRODUCT_LOC, "w");
    fwrite($file, $product_string );
    fclose($file);
    $url = '/create-product.php';
    header("Location: $url");
}

?>