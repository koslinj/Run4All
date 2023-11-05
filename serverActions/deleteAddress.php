<?php
require("../utils/functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["addressId"])) {

    $id = $_POST["addressId"];
    deleteAddress($id);

    header('Location: ../account.php');
    exit();
}
