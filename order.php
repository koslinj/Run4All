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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["withAccount"])) {
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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["withoutAccount"])) {
    if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["town"]) && isset($_POST["street"]) && isset($_POST["number"])) {

        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $town = $_POST["town"];
        $street = $_POST["street"];
        $number = $_POST["number"];


        $_SESSION['order']['name'] = $name;
        $_SESSION['order']['surname'] = $surname;
        $_SESSION['order']['email'] = $email;
        $_SESSION['order']['phone'] = $phone;
        $_SESSION['order']['town'] = $town;
        $_SESSION['order']['street'] = $street;
        $_SESSION['order']['number'] = $number;

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
    <?php if (isset($user_id)): ?>
        <?php if (empty($addresses)): ?>
            <div>
                <h3 class="error-header">Na twoim koncie brakuje adresu!</h3>
                <p class="error-info">Wróć do <a href="account.php">Panelu klienta</a> aby dodać adres!</p>
            </div>
        <?php elseif (empty($phones)): ?>
            <div>
                <h3 class="error-header">Na twoim koncie brakuje telefonu!</h3>
                <p class="error-info">Wróć do <a href="account.php">Panelu klienta</a> aby dodać numer telefonu!</p>
            </div>
        <?php else: ?>
            <form class="radio-form" action="order.php" method="POST">
                <input type="hidden" name="withAccount" value="withAccount">
                <div>
                    <h3>Wybierz adres:</h3>
                    <div class="options-container">
                        <?php foreach ($addresses as $address): ?>
                            <label>
                                <input required type="radio" name="address" value=<?= $address["addressId"] ?>>
                                <strong><?= $address["type"] . ": " ?></strong>
                                <?= $address["town"] ?>, <?= $address["street"] ?> <?= $address["number"] ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div>
                    <h3>Wybierz telefon:</h3>
                    <div class="options-container">
                        <?php foreach ($phones as $phone): ?>
                            <label>
                                <input required type="radio" name="phone" value="<?= $phone["value"] ?>">
                                <?= $phone["value"] ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div>
                    <h3>Wybierz email:</h3>
                    <div class="options-container">
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
        <div>
            <h2>Nie mam konta:</h2>
            <form class="admin-form" action="order.php" method="POST">
                <input type="hidden" name="withoutAccount" value="withoutAccount">
                <h4 style="color: rgb(150,150,150); margin: 10px 0 0 0; text-align: center">Wypełnij dane
                    kontaktowe</h4>

                <label class="main-label">
                    Imię:<br>
                    <input type="text" name="name" required>
                </label>

                <label class="main-label">
                    Nazwisko:<br>
                    <input type="text" name="surname" required>
                </label>

                <label class="main-label">
                    Email:<br>
                    <input type="email" name="email" required>
                </label>

                <label class="main-label">
                    Telefon:<br>
                    <input type="tel" name="phone" required>
                </label>

                <label class="main-label">
                    Miasto:<br>
                    <input type="text" name="town" required>
                </label>

                <label class="main-label">
                    Ulica:<br>
                    <input type="text" name="street" required>
                </label>

                <label class="main-label">
                    Numer:<br>
                    <input type="number" name="number" required>
                </label>

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
        </div>
        <div>
            <h2>Mam konto:</h2>
            <a class="login-link" href="../run4all/login_register.php">
                <img src="images/login_icon.png" alt="Login Icon" width="30px">
                Zaloguj się
            </a>
        </div>
    <?php endif; ?>
    <script src="jsActions/order.js"></script>
</main>

<?php
include_once('components/footer.php');
?>

