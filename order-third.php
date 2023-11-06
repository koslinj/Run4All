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
    if (isset($_SESSION['user_id']))
    $orderId = insertOrder($order, $sum);
    insertOrderDetails($cart, $orderId);

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

    <form action="order-third.php" method="POST">
        <button name="final">Potwierdź i zapłać</button>
    </form>
</main>

<?php
include_once('components/footer.php');
?>
