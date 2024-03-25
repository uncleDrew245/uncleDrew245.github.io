<?php
require_once ("dvd.php");
require_once ("book.php");
require_once ("furniture.php");
abstract class Product
{
    protected $id;
    protected $sku;
    protected $name;
    protected $price;

    public static function connectToDatabase()
    {
        $servername = "localhost";
        $username = "admin";
        $password = "password";
        $database = "database";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die ("Connection failed: " . $conn->connect_error);
        }

        $conn->set_charset("utf8");

        return $conn;
    }

    public function __construct($id, $sku, $name, $price)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public static function fetchProducts($result)
    {
        $conn = Product::connectToDatabase();
        $sql = "SELECT * FROM `products` ORDER BY `type` ASC;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $typeAttributes = [
                'dvd' => ['size'],
                'book' => ['weight'],
                'furniture' => ['height', 'width', 'length']
            ];

            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $sku = $row["sku"];
                $name = $row["name"];
                $price = $row["price"];
                $type = $row["type"];
                $attributes = [];

                foreach ($typeAttributes[$type] as $attribute) {
                    $attributes[$attribute] = $row[$attribute];
                }

                $product = Product::getProduct($id, $type, $sku, $name, $price, $attributes);
                $product->displayDetails();
            }
        } else {
            echo "<div class='movebitch'>No products found.</div>";
        }

        $conn->close();
    }
    public function displayDetails()
    {
        echo "<div class='product-container'>";
        echo "<input type='checkbox' class='checkbox' data-id='$this->id'>";
        echo "<div class='product'>";
        echo "<p>SKU: $this->sku</p>";
        echo "<p>Name: $this->name</p>";
        echo "<p>Price: $$this->price</p>";
        $this->displayAdditionalDetails();
        echo "</div>";
        echo "</div>";
    }

    public static function createProduct($data)
    {
        $conn = Product::connectToDatabase();

        if (!isset ($data['sku']) || !isset ($data['name']) || !isset ($data['price']) || !isset ($data['type'])) {
            echo "Missing required fields";
            exit;
        }

        $className = ucfirst($data['type']);
        $reflectionClass = new ReflectionClass($className);
        $constructorParams = [];
        foreach ($reflectionClass->getConstructor()->getParameters() as $param) {
            $constructorParams[] = $data[$param->name];
        }
        $product = $reflectionClass->newInstanceArgs($constructorParams);

        if ($product !== null && $product->save()) {
            $conn->close();
        } else {
            echo "Error: Unable to add product";
            $conn->close();
        }

        return $product;
    }


    public static function getProduct($id, $type, $sku, $name, $price, $attributes = [])
    {
        $className = ucfirst($type);
        $class = new ReflectionClass($className);
        if (!$class->isSubclassOf('Product')) {
            throw new InvalidArgumentException("Invalid product type: $type");
        }

        $args = array($id, $sku, $name, $price, $type);
        $allowedAttributes = ['dvd' => ['size'], 'book' => ['weight'], 'furniture' => ['height', 'width', 'length']];

        foreach ($allowedAttributes[$type] as $attribute) {
            $args[] = $attributes[$attribute];
        }

        return $class->newInstanceArgs($args);
    }

    public static function checkSku($sku)
    {
        $conn = Product::connectToDatabase();
        $data = json_decode(file_get_contents("php://input"), true);
        $sku = $data['sku'];
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM products WHERE sku = ?");
        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $response = array();

        if ($row['count'] > 0) {
            $response['exists'] = true;
        } else {
            $response['exists'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);

        $stmt->close();
        $conn->close();
    }

    public static function deleteProducts($ids)
    {
        $conn = Product::connectToDatabase();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            $ids = $data['ids'];
            echo 'ids - ' . print_r($ids);
            $sql = "DELETE FROM products WHERE id IN (" . implode(",", $ids) . ")";
            echo 'query:' . $sql;
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error deleting products: " . $conn->error;
            }
            $conn->close();
        } else {
            header("Location: index.php");
            exit();
        }
    }
}