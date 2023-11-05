<?php
require("../utils/functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["contactId"])) {

    $id = $_POST["contactId"];
    deleteContact($id);

    header('Location: ../account.php');
    exit();
}
