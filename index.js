document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('delete-product-btn').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.checkbox:checked');
        console.log(checkboxes);
        var ids = Array.from(checkboxes).map(function(checkbox) {
            return checkbox.getAttribute('data-id');
        });
        console.log(ids);
        if (ids.length === 0) {
            alert('Please select products to delete.');
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    alert('Error occurred while deleting products.');
                }
            }
        };
        xhr.open('POST', 'delete_products.php');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify({ ids: ids }));
    });
});

document.getElementById('addButton').addEventListener('click', function() {
    window.location.href = 'add.php';
});