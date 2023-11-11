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
        $target_dir = "images/products/clothes/"; // Directory where you want to store the images
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

            $id = $_POST["producer"];
            $name = $_POST["productName"];
            $price = $_POST["price"];

            // Now you can store the path in your database
            insertProductImage($id, $name, $price, $target_file);

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

?>

<?php
$currentPage = 'RUN 4 ALL | Panel Administratora';
include_once('utils/template.php');
?>

<main class="admin-panel">
    <h1>Panel Administratora</h1>
    <h2>Produkty</h2>
    <div class="product-admin-list">
        <?php foreach ($products as $product): ?>
            <div id="product_<?= $product['productId'] ?>" class="product-admin">
                <img src="<?= $product['path'] ?>" alt="Product <?= $product['productId'] ?>" width="150px">
                <p><?= $product['productName'] ?></p>
                <button onclick="deleteProduct(<?= $product['productId'] ?>)" class="trash-btn">
                    <img src="images/trash_icon.png" alt="Trash Icon" width="30px">
                </button>
            </div>
        <?php endforeach; ?>
    </div>
    <form action="admin-panel.php" method="post" enctype="multipart/form-data">
        <label for="image">Choose Image:</label>
        <input type="file" name="image" id="image" required>

        <label for="productName">Product Name:</label>
        <input type="text" name="productName" id="productName" required>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <label for="producer">Select Producer:</label>
        <select name="producer" id="producer">
            <?php foreach ($producers as $producer): ?>
                <option value=<?= $producer['producerId'] ?>>
                    <?= $producer['producer'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Upload</button>
    </form>
    <a class="logout-link" href="utils/logout.php">
        <img src="images/logout_icon.png" alt="Logout icon" width="40px"/>
        Wyloguj się
    </a>
    <script src="jsActions/admin.js"></script>
</main>

