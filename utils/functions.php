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
    $stmt = $conn->prepare("SELECT c.category FROM categories AS c JOIN products_categories AS pc ON c.categoryId = pc.categoryId WHERE pc.productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
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

function createQuery(): array
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

    $whereClause = rtrim($whereClause, 'AND ');

    $sql = "SELECT p.* FROM products as p";

    $sql .= " JOIN products_categories as pc ON p.productId = pc.productId 
JOIN categories as c ON pc.categoryId = c.categoryId
JOIN producers as pr ON pr.producerId = p.producerId";

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
