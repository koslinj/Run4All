<?php
require("../utils/admin_functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["productId"]) && isset($_POST["price"])) {

    $id = $_POST["productId"];
    $price = $_POST["price"];
    updatePriceAdmin($price, $id);

    http_response_code(200);
} else {
    http_response_code(400);
}

