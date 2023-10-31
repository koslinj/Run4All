<?php
require("utils/functions.php");

list($params, $sql) = createQuery();

$products = getProducts($params, $sql)
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
