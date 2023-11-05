<?php
include_once('utils/functions.php');

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

?>

<?php
$currentPage = 'RUN 4 ALL | Składanie Zamówienia';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="order">
    <h2>Składanie Zamówienia</h2>
    <?php if (isset($user_id)): ?>
        <p>Wybierz adres:</p>
        <form action="order-second.php" method="POST">
            <?php
            $addresses = getAddressesByUserId($user_id);
            foreach ($addresses as $address): ?>
                <label>
                    <input type="radio" name="addresses" value="<?= $address["addressId"] ?>">
                    <?= $address["type"] . ": " ?>
                    <?= $address["town"] ?>, <?= $address["street"] ?> <?= $address["number"] ?>
                </label>
            <?php endforeach; ?>
        </form>
    <?php else: ?>
        <a href="../run4all/order-second.php">Kontynuuj jako gość</a>
        <a href="../run4all/login_register.php">Zaloguj się</a>
    <?php endif; ?>
    <script src="jsActions/order.js"></script>
</main>

<?php
include_once('components/footer.php');
?>

