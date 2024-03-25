<?php
require_once("product.php");
require_once("dvd.php");
require_once("book.php");
require_once("furniture.php");

$data = json_decode(file_get_contents("php://input"), true);
$product = Product::createProduct($data);