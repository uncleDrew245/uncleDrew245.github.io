<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/jpeg" href="favicon.jpg">
</head>
<body>

<div class="header">
    <h1>Product List</h1>
    <div class="buttons">
        <button class="black-button" id="addButton">Add</button>
        <button class="red-button" id="delete-product-btn">Mass Delete</button>
    </div>
</div>
<div class="line-header"></div>
<div class="product-list-container">
    <div class="product-list">
    <?php
    require_once("product.php");
    Product::fetchProducts($result);
    ?>
    </div>
    <div class="centered-text">
        <div class="line-footer"></div>
        <p>Scandiweb Test Assignment</p>
    </div>
</div>

<div class="footer"></div>
<script src="index.js"></script>
</body>
</html>