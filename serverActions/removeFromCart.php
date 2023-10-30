<?php
require("../utils/functions.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {

    $id = $_POST['product_id'];
    // Check if the product is already in the cart
    if ($_SESSION['cart'][$id]['quantity'] > 1) {
        // If the product is in the cart, update the quantity
        $_SESSION['cart'][$id]['quantity'] -= 1;
    } else {
        // If the product is not in the cart, add it to the cart
        unset($_SESSION['cart'][$id]);
    }
} else {
    // Respond with an error message if the request is not valid
    http_response_code(400); // Bad Request
}
