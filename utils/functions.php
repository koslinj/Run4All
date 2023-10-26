<?php
function getProductByName(string $productName)
{
    require("utils/db.php");
    $stmt = $conn->prepare("SELECT * FROM products WHERE productName = ?");
    $stmt->bindParam(1, $productName, PDO::PARAM_STR);
    $stmt->execute();
    $product = $stmt->fetchAll();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $product[0];
}

function getCategoriesByProductId(int $productId)
{
    require("utils/db.php");
    $stmt = $conn->prepare("SELECT c.category FROM categories AS c JOIN products_categories AS pc ON c.categoryId = pc.categoryId WHERE pc.productId = ?");
    $stmt->bindParam(1, $productId, PDO::PARAM_INT);
    $stmt->execute();
    $categories = $stmt->fetchAll();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $categories;
}

