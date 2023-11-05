<?php
include_once('utils/functions.php');

session_start();

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION["cart"];
}

?>

<?php
$currentPage = 'RUN 4 ALL | Składanie Zamówienia';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="order-second">
    <h2>Składanie Zamówienia</h2>
    <?php if (isset($cart)): ?>
        <div class="check-order">
            <h3>Sprawdź swoje zamówienie:</h3>
            <?php foreach ($cart as $product): ?>
                <div class="product-in-order">
                    <img src="<?= $product["path"] ?>" alt="Shoe images" width="100px"/>
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
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="order-second.php" method="POST" onsubmit="return checkDeliverers()">
        <div class="choose-deliverer">
            <h3>Wybierz dostawcę:</h3>
            <?php
            $deliverers = getAllDeliverers();
            foreach ($deliverers as $deliverer): ?>
                <div class="deliverer">
                    <div>
                        <input type="radio" id="<?= $deliverer["deliverer"] ?>" name="deliverers"
                               value="<?= $deliverer["deliverer"] ?>">
                        <label for="<?= $deliverer["deliverer"] ?>"><?= $deliverer["deliverer"] ?></label>
                    </div>
                    <img src="<?= $deliverer["path"] ?>" alt="<?= $deliverer["deliverer"] ?> Logo" width="50px">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="choose-payment">
            <h3>Wybierz sposób płatności:</h3>
            <?php
            $payments = getAllPayments();
            foreach ($payments as $payment): ?>
                <div class="payment">
                    <div>
                        <input type="radio" id="<?= $payment["payment"] ?>" name="payments"
                               value="<?= $payment["payment"] ?>">
                        <label for="<?= $payment["payment"] ?>"><?= $payment["payment"] ?></label>
                    </div>
                    <img src="<?= $payment["path"] ?>" alt="<?= $payment["payment"] ?> Logo" width="50px">
                </div>
            <?php endforeach; ?>
        </div>
        <button>Przejdź dalej</button>
    </form>
    <script src="jsActions/order.js"></script>
</main>

<?php
include_once('components/footer.php');
?>

