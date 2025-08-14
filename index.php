<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .menu {
            display:flex;
            width:100vw;
            justify-content: space-between;
        }
        .menu > li {
            display:block;
            cursor: pointer;
            color:black;
            text-decoration: none;
        }
        .menu > li:hover {
            border:1px solid grey;
            border-radius: 8px;
            color: white;
            background:#555;
        }

    </style>
</head>
<body>
    <ul class="menu">
    <?php
       // $date = Date(format, timestamp);
       //+ - * / 
       
        $array = ["one","two", "three", "four", "five", "six","seven", "eight", "nine", "ten"];
        $one  = array_splice($array, rand(0,10), rand(1,5) );

        $variable = function($value){
                return strlen( $value ) < 5;
        };

        $filtered_array = array_filter($array, $variable);
        foreach($filtered_array as $menu ){
            echo '<li><a href="/'.strtolower($menu) .'">'.$menu.'</a></li>';
        }
    ?>
    </ul>
    <div>
        <p>
            <form action="<?php $_SERVER['REQUEST_URI']; ?>">
                <label for="category">Category</label>
                <select name="category" id="category">
                    <option value="Electronics">Electronics</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Home Appliance">Home Appliance</option>
                </select>
                <label for="price">Price</label>
                <input type="text" name="price" id="price" />
                <button type="submit">Filter</button>               
            </form>
        </p>
        <?php 
            $category = $_GET["category"];            
            $price  = $_GET["price"];            
            $json_text = file_get_contents("products.json");
            $array      = json_decode( $json_text, true );

           /* if( isset($category)){
                $array = $array[$category];
            } */

            if( isset($price)){
                $price = floatval($price);
                $array = array_map(function($arr){
                    return $filtered = array_filter($arr, function($assoc){
                        $price = floatval($_GET["price"]);
                        $prc = floatval( str_replace( ",", "", $assoc['price'] ));
                        return strpos($assoc['name'], $price ) + 1;
                    });
                }, $array);
            }

            $assoc = [
                "key"   => "value"
            ];

            $index  = ["value", "value2"];

            foreach( $array as $category => $value ){
                $category = strtoupper( $category );
                echo '<ul>';
                echo "<li><b>Product Category: $category</b></li>";

                foreach($value as $product){
                    $slug = strtolower( str_replace(" ", "-", $product['name']) );
                    echo '
                    <li>
                        <a class="product tab" href="/'.$slug.'">
                            <div class="container image">
                            <img class="product image" src="' . $product['img'] . '" />
                            </div>
                            <div>
                                <p>'. $product['name'] .'</p>
                                <p>price: $'. $product['price'] .'</p>
                            </div>
                        </a>
                    </li>
                    ';
                }

                "</ul>";
            }


            /**
             * String Method is PHP
             * explode
             * implode
             * json_encode
             * json_decode
             * serialize - converts an array, objects or php resource to a string that can be saved in database
             * unserialize
             * 
             * MANIPULATIVE STRING FUNCTIONs
             * str_replace
             * str_ireplace
             * 
             * SEARCHING STRING
             * strpos - returns index of the first char in the str
             * strrpos - 
             */
            
        ?>
    </div>
    

    <script>
        let string = "this is a string";
        let arr = string.split()
    </script>
    
</body>
</html>