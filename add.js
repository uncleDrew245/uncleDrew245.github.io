document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        document.getElementById('save-product-btn').click();
    }
});

document.getElementById('save-product-btn').addEventListener('click', function() {
    var sku = document.getElementById('sku').value.trim();
    var name = document.getElementById('name').value.trim();
    var price = parseFloat(document.getElementById('price').value);
    var type = document.getElementById('type').value;
    var errorMessage = "";

    if (!sku) {
        errorMessage += "SKU is required.\n";
    }
    if (!name) {
        errorMessage += "Name is required.\n";
    }
    if (isNaN(price) || price <= 0) {
        errorMessage += "Price is required/must be a positive number.\n";
    }
    if (!type) {
        errorMessage += "Type is required.\n";
    }

    if (type === 'book') {
        var weight = parseFloat(document.getElementById('weight').value);
        if (isNaN(weight) || weight <= 0) {
            errorMessage += "Weight is required/must be a positive number.\n";
        }
    } else if (type === 'dvd') {
        var size = parseFloat(document.getElementById('size').value);
        if (isNaN(size) || size <= 0) {
            errorMessage += "Size is required/must be a positive number.\n";
        }
    } else if (type === 'furniture') {
        var height = parseFloat(document.getElementById('height').value);
        var width = parseFloat(document.getElementById('width').value);
        var length = parseFloat(document.getElementById('length').value);
        if (isNaN(height) || height <= 0 || isNaN(width) || width <= 0 || isNaN(length) || length <= 0) {
            errorMessage += "Dimensions are required/must be positive numbers.\n";
        }
    }

    if (errorMessage !== "") {
        alert(errorMessage);
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    alert("SKU is already in use. Choose a different SKU.");
                } else {
                    saveProduct();
                }
            } else {
                alert('Error occurred while checking SKU existence.');
            }
        }
    };
    xhr.open('POST', 'check_sku.php');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({ sku: sku }));
});

function saveProduct() {
    var sku = document.getElementById('sku').value.trim();
    var name = document.getElementById('name').value.trim();
    var price = parseFloat(document.getElementById('price').value);
    var type = document.getElementById('type').value;
    var productData = {
        sku: sku,
        name: name,
        price: price,
        type: type
    };

    if (type === 'book') {
        productData.weight = parseFloat(document.getElementById('weight').value);
    } else if (type === 'dvd') {
        productData.size = parseFloat(document.getElementById('size').value);
    } else if (type === 'furniture') {
        productData.height = parseFloat(document.getElementById('height').value);
        productData.width = parseFloat(document.getElementById('width').value);
        productData.length = parseFloat(document.getElementById('length').value);
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                window.location.href = 'index.php'; 
            } else {
                alert('Error occurred while saving product.');
            }
        }
    };
    xhr.open('POST', 'process_product.php');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(productData));
}

document.getElementById('type').addEventListener('change', function() {
    var type = this.value;
    var additionalFieldDiv = document.getElementById('additional-field');
    additionalFieldDiv.innerHTML = '';

    if (type === 'book') {
        additionalFieldDiv.innerHTML = '<label for="weight">Weight:</label>' +
            '<input type="number" class="text-field" id="weight" name="weight" min="0" step="0.01" required placeholder="Enter weight of the product(kg)">' + 
            '<p>Enter the book weight in Kg.</p>';
    } else if (type === 'dvd') {
        additionalFieldDiv.innerHTML = '<label for="size">Size:</label>' +
            '<input type="number" class="text-field" id="size" name="size" min="0" step="1" required placeholder="Enter size of the product(mb)">' +
            '<p>Enter the disc space size in Mb.</p>';
    } else if (type === 'furniture') {
        additionalFieldDiv.innerHTML = '<label for="height">Height:</label>' +
            '<input type="number" class="text-field" id="height" name="height" min="0" step="0.1" required placeholder="Enter height of the product(cm)"><br><br>' +
            '<label for="width">Width:</label>' +
            '<input type="number" class="text-field" id="width" name="width" min="0" step="0.1" required placeholder="Enter width of the product(cm)"><br><br>' +
            '<label for="length">Length:</label>' +
            '<input type="number" class="text-field" id="length" name="length" min="0" step="0.1" required placeholder="Enter length of the product(cm)">' +
            '<p>Enter the product dimensions in Cm.</p>';
    }
});

document.getElementById('cancel-btn').addEventListener('click', function() {
    window.location.href = 'index.php';
});

document.getElementById('type').addEventListener('change', function() {
    var selectedType = this.value;
    var selectParagraph = document.getElementById('select-paragraph');

    if (selectedType) {
        selectParagraph.style.display = 'none'; 
    } else {
        selectParagraph.style.display = 'block'; 
    }
});