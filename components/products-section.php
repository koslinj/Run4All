<div class="input-search">
    <input class="input-search" oninput="searchProduct()" type="text" id="searchInput" placeholder="Wyszukaj po nazwie...">
    <img src="images/search_icon.png" alt="Search Icon" width="40px">
</div>
<section class="admin-section-products">
    <div class="product-admin-list">
        <?php foreach ($products as $product): ?>
            <div id="product_<?= $product['productId'] ?>" class="product-admin"
                 data-product-name="<?= $product['productName'] ?>">
                <img style="box-shadow: 0 0 5px 0.1px" src="<?= $product['path'] ?>"
                     alt="Product <?= $product['productId'] ?>" width="150px" height="120px">
                <p><?= $product['productName'] ?></p>
                <button onclick="toggleProductForm(<?= $product['productId'] ?>)" class="trash-btn">
                    <img src="images/edit_icon.png" alt="Edit Icon" width="30px">
                </button>
                <button onclick="openModal(<?= $product['productId'] ?>)" class="trash-btn">
                    <img src="images/trash_icon.png" alt="Trash Icon" width="30px">
                </button>
                <div id="deleteModal_<?= $product['productId'] ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal(<?= $product['productId'] ?>)">&times;</span>
                        <p>Are you sure you want to delete this product?</p>
                        <button onclick="confirmDelete(<?= $product['productId'] ?>)">Yes</button>
                        <button onclick="closeModal(<?= $product['productId'] ?>)">No</button>
                    </div>
                </div>
            </div>
            <div id="edit-form-product<?= $product['productId'] ?>" style="display: none" class="edit-product-admin">
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
                <form onsubmit="event.preventDefault(); insertSize(<?= $product['productId'] ?>, '<?= getTypeByProductIdAdmin($product['productId']) ?>')">
                    <label>
                        Dodaj Rozmiar:<br>
                        <input type="text" name="sizeInput" id="sizeInput<?= $product['productId'] ?>" required>
                        <button type="submit">Zapisz</button>
                    </label>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    <form class="admin-form" action="admin-panel.php" method="post" enctype="multipart/form-data">
        <h3>Dodaj Produkt</h3>
        <label class="main-label", style="display: flex; flex-direction: column; align-items: flex-start">
            Wybierz Zdjęcie:<br>
            <div style="font-size: 90%; display: flex; gap: 10px; align-items: center; flex-wrap: wrap">
                <div style="border-radius: 6px; border: 3px solid black; cursor: pointer; padding: 4px; background-color: white">Wybierz plik</div>
                <div style="word-break: break-all" class="file-info" id="file-info"></div>
            </div>
            <input onchange="updateFileName(this)" style="display: none" type="file" name="image" required>
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
            <div style="display: flex; flex-wrap: wrap; column-gap: 16px; row-gap: 8px">
                <?php foreach ($colors as $color): ?>
                    <label>
                        <input type="checkbox" name="color[]" value=<?= $color["colorId"] ?>>
                        <?= $color["color"] ?>
                        <br>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit">Dodaj</button>
    </form>
    <script>
        function updateFileName(input) {
            const fileDisplay = document.getElementById('file-info');
            if (input.files.length > 0) {
                fileDisplay.innerText = 'Wybrany plik: ' + input.files[0].name;
            }
        }
    </script>
</section>
