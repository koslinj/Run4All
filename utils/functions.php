<?php
require_once("db.php");
function getProductByName(string $productName)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE productName = :product");
    $stmt->bindParam(':product', $productName);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $product[0];
}

function getProductByProductId(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $product[0];
}

function getCategoriesByProductId(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT c.category, c.type FROM categories AS c JOIN products_categories AS pc ON c.categoryId = pc.categoryId WHERE pc.productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

function getSizesByProductId(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT size FROM sizes WHERE productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sizes;
}

function getProducerByProducerId(int $producerId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM producers WHERE producerId = :id");
    $stmt->bindParam(':id', $producerId);
    $stmt->execute();
    $prooducers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $prooducers[0];
}

function getUserByUserId(int $userId)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users[0];
}

function getAddressesByUserId(int $userId)
{
    global $conn;
    $sql = "SELECT * FROM addresses WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $addresses;
}

function createQuery($type): array
{
    $whereClause = "";
    $params = array();

    // Check for category parameter
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $whereClause .= "c.category = :category AND ";
        $params[':category'] = $category;
    }

    // Check for producer parameter
    if (isset($_GET['producer'])) {
        $producer = $_GET['producer'];
        $whereClause .= "pr.producer = :producer AND ";
        $params[':producer'] = $producer;
    }

    // Check for size parameter
    if (isset($_GET['size'])) {
        $size = $_GET['size'];
        $whereClause .= "s.size = :size AND ";
        $params[':size'] = $size;
    }

    $whereClause .= "c.type = :type AND ";
    $params[':type'] = $type;

    $whereClause = rtrim($whereClause, 'AND ');

    $sql = "SELECT p.*, pr.path as producerPath FROM products as p";

    $sql .= " JOIN products_categories as pc ON p.productId = pc.productId 
JOIN categories as c ON pc.categoryId = c.categoryId
JOIN producers as pr ON pr.producerId = p.producerId
JOIN sizes as s ON s.productId = p.productId";

    if (!empty($whereClause)) {
        $sql .= " WHERE $whereClause";
    }
    return array($params, $sql);
}

function getProducts($params, $sql)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $originalArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $uniqueProductIds = [];
    $products = [];

    foreach ($originalArray as $item) {
        $productId = $item['productId'];

        // Check if the product ID is not already in the list of unique product IDs
        if (!in_array($productId, $uniqueProductIds)) {
            $products[] = $item; // Add the item to the filtered array
            $uniqueProductIds[] = $productId; // Add the product ID to the list of unique IDs
        }
    }
    return $products;
}

function getCartByUserId(int $userId)
{
    global $conn;
    $sql = "SELECT p.productId, p.productName, p.price, p.path, c.quantity, c.size
            FROM carts as c JOIN products p on p.productId = c.productId 
            WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $cart;
}

function clearCartInDb(int $userId)
{
    global $conn;
    $sql = "DELETE FROM carts WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
}

function saveCartFromSession($cart, int $userId)
{
    global $conn;
    $sql = "DELETE FROM carts WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    foreach ($cart as $product){
        $sql = "INSERT INTO carts(userId, productId, quantity, size) VALUES(:userId, :productId, :quantity, :size)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':productId', $product["productId"]);
        $stmt->bindParam(':quantity', $product["quantity"]);
        $stmt->bindParam(':size', $product["size"]);
        $stmt->execute();
    }
}

function updateAddress(int $addressId, $town, $street, $number)
{
    global $conn;
    $sql = "UPDATE addresses SET town = :town, street = :street, number = :number WHERE addressId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $addressId);
    $stmt->bindParam(':town', $town);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':number', $number);
    $stmt->execute();
}

function getAllCategories($type)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM categories WHERE type = :type");
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

function getAllProducers()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM producers");
    $stmt->execute();
    $producers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $producers;
}

function getAllSizes($type)
{
    global $conn;
    $stmt = $conn->prepare("SELECT DISTINCT size FROM sizes WHERE type = :type ORDER BY size");
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sizes;
}

function getAllDeliverers()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM deliverers");
    $stmt->execute();
    $deliverers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $deliverers;
}

function getAllPayments()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM payments");
    $stmt->execute();
    $deliverers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $deliverers;
}
