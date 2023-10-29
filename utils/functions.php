<?php
require_once("utils/db.php");
function getProductByName(string $productName)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE productName = :product");
    $stmt->bindParam(':product', $productName);
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
