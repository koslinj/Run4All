<?php
include_once('utils/functions.php');

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user = getUserByUserId($user_id);

    $_SESSION['order']['name'] = $user["name"];
    $_SESSION['order']['surname'] = $user["surname"];
    $_SESSION['order']['password_email'] = $user["password_email"];

    $addresses = getAddressesByUserId($user_id);
    $phones = getContactsByUserId($user_id, "telefon");
    $emails = getContactsByUserId($user_id, "email");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["address"]) && isset($_POST["phone"]) && isset($_POST["email"])) {
        $addressId = $_POST["address"];
        $address = getAddressByAddressId($addressId);
        $phone = $_POST["phone"];
        $email = $_POST["email"];

        $_SESSION['order']['town'] = $address["town"];
        $_SESSION['order']['street'] = $address["street"];
        $_SESSION['order']['number'] = $address["number"];
        $_SESSION['order']['phone'] = $phone;
        $_SESSION['order']['email'] = $email;

        header('Location: order-second.php');
        exit();
    }
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
        <?php if (empty($addresses)): ?>
            <h3 class="error-header">Na twoim koncie brakuje adresu!</h3>
            <p class="error-info">Wróć do <a href="account.php">Panelu klienta</a> aby dodać adres!</p>
        <?php elseif (empty($phones)): ?>
            <h3 class="error-header">Na twoim koncie brakuje telefonu!</h3>
            <p class="error-info">Wróć do <a href="account.php">Panelu klienta</a> aby dodać numer telefonu!</p>
        <?php else: ?>
            <form class="radio-form" action="order.php" method="POST">
                <div>
                    <h3>Wybierz adres:</h3>
                    <?php foreach ($addresses as $address): ?>
                        <label>
                            <input required type="radio" name="address" value=<?= $address["addressId"] ?>>
                            <strong><?= $address["type"] . ": " ?></strong>
                            <?= $address["town"] ?>, <?= $address["street"] ?> <?= $address["number"] ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div>
                    <h3>Wybierz telefon:</h3>
                    <?php foreach ($phones as $phone): ?>
                        <label>
                            <input required type="radio" name="phone" value="<?= $phone["value"] ?>">
                            <?= $phone["value"] ?>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div>
                    <h3>Wybierz email:</h3>
                    <label>
                        <input required type="radio" name="email" value="<?= $user["password_email"] ?>">
                        <?= $user["password_email"] ?>
                    </label>
                    <?php foreach ($emails as $email): ?>
                        <label>
                            <input required type="radio" name="email" value="<?= $email["value"] ?>">
                            <?= $email["value"] ?>
                        </label>
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
        <?php endif; ?>
    <?php else: ?>
        <a href="../run4all/order-second.php">Kontynuuj jako gość</a>
        <a href="../run4all/login_register.php">Zaloguj się</a>
    <?php endif; ?>
    <script src="jsActions/order.js"></script>
</main>

<?php
include_once('components/footer.php');
?>

