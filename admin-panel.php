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

?>

<?php
$currentPage = 'RUN 4 ALL | Panel Administratora';
include_once('utils/template.php');
?>

<main class="admin-panel">
    <h1>Panel Administratora</h1>
    <h2>Produkty</h2>
    <section class="admin-section-products">
        <div class="product-admin-list">
            <input oninput="searchProduct()" type="text" id="searchInput" placeholder="Wyszukaj po nazwie...">
            <?php foreach ($products as $product): ?>
                <div id="product_<?= $product['productId'] ?>" class="product-admin"
                     data-product-name="<?= $product['productName'] ?>">
                    <img style="box-shadow: 0 0 5px 0.1px" src="<?= $product['path'] ?>"
                         alt="Product <?= $product['productId'] ?>" width="150px">
                    <p><?= $product['productName'] ?></p>
                    <button onclick="toggleProductForm(<?= $product['productId'] ?>)" class="trash-btn">
                        <img src="images/edit_icon.png" alt="Edit Icon" width="30px">
                    </button>
                    <button onclick="deleteProduct(<?= $product['productId'] ?>)" class="trash-btn">
                        <img src="images/trash_icon.png" alt="Trash Icon" width="30px">
                    </button>
                </div>
                <form id="edit-form-product<?= $product['productId'] ?>" style="display: none" action="admin-panel.php"
                      method="POST">
                    <input type="hidden" name="contactId" value="<?= $product['productId'] ?>">

                    <label>Rozmiary:<br>
                        <div class="change-product-list">
                            <?php
                            $sizes = getSizesByProductIdAdmin($product['productId']);
                            foreach ($sizes as $size): ?>
                                <div class="change-product-item" id="size-item-<?= $size['sizeId'] ?>">
                                    <?= $size['size'] ?>
                                    <img onclick="deleteSize(<?= $size['sizeId'] ?>)" src="images/trash_icon.png" alt="Trash Icon" width="22px">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </label>

                    <button type="submit">Zapisz</button>
                </form>
            <?php endforeach; ?>
        </div>
        <form action="admin-panel.php" method="post" enctype="multipart/form-data">
            <h3>Dodaj Produkt</h3>
            <label class="main-label">
                Wybierz Zdjęcie:<br>
                <input type="file" name="image" required>
            </label>

            <label class="main-label">
                Nazwa Produktu:<br>
                <input type="text" name="productName" required>
            </label>

            <label class="main-label">
                Cena:<br>
                <input type="number" name="price" step="0.01" required>
            </label>

            <label class="main-label">
                Producent:<br>
                <select name="producer" id="producer">
                    <?php foreach ($producers as $producer): ?>
                        <option value=<?= $producer['producerId'] ?>>
                            <?= $producer['producer'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <div style="display: flex; gap: 10px; flex-wrap: wrap">
                <label class="main-label">
                    Rodzaj:<br>
                    <select id="typeSelect" name="type" onchange="updateSizes();updateCategories()">
                        <option value="ubrania">ubrania</option>
                        <option value="buty">buty</option>
                        <option value="akcesoria">akcesoria</option>
                    </select>
                </label>

                <label class="main-label">
                    Kategoria:<br>
                    <select name="category" id="categorySelect"></select>
                </label>
            </div>

            <div>
                <label class="main-label">Rozmiary:</label>
                <div id="sizesContainer"></div>
            </div>

            <div>
                <label class="main-label">Kolory:</label>
                <div>
                    <?php foreach ($colors as $color): ?>
                        <label>
                            <?= $color["color"] ?>
                            <input type="checkbox" name="color[]" value=<?= $color["colorId"] ?>>
                            <br>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit">Dodaj</button>
        </form>
    </section>
    <a class="logout-link" href="utils/logout.php">
        <img src="images/logout_icon.png" alt="Logout icon" width="40px"/>
        Wyloguj się
    </a>
    <script src="jsActions/admin.js"></script>
</main>

