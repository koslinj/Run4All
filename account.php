<?php
include_once('utils/functions.php');
session_start();

// Check if the user is authenticated
if (empty($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: login_register.php");
    exit();
}

if ($_SESSION['role'] === 'admin') {
    header("Location: admin-panel.php");
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
$orders = getOrdersByPasswordEmail($user["password_email"]);
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
    <?php include_once('components/my-orders-info.php') ?>
    <a class="logout-link" href="utils/logout.php">
        <img src="images/logout_icon.png" alt="Logout icon" width="40px"/>
        Wyloguj się
    </a>
    <script src="jsActions/account.js"></script>
</main>

<?php
include_once('components/footer.php');
?>
