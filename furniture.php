<?php
require_once("product.php");
class Furniture extends Product {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $height;
    protected $width;
    protected $length;

    public function __construct($id, $sku, $name, $price, $type, $height, $width, $length) {
        parent::__construct($id, $sku, $name, $price);
        $this->type = $type;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    protected function displayAdditionalDetails() {
        echo "<p>Dimensions HxWxL: (cm): $this->height x $this->width x $this->length</p>";
    }

    public function save() {
        $conn = Product::connectToDatabase();
        $sql = "INSERT INTO products (sku, name, price, type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiii", $this->sku, $this->name, $this->price, $this->type, $this->height, $this->width, $this->length);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }
}
