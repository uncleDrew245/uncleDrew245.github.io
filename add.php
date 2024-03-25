<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add</title>
    <link rel="icon" type="image/x-icon" href="favicon.jpg">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <h1>Product Add</h1>
    <div class="buttons">
        <button class="blue-button" id="save-product-btn">Save</button>
        <button class="black-button" id="cancel-btn">Cancel</button>
    </div>
</div>

<div class="line-header"></div>
<form id="product_form">
    <label for="sku">SKU:</label>
    <input type="text" class="text-field" id="sku" name="sku" required placeholder="Enter SKU (alphanumeric)"><br><br>
    
    <label for="name">Name:</label>
    <input type="text" class="text-field" id="name" name="name" required placeholder="Enter product name"><br><br>
    
    <label for="price">Price:</label>
    <input type="number" class="text-field" id="price" name="price" min="0" step="0.01" required placeholder="Enter product price"><br><br>
    
    <label for="type">Type switcher</label>
    <select id="type" class="selector" name="type" required placeholder="Select type:">
        <option value="">-blank-</option>
        <option value="dvd">DVD</option>
        <option value="book">Book</option>
        <option value="furniture">Furniture</option>
    </select><br><br>
    <div id="additional-field">
    </div>
</form>
<script src="add.js"></script>

<p id="select-paragraph">Please select the product specific type and follow instructions to successfully add it.</p>
<div class="centered-text">
    <div class="line-footer"></div>
    <p>Scandiweb Test Assignment</p>
</div>

<div class="footer"></div>
</body>
</html>
