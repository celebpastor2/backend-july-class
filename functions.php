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