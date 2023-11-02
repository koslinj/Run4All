<?php
require("utils/functions.php");

list($params, $sql) = createQuery('buty');

$products = getProducts($params, $sql)
?>


<?php
$currentPage = 'RUN 4 ALL | Buty';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="products-page">
    <nav class="left">
        <?php
        $categories = getAllCategories("buty");
        $sizes = getAllSizes("buty");
        include_once('components/filtering.php');
        ?>
    </nav>
    <div class="right">
        <h2>Buty</h2>
        <div class="list">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class='product-on-list'>
                        <a href="product.php?productName=<?= urlencode($product["productName"]) ?>">
                            <img class="product-image" src="<?= $product["path"] ?>" alt="Shoe images" width="100%"/>
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
</main>

<?php
include_once('components/footer.php');
?>
