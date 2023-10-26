<?php
require("utils/db.php");

$whereClause = "";
$params = array();

// Check for category parameter
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $whereClause .= "c.category = :category AND ";
    $params[':category'] = $category;
}

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

try {
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

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<?php
$currentPage = 'RUN 4 ALL | Buty';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="shoes">
    <nav class="left">
        <?php include_once('components/filtering.php'); ?>
    </nav>
    <div class="right">
        <h2>Buty</h2>
        <div class="list">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class='product-on-list'>
                        <a href="product.php?productName=<?= urlencode($product["productName"]) ?>">
                            <p class="product-name"><?= $product["productName"] ?></p>
                            <img src="<?= $product["path"] ?>" alt="Shoe images" width="100%"/>
                            <p><?= $product["price"] ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h3>Nie znaleziono żadnych produktów!</h3>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
include_once('components/footer.php');
?>
