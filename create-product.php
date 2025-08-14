<!DOCTYPE html>
<html lang="en">
    <?php
        require "config.php";
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
</head>
<body>

    <header>
        <nav>
            <ul>
                <li>
                    <a href="/products.php">Shop</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="create form">
            <form action="/save-product.php" method="POST" enctype="multipart/form-data">
                <div class="form div">
                    <label for="product-name">Product Name</label>
                    <input type="text" name="productName" id="product-name" required />
                </div>
                <div class="form div">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" required />
                </div>
                <div class="form div">
                    <label for="sale-price">Sales Price</label>
                    <input type="text" name="salesPrice" id="sales-price" />
                </div>
                
                <div class="form div">
                    <label for="sale-price">Product Category</label>
                    <select name="category" id="category">
                        <?php
                            $product = open_file(PRODUCT_LOC);
                            $categories = array_keys($product);

                            foreach($categories as $category):
                        ?>
                        <option value="<?php echo $category; ?>"><?php echo $category; ?> </option>
                        <?php 
                        endforeach; 
                        ?>
                    </select>
                </div>

                <div class="form div">
                    <label for="product-image">Product Image</label>
                    <input type="file" name="productImage" id="product-image" />
                </div>
                <div class="form div">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </main>
    
</body>
</html>