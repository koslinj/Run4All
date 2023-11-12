<?php
include_once('utils/admin_functions.php');
session_start();

// Check if the user is authenticated
if (empty($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: login_register.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file was uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $type = $_POST["type"];
        if ($type == "ubrania") $target_dir = "images/products/clothes/"; // Directory
        if ($type == "buty") $target_dir = "images/products/shoes/"; // Directory
        if ($type == "akcesoria") $target_dir = "images/products/accessories/"; // Directory

        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

            $id = $_POST["producer"];
            $name = $_POST["productName"];
            $price = $_POST["price"];
            $sizes = $_POST["size"];
            $category = $_POST["category"];
            $colors = $_POST["color"];
            echo $category. "<br>";
            var_dump($colors);

            // Now you can store the path in your database
            $insertId = insertProductAdmin($id, $name, $price, $target_file);
            insertSizesAdmin($insertId, $sizes, $type);
            insertCategoryAdmin($category, $insertId);
            insertColorsAdmin($colors, $insertId);

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Error: " . $_FILES["image"]["error"];
    }

    header("Location: admin-panel.php");
    exit();
}

$products = getAllProductsAdmin();
$producers = getAllProducersAdmin();
$colors = getAllColorsAdmin();

$orders = getAllOrdersAdmin();
$statuses = getAllStatusesAdmin();

?>

<?php
$currentPage = 'RUN 4 ALL | Panel Administratora';
include_once('utils/template.php');
?>

<main class="admin-panel">
    <h1>Panel Administratora</h1>
    <h2>Produkty</h2>
    <?php include_once('components/products-section.php'); ?>
    <h2>Zamówienia</h2>
    <div class="input-search">
        <input size="28" oninput="searchOrder('date')" type="text" id="searchOrderInput-date" placeholder="Wyszukaj po dacie (rrrr-mm-dd)">
        <img src="images/search_icon.png" alt="Search Icon" width="40px">
    </div>
    <div class="input-search">
        <input size="28" oninput="searchOrder('email')" type="text" id="searchOrderInput-email" placeholder="Wyszukaj po emailu">
        <img src="images/search_icon.png" alt="Search Icon" width="40px">
    </div>
    <section class="admin-section-orders">
        <div class="orders-admin-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-admin" data-order-date="<?= $order['date'] ?>" data-email="<?= $order['email'] ?>">
                    <p>
                        <i style="color: rgb(128,128,128); font-size: 16px">Data zamówienia:</i><br>
                        <b><?= $order['date'] ?></b>
                    </p>
                    <p>
                        <i style="color: rgb(128,128,128); font-size: 16px">Email:</i><br>
                        <b><?= $order['email'] ?></b>
                    </p>
                    <p>
                        <i style="color: rgb(128,128,128); font-size: 16px">Dostawca:</i><br>
                        <b><?= $order['deliverer'] ?></b>
                    </p>
                    <div>
                        <i style="color: rgb(128,128,128); font-size: 16px">Status:</i><br>
                        <select name="status" id="statusSelect<?= $order['orderId'] ?>" onchange="updateStatus(<?= $order['orderId'] ?>)">
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?= $status['status'] ?>" <?= ($status['status'] == $order['status']) ? "selected" : "" ?> ><?= $status['status'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <a class="logout-link" href="utils/logout.php">
        <img src="images/logout_icon.png" alt="Logout icon" width="40px"/>
        Wyloguj się
    </a>
    <script src="jsActions/admin.js"></script>
</main>

