<?php
require_once("product.php");
class Book extends Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $weight;

    public function __construct($id, $sku, $name, $price, $type, $weight) {
        parent::__construct($id, $sku, $name, $price);
        $this->type = $type;
        $this->weight = $weight;
    }

    protected function displayAdditionalDetails() {
        echo "<p>Weight (kg): $this->weight</p>";
    }

    public function save() {
        $conn = Product::connectToDatabase();
        $sql = "INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $this->sku, $this->name, $this->price, $this->type, $this->weight);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }
}
