<?php
include_once('utils/admin_functions.php');
session_start();

// Check if the user is authenticated
if (empty($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: login_register.php");
    exit();
}

if ($_SESSION['role'] === 'user') {
    header("Location: account.php");
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
            echo $category . "<br>";
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

$shoesSliders = getAllSlidersAdmin('buty');
$clothesSliders = getAllSlidersAdmin('ubrania');
$accessoriesSliders = getAllSlidersAdmin('akcesoria');

$shoes = getAllProductsByTypeAdmin('buty');
$clothes = getAllProductsByTypeAdmin('ubrania');
$accessories = getAllProductsByTypeAdmin('akcesoria');

?>

<?php
$currentPage = 'RUN 4 ALL | Panel Administratora';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="admin-panel">
    <h1>Panel Administratora</h1>
    <h2>Produkty</h2>
    <?php include_once('components/products-section.php'); ?>
    <h2>Promowane Produkty</h2>
    <section class="admin-section-promoted">
        <div>
            <h3>Buty</h3>
            <div class="promoted-admin-list">
                <?php foreach ($shoesSliders as $shoe): ?>
                    <div class="promoted-product">
                        <img src="<?= $shoe['path'] ?>" alt="<?= $shoe['productName'] ?>" width="80px">
                        <select class="slider-select" data-slider-id="<?= $shoe['sliderId'] ?>">
                            <?php foreach ($shoes as $shoeInner): ?>
                                <option <?php if ($shoeInner['productName'] === $shoe['productName']) echo "selected"; ?>
                                        value="<?= $shoeInner['productId'] ?>"><?= $shoeInner['productName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <h3>Ubrania</h3>
            <div class="promoted-admin-list">
                <?php foreach ($clothesSliders as $cloth): ?>
                    <div class="promoted-product">
                        <img src="<?= $cloth['path'] ?>" alt="<?= $cloth['productName'] ?>" width="80px">
                        <select class="slider-select" data-slider-id="<?= $cloth['sliderId'] ?>">
                            <?php foreach ($clothes as $clothInner): ?>
                                <option <?php if ($clothInner['productName'] === $cloth['productName']) echo "selected"; ?>
                                        value="<?= $clothInner['productId'] ?>"><?= $clothInner['productName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <h3>Akcesoria</h3>
            <div class="promoted-admin-list">
                <?php foreach ($accessoriesSliders as $accessory): ?>
                    <div class="promoted-product">
                        <img src="<?= $accessory['path'] ?>" alt="<?= $accessory['productName'] ?>" width="80px">
                        <select class="slider-select" data-slider-id="<?= $accessory['sliderId'] ?>">
                            <?php foreach ($accessories as $accessoryInner): ?>
                                <option <?php if ($accessoryInner['productName'] === $accessory['productName']) echo "selected"; ?>
                                        value="<?= $accessoryInner['productId'] ?>"><?= $accessoryInner['productName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <h2>Zamówienia</h2>
    <div class="input-search">
        <input size="28" oninput="searchOrder('date')" type="text" id="searchOrderInput-date"
               placeholder="Wyszukaj po dacie (rrrr-mm-dd)">
        <img src="images/search_icon.png" alt="Search Icon" width="40px">
    </div>
    <div class="input-search">
        <input size="28" oninput="searchOrder('email')" type="text" id="searchOrderInput-email"
               placeholder="Wyszukaj po emailu">
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
                        <select name="status" id="statusSelect<?= $order['orderId'] ?>"
                                onchange="updateStatus(<?= $order['orderId'] ?>)">
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selects = document.querySelectorAll('.slider-select');

            selects.forEach(function (select) {
                select.addEventListener('change', function () {
                    const selectedProductId = this.value;
                    const sliderId = this.dataset.sliderId;

                    // Make an AJAX request to update the database using Fetch API
                    fetch('serverActions/updateSlider.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `selectedProductId=${encodeURIComponent(selectedProductId)}&sliderId=${encodeURIComponent(sliderId)}`
                    })
                        .then(response => response.json()) // Assuming the response is in JSON format
                        .then(data => {
                            // Assuming your server-side script returns a success message
                            console.log(data);

                            // Update the displayed image based on the selected option
                            const imagePath = data.path; // Replace with the actual property name in your response
                            document.querySelector(`[data-slider-id="${sliderId}"]`).previousElementSibling.src = imagePath;
                        })
                        .catch(error => {
                            console.error('Error updating slider:', error);
                        });
                });
            });
        });
    </script>
</main>

