<?php
$id         = (int) $_GET['id'];
$product    = new Books($id);

$url =  "/products.php";
if(! isset($_GET['id']) || ! $product ){
    header("Location:$url");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name'];?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="flex">
        <div class="product-image-comtainer">
            <img src="<?= $product['img']; ?>" alt="<?= $product['name']; ?> Image" class="productImage" >
        </div>
        <div class="product-info">
            <div class="product name">
                <span><?= $product['name'];?></span>
            </div>
            <div class="product price">
                <p><span><?= $product['price'];?></span></p>
                <p><del><?= $product['real_price'];?></del></p>
            </div>
        </div>
    </main>
</body>
</html>