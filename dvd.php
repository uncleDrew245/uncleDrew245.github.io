<?php
require_once("product.php");
class DVD extends Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $size;

    public function __construct($id, $sku, $name, $price, $type, $size) {
        parent::__construct($id, $sku, $name, $price);
        $this->type = $type;
        $this->size = $size;
    }

    protected function displayAdditionalDetails() {
        echo "<p>Size (MB): $this->size</p>";
    }

    public function save() {
        $conn = Product::connectToDatabase();
        $sql = "INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $this->sku, $this->name, $this->price, $this->type, $this->size);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }
}