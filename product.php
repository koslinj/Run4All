<?php
include_once('utils/functions.php');

if (isset($_GET['productName'])) {
    $productName = urldecode($_GET['productName']);
    $product = getProductByName($productName);
    $categories = getCategoriesByProductId($product["productId"]);
    $currentPage = "RUN 4 ALL | {$productName}";
} else {
    $currentPage = "RUN 4 ALL | BŁĄD";
}

include_once('utils/template.php');
include_once('components/navbar.php');
?>
<?php if (isset($product)): ?>
    <main class="product">
        <div>
            <h1><?= $product["productName"] ?></h1>
            <img src="<?= $product["path"] ?>" alt="<?= $product["productName"] ?>" width="600px"/>
            <h2><?= $product["price"] ?> zł</h2>
            <?php foreach ($categories as $cat): ?>
                <span class="category"><?= $cat["category"] ?></span>
            <?php endforeach; ?>
        </div>
    </main>
<?php else: ?>
    <h2>Nie znaleziono produktu</h2>
<?php endif; ?>
<?php
include_once('components/footer.php');
?>
