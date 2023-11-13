<?php
include_once('utils/functions.php');

session_start();

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION["cart"];
}

?>

<?php
$currentPage = 'RUN 4 ALL | Koszyk';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="cart">
    <h2>Koszyk</h2>
    <?php if (!empty($cart)): ?>
        <?php foreach ($cart as $product): ?>
            <div class="product-in-cart">
                <img src="<?= $product["path"] ?>" alt="Shoe images" width="160px"/>
                <div>
                    <a href="product.php?productName=<?= urlencode($product["productName"]) ?>">
                        <p><?= $product["productName"] ?></p>
                    </a>
                    <i>Nazwa</i>
                </div>
                <div>
                    <p><?= $product["size"] ?></p>
                    <i>Rozmiar</i>
                </div>
                <div>
                    <p><?= $product["price"] ?> zł</p>
                    <i>Cena</i>
                </div>
                <div>
                    <p id="quantity_<?= $product["productId"] . $product["size"] ?>">
                        <?= $product["quantity"] ?>
                    </p>
                    <i>Ilość</i>
                </div>
                <div>
                    <p id="full_<?= $product["productId"] . $product["size"] ?>">
                        <?= number_format($product["quantity"] * $product["price"], 2) ?> zł
                    </p>
                    <i>Łącznie</i>
                </div>
                <div class="quantity-handler">
                    <img onclick="changeQuantity(<?= $product['productId']; ?>, <?= $product['price']; ?>, '<?= $product['size']; ?>', 'increment')"
                         src="images/up_arrow_icon.png" alt="Up Arrow Icon" width="30px">
                    <img onclick="changeQuantity(<?= $product['productId']; ?>, <?= $product['price']; ?>, '<?= $product['size']; ?>', 'decrement')"
                         src="images/down_arrow_icon.png" alt="Down Arrow Icon" width="30px">
                </div>
            </div>
        <?php endforeach; ?>
        <div class="cart-bottom">
            <a class="clear-cart" href="serverActions/clearCart.php">Wyczyść koszyk</a>
            <a href="../run4all/order.php">
                <div class="make-order">
                    Złóż zamówienie
                    <img src="images/right_arrow_icon.png" alt="Right Arrow Icon" height="50px">
                </div>
            </a>
        </div>
    <?php else: ?>
        <h3>Koszyk jest pusty!</h3>
    <?php endif; ?>
    <script src="jsActions/cart.js"></script>
</main>

<?php
include_once('components/footer.php');
?>

