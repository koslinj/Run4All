<?php
require("utils/functions.php");
session_start();

list($params, $sql) = createQuery('akcesoria');

$products = getProducts($params, $sql)
?>


<?php
$currentPage = 'RUN 4 ALL | Akcesoria';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="products-page">
    <nav class="left">
        <?php
        $categories = getAllCategories("akcesoria");
        $sizes = getAllSizes("akcesoria");
        include_once('components/filtering.php');
        ?>
    </nav>
    <div class="right">
        <div class="sorting-nav">
            <h2>Akcesoria</h2>
            <select id="sortDropdown">
                <option value="priceLowToHigh">Od najtańszych</option>
                <option value="priceHighToLow">Od najdroższych</option>
                <option value="nameAZ">od A do Z</option>
                <option value="nameZA">od Z do A</option>
            </select>
        </div>
        <div class="list" id="products-container">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class='product-on-list'>
                        <a href="product.php?productName=<?= urlencode($product["productName"]) ?>">
                            <img class="product-image" src="<?= $product["path"] ?>" alt="Shoe images" height="200px"/>
                            <img class="producer-image" src="<?= $product["producerPath"] ?>" alt="Producer images" width="40%"/>
                            <p class="product-name"><?= $product["productName"] ?></p>
                            <p class="product-price"><?= $product["price"] ?> zł</p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h3>Nie znaleziono żadnych produktów!</h3>
            <?php endif; ?>
        </div>
    </div>
    <script src="jsActions/sorting.js"></script>
</main>

<?php
include_once('components/footer.php');
?>


