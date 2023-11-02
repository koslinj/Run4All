<?php
include_once('utils/functions.php');

if (isset($_GET['productName'])) {
    $productName = urldecode($_GET['productName']);
    $product = getProductByName($productName);
    $categories = getCategoriesByProductId($product["productId"]);
    $sizes = getSizesByProductId($product["productId"]);
    $producer = getProducerByProducerId($product["producerId"]);
    $currentPage = "RUN 4 ALL | {$productName}";
} else {
    $currentPage = "RUN 4 ALL | BŁĄD";
}

include_once('utils/template.php');
include_once('components/navbar.php');
?>
<?php if (isset($product)): ?>
    <main class="product">
        <div class="desc-part">
            <img src="<?= $producer["path"] ?>" alt="<?= $producer["producer"] ?>" width="100px"/>
            <h2><?= $producer["producer"] ?></h2>
            <p class="title"><?= $product["productName"] ?></p>
            <div class="categories">
                <small>Kategorie</small>
                <?php foreach ($categories as $cat): ?>
                    <a href="#" onclick="fromProductToFiltering('category', '<?= $cat["category"] ?>', '<?= $cat["type"] ?>'); return false;">
                        <?= $cat["category"] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="image-part">
            <img src="<?= $product["path"] ?>" alt="<?= $product["productName"] ?>" width="600px"/>
        </div>
        <div class="price-part">
            <p><?= $product["price"] ?> zł</p>
            <select name="size" id="size">
                <?php foreach ($sizes as $size): ?>
                    <option value="<?= $size["size"] ?>"><?= $size["size"] ?></option>
                <?php endforeach; ?>
            </select>
            <button onclick="addToCart(<?= $product['productId']; ?>)">Do koszyka</button>
        </div>
        <script src="jsActions/filtering.js"></script>
        <script src="jsActions/cart.js"></script>
    </main>
<?php else: ?>
    <h2>Nie znaleziono produktu</h2>
<?php endif; ?>
<?php
include_once('components/footer.php');
?>
