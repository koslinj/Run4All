<?php
require("../utils/functions.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['size'])) {

    $key = $_POST['product_id'] . $_POST['size'];
    // Check if the product is already in the cart
    if ($_SESSION['cart'][$key]['quantity'] > 1) {
        // If the product is in the cart, update the quantity
        $_SESSION['cart'][$key]['quantity'] -= 1;
    } else {
        // If the product is not in the cart, add it to the cart
        unset($_SESSION['cart'][$key]);
    }

    if (isset($_SESSION['user_id'])) {
        saveCartFromSession($_SESSION["cart"], $_SESSION['user_id']);
    }

} else {
    // Respond with an error message if the request is not valid
    http_response_code(400); // Bad Request
}
