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
            <form style="padding: 0px" action="serverActions/deleteAddress.php" method="POST">
                <button class="trash-btn" name="addressId" value="<?= $address["addressId"] ?>">
                    <img src="images/trash_icon.png" alt="Trash Icon" width="30px">
                </button>
            </form>
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
