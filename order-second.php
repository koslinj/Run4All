<?php
include_once('utils/functions.php');

session_start();

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION["cart"];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["deliverer"]) && isset($_POST["payment"])) {
        $deliverer = $_POST["deliverer"];
        $payment = $_POST["payment"];

        $_SESSION['order']['deliverer'] = $deliverer;
        $_SESSION['order']['payment'] = $payment;

        header('Location: order-third.php');
        exit();
    }
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
    <form action="order-second.php" method="POST" onsubmit="return checkDelivererAndPayment()">
        <div class="choose-deliverer">
            <h3>Wybierz dostawcę:</h3>
            <?php
            $deliverers = getAllDeliverers();
            foreach ($deliverers as $deliverer): ?>
                <div class="deliverer">
                    <div>
                        <input type="radio" id="<?= $deliverer["deliverer"] ?>" name="deliverer"
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
                        <input type="radio" id="<?= $payment["payment"] ?>" name="payment"
                               value="<?= $payment["payment"] ?>">
                        <label for="<?= $payment["payment"] ?>"><?= $payment["payment"] ?></label>
                    </div>
                    <img src="<?= $payment["path"] ?>" alt="<?= $payment["payment"] ?> Logo" width="50px">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="order-nav-btns">
            <button type="button" onclick="window.history.back()">
                <img src="images/back_icon.png" alt="Back Icon" height="50px">
                Wróć
            </button>
            <button>
                Przejdź dalej
                <img src="images/right_arrow_icon.png" alt="Right Arrow Icon" height="50px">
            </button>
        </div>
    </form>
    <script src="jsActions/order.js"></script>
</main>

<?php
include_once('components/footer.php');
?>

