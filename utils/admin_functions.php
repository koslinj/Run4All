<?php
require_once("db.php");
function getAllProductsAdmin()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $products;
}

function getAllProducersAdmin()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM producers");
    $stmt->execute();
    $producers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $producers;
}

function insertProductImageAdmin($id, $name, $price, $path)
{
    global $conn;
    $sql = "INSERT INTO products(producerId, productName, price, path) VALUES(:id, :name, :price, :path)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':path', $path);
    $stmt->execute();
}

function deleteProductAdmin($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM products WHERE productId = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function getSizesByProductIdAdmin(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT size FROM sizes WHERE productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sizes;
}
