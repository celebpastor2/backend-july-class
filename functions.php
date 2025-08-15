<?php

function open_file($filename, $mode = 'r', $is_parse = true){
     $file = fopen($filename, $mode);
    $content = fread($file, filesize($filename));
    fclose($file);
    if( $is_parse ){
        $content = json_decode($content, true);
    }
    return $content;
}


function get_products(){
    $file = fopen(PRODUCT_LOC, "r");
    $content = fread( $file, filesize(PRODUCT_LOC));

    $products = json_decode($content, true);//CONVERTS S STRING (JSON) INTO AN ASSOCIATIVE ARRAY OR A OBJECT
    $keys       = array_keys($products);
    $arrays     = [];

    foreach( $keys as $key){
        array_push($arrays, $products[$key]);
    }
    $final_products = array_merge(...$arrays);

    if( count( $final_products ) == 0 ) return false;
    
    return $final_products;
}