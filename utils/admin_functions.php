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

function getAllColorsAdmin()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM colors");
    $stmt->execute();
    $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $colors;
}

function getAllOrdersAdmin()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $orders;
}

function getAllStatusesAdmin()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM statuses");
    $stmt->execute();
    $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $statuses;
}

function updateStatusAdmin($status, $id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE orderId = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function insertProductAdmin($id, $name, $price, $path)
{
    global $conn;
    $sql = "INSERT INTO products(producerId, productName, price, path) VALUES(:id, :name, :price, :path)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':path', $path);
    $stmt->execute();
    return $conn->lastInsertId();
}

function insertSizesAdmin($id, $sizes, $type)
{
    global $conn;
    foreach ($sizes as $size) {
        $sql = "INSERT INTO sizes(productId, size, type) VALUES(:id, :size, :type)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
    }
}

function insertOneSizeAdmin($id, $size, $type)
{
    global $conn;
    $sql = "INSERT INTO sizes(productId, size, type) VALUES(:id, :size, :type)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':size', $size);
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    return $conn->lastInsertId();
}

function insertColorsAdmin($colors, $product)
{
    global $conn;
    foreach ($colors as $color) {
        $sql = "INSERT INTO products_colors(colorId, productId) VALUES(:color, :product)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':product', $product);
        $stmt->execute();
    }
}

function insertCategoryAdmin($category, $product)
{
    global $conn;
    $sql = "INSERT INTO products_categories(categoryId, productId) VALUES(:category, :product)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':product', $product);
    $stmt->execute();
}

function deleteProductAdmin($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM products WHERE productId = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deleteSizeAdmin($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM sizes WHERE sizeId = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function getSizesByProductIdAdmin(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM sizes WHERE productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sizes;
}

function getTypeByProductIdAdmin(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT type FROM sizes WHERE productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sizes[0]["type"];
}

function getCategoriesByTypeAdmin($type)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM categories WHERE type = :type");
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}