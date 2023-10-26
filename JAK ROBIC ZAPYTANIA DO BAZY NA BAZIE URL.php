http://example.com/shop/?category=electronics&brand=apple&price_range=100-500

<?php

$whereClause = "";
$params = array();

// Check for category parameter
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $whereClause .= "category = :category AND ";
    $params[':category'] = $category;
}

if (isset($_GET['brand'])) {
    $brand = $_GET['brand'];
    $whereClause .= "brand = :brand AND ";
    $params[':brand'] = $brand;
}

if (isset($_GET['price_range'])) {
    $priceRange = explode('-', $_GET['price_range']);
    $minPrice = (float)$priceRange[0];
    $maxPrice = (float)$priceRange[1];
    $whereClause .= "price BETWEEN :minPrice AND :maxPrice AND ";
    $params[':minPrice'] = $minPrice;
    $params[':maxPrice'] = $maxPrice;
}

$whereClause = rtrim($whereClause, 'AND ');

$sql = "SELECT * FROM products";
if (!empty($whereClause)) {
    $sql .= " WHERE $whereClause";
}

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {
            // Process and display product information
        }
    } else {
        echo "No products found matching the specified criteria.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
