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

    if (isset($_POST["addressId"])){
        $addressId = $_POST["addressId"];
        updateAddress($addressId, $town, $street, $number);
    }
    else if ($_POST["type"]){
        $type = $_POST["type"];
        insertAddress($user_id, $town, $street, $number, $type);
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

$user = getUserByUserId($user_id);
$addresses = getAddressesByUserId($user_id);
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
    </div>
    <div class="addresses-info">
        <h3>Adresy</h3>
        <?php foreach ($addresses as $address): ?>
            <div class="fields-and-edit">
                <div>
                    <p class="field-type"><?= $address["type"] ?></p>
                    <p class="field-value"><?= $address["town"] ?>
                        , <?= $address["street"] ?> <?= $address["number"] ?></p>
                </div>
                <img onclick="toggleForm(<?= $address["addressId"] ?>)" src="images/edit_icon.png" alt="Edit Icon"
                     width="30px">
            </div>
            <!-- Form initially hidden -->
            <form id="edit-form-<?= $address["addressId"] ?>" style="display: none" action="account.php" method="POST">
                <input type="hidden" name="addressId" value="<?= $address["addressId"] ?>">

                <label>Miasto:<br>
                    <input type="text" name="town" value="<?= $address["town"] ?>">
                </label>

                <label>Ulica:<br>
                    <input type="text" name="street" value="<?= $address["street"] ?>">
                </label>

                <label>Numer domu:<br>
                    <input type="number" name="number" value="<?= $address["number"] ?>">
                </label>

                <button type="submit">Zapisz</button>
            </form>
        <?php endforeach; ?>
        <button class="new-address-btn" onclick="toggleNewAddressForm()">
            <img id="new-address-btn-icon" src="images/plus_icon.png" alt="Plus Icon">
        </button>
        <form id="new-address-form" action="account.php" style="display: none" method="POST">
            <label>Miasto:<br>
                <input type="text" name="town">
            </label>

            <label>Ulica:<br>
                <input type="text" name="street">
            </label>

            <label>Numer domu:<br>
                <input type="number" name="number">
            </label>

            <label>Typ - (dom, praca):<br>
                <input type="text" name="type">
            </label>

            <button type="submit">Zapisz</button>
        </form>
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
