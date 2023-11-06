<?php
include_once('utils/functions.php');
session_start();

// Check if the user is authenticated
if (empty($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: login_register.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["town"]) && isset($_POST["street"]) && isset($_POST["number"])) {
    // Retrieve the new values from the form
    $town = $_POST["town"];
    $street = $_POST["street"];
    $number = $_POST["number"];

    if (isset($_POST["addressId"])) {
        $addressId = $_POST["addressId"];
        updateAddress($addressId, $town, $street, $number);
    } else if ($_POST["type"]) {
        $type = $_POST["type"];
        insertAddress($user_id, $town, $street, $number, $type);
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["value"])) {
    // Retrieve the new values from the form
    $value = $_POST["value"];

    if (isset($_POST["contactId"])) {
        $contactId = $_POST["contactId"];
        updateContact($contactId, $value);
    } else if (isset($_POST["type"])) {
        $type = $_POST["type"];
        insertContact($user_id, $value, $type);
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

$user = getUserByUserId($user_id);
$addresses = getAddressesByUserId($user_id);
$phones = getContactsByUserId($user_id, 'telefon');
$emails = getContactsByUserId($user_id, 'email');
$orders = getOrdersByNameAndSurname($user["name"], $user["surname"]);
?>

<?php
$currentPage = 'RUN 4 ALL | Moje Konto';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<h2>Twoje konto</h2>
<main class="account">
    <div class="general-info">
        <h3>Podstawowe Informacje</h3>
        <p class="field-type">Imię</p>
        <p class="field-value"><?php echo $user["name"]; ?></p>
        <p class="field-type">Nazwisko</p>
        <p class="field-value"><?php echo $user["surname"]; ?></p>
        <p class="field-type">Główny Email</p>
        <p class="field-value"><?php echo $user["password_email"]; ?></p>
    </div>
    <?php include_once('components/addresses-info.php'); ?>
    <?php include_once('components/contacts-info.php') ?>
    <div class="my-orders">
        <h3>Zamówienia</h3>
        <div class="my-orders-container">
            <?php foreach ($orders as $order): ?>
                <div class="order-container">
                    <div class="order-general green-bg">
                        <div>
                            <p class="field-type">Data:</p>
                            <p class="field-value"><?= date("Y-m-d", strtotime($order["date"])); ?></p>
                        </div>
                        <div>
                            <p class="field-type">Wartość:</p>
                            <p class="field-value"><?= $order["value"]; ?></p>
                        </div>
                        <div>
                            <p class="field-type">Status:</p>
                            <p class="field-value"><?= $order["status"]; ?></p>
                        </div>
                    </div>
                    <button id="hide-order-btn-<?= $order['orderId'] ?>"
                            onclick="toggleDetails(<?= $order['orderId'] ?>)">Zobacz szczegóły
                    </button>
                    <div style="display: none;" id="hidden-order-<?= $order['orderId'] ?>">
                        <h4>Dane Kontaktowe</h4>
                        <div class="order-general">
                            <div>
                                <p class="field-type">Adres:</p>
                                <p class="field-value"><?= $order["town"] ?>
                                    , <?= $order["street"] ?> <?= $order["number"] ?>
                                </p>
                            </div>
                            <div>
                                <p class="field-type">Telefon:</p>
                                <p class="field-value"><?= $order["phone"]; ?></p>
                            </div>
                            <div>
                                <p class="field-type">Email:</p>
                                <p class="field-value"><?= $order["email"]; ?></p>
                            </div>
                        </div>
                        <h4>Płatność i Dostawa</h4>
                        <div class="order-general">
                            <div>
                                <p class="field-type">Płatność:</p>
                                <p class="field-value"><?= $order["payment"]; ?></p>
                            </div>
                            <div>
                                <p class="field-type">Dostawca:</p>
                                <p class="field-value"><?= $order["deliverer"]; ?></p>
                            </div>
                        </div>
                        <h4>Produkty</h4>
                        <?php
                        $details = getDetailsByOrderId($order["orderId"]);
                        foreach ($details as $detail): ?>
                            <div class="order-general">
                                <div>
                                    <p class="field-type">Nazwa:</p>
                                    <p class="field-value"><?= $detail["productName"]; ?></p>
                                </div>
                                <div>
                                    <p class="field-type">Ilość:</p>
                                    <p class="field-value"><?= $detail["quantity"]; ?></p>
                                </div>
                                <div>
                                    <p class="field-type">Rozmiar:</p>
                                    <p class="field-value"><?= $detail["size"]; ?></p>
                                </div>
                                <div>
                                    <p class="field-type">Cena:</p>
                                    <p class="field-value"><?= $detail["price"]; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <a class="logout-link" href="utils/logout.php">
        <img src="images/logout_icon.png" alt="Logout icon" width="40px"/>
        Wyloguj się
    </a>
    <script src="jsActions/account.js"></script>
</main>

<?php
include_once('components/footer.php');
?>
