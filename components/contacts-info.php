<div class="addresses-info">
    <h3>Kontakty</h3>

    <p class="field-type">Telefony</p>
    <?php foreach ($phones as $phone): ?>
        <div class="fields-and-edit">
            <p class="field-value"><?= $phone["value"] ?></p>
            <img onclick="toggleContactForm(<?= $phone["contactId"] ?>, 'telefon')" src="images/edit_icon.png" alt="Edit Icon"
                 width="30px">
            <form style="padding: 0px" action="serverActions/deleteContact.php" method="POST">
                <button class="trash-btn" name="contactId" value="<?= $phone["contactId"] ?>">
                    <img src="images/trash_icon.png" alt="Trash Icon" width="30px">
                </button>
            </form>
        </div>
        <!-- Form initially hidden -->
        <form id="edit-form-telefon<?= $phone["contactId"] ?>" style="display: none" action="account.php" method="POST">
            <input type="hidden" name="contactId" value="<?= $phone["contactId"] ?>">

            <label>Telefon:<br>
                <input size="12" type="text" name="value" value="<?= $phone["value"] ?>">
            </label>

            <button type="submit">Zapisz</button>
        </form>
    <?php endforeach; ?>
    <button class="new-address-btn" onclick="toggleNewContactForm('telefon')">
        <img id="new-telefon-btn-icon" src="images/plus_icon.png" alt="Plus Icon">
    </button>
    <form id="new-telefon-form" action="account.php" style="display: none" method="POST">
        <input type="hidden" name="type" value="telefon">

        <label>Nowy Telefon:<br>
            <input size="12" type="text" name="value">
        </label>

        <button type="submit">Zapisz</button>
    </form>

    <p class="field-type">Adresy email</p>
    <?php foreach ($emails as $email): ?>
        <div class="fields-and-edit">
            <p class="field-value"><?= $email["value"] ?></p>
            <img onclick="toggleContactForm(<?= $email["contactId"] ?>, 'email')" src="images/edit_icon.png" alt="Edit Icon"
                 width="30px">
            <form style="padding: 0px" action="serverActions/deleteContact.php" method="POST">
                <button class="trash-btn" name="contactId" value="<?= $email["contactId"] ?>">
                    <img src="images/trash_icon.png" alt="Trash Icon" width="30px">
                </button>
            </form>
        </div>
        <!-- Form initially hidden -->
        <form id="edit-form-email<?= $email["contactId"] ?>" style="display: none" action="account.php" method="POST">
            <input type="hidden" name="contactId" value="<?= $email["contactId"] ?>">

            <label>Email:<br>
                <input size="13" type="text" name="value" value="<?= $email["value"] ?>">
            </label>

            <button type="submit">Zapisz</button>
        </form>
    <?php endforeach; ?>
    <button class="new-address-btn" onclick="toggleNewContactForm('email')">
        <img id="new-email-btn-icon" src="images/plus_icon.png" alt="Plus Icon">
    </button>
    <form id="new-email-form" action="account.php" style="display: none" method="POST">
        <input type="hidden" name="type" value="email">

        <label>Nowy Email:<br>
            <input size="12" type="text" name="value">
        </label>

        <button type="submit">Zapisz</button>
    </form>
</div>
