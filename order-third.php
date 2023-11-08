<?php
include_once('utils/functions.php');

session_start();

if (isset($_SESSION['order']) && isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];

    $sum = 0.0;
    foreach ($cart as $product) {
        $sum += $product["price"] * $product["quantity"];
    }

    $order = $_SESSION['order'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["final"])) {
//    if (isset($_SESSION['user_id'])) ????
//    NIE WIEM PO CO TEN IF
    $orderId = insertOrder($order, $sum + $order["deliverer_price"]);
    insertOrderDetails($cart, $orderId);

    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    if (isset($_SESSION['user_id'])) {
        clearCartInDb($_SESSION['user_id']);
    }

    header('Location: order-fourth.php');
    exit();
}

?>

<?php
$currentPage = 'RUN 4 ALL | Podsumowanie Zamówienia';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="order-third">
    <h2>Podsumowanie:</h2>
    <section class="order-summary">
        <div class="summary-keys-container">
            <p class="summary-key">Imię:</p>
            <p class="summary-key">Nazwisko:</p>
            <p class="summary-key">Adres email:</p>
            <p class="summary-key">Telefon:</p>
            <p class="summary-key">Adres dostawy:</p>
            <p class="summary-key">Dostawca:</p>
            <p class="summary-key">Sposób Płatności:</p>
            <p class="summary-key cash">Wartość produktów:</p>
            <p class="summary-key">Dostawa:</p>
            <p class="summary-key final-sum">Cena całkowita:</p>
        </div>
        <div class="summary-values-container">
            <p class="summary-value"><?= $order['name'] ?></p>
            <p class="summary-value"><?= $order['surname'] ?></p>
            <p class="summary-value"><?= $order['email'] ?></p>
            <p class="summary-value"><?= $order['phone'] ?></p>
            <p class="summary-value"><?= $order['town'] ?>, <?= $order['street'] ?> <?= $order['number'] ?></p>
            <p class="summary-value"><?= $order['deliverer'] ?></p>
            <p class="summary-value"><?= $order['payment'] ?></p>
            <p class="summary-value cash"><?= $sum ?> zł</p>
            <p class="summary-value"><?= $order['deliverer_price'] ?> zł</p>
            <p class="summary-value final-sum"><?= $sum + $order['deliverer_price'] ?> zł</p>
        </div>
    </section>
    <form action="order-third.php" method="POST">
        <button name="final">Potwierdź i zapłać</button>
    </form>
</main>

<?php
include_once('components/footer.php');
?>
