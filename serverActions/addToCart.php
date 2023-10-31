<?php
require("../utils/functions.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['size'])) {
    // Handle adding the product to the cart
    $product = getProductByProductId($_POST['product_id']);

    // Example: Product information to add to the cart
    $product['size'] = $_POST['size'];
    $product['quantity'] = 1;

    // Initialize the cart if it doesn't exist in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $key = $product['productId'] . $_POST['size'];
    // Check if the product is already in the cart
    if (array_key_exists($key, $_SESSION['cart']) && $_SESSION['cart'][$key]['size'] === $_POST['size']) {
        // If the product is in the cart, update the quantity
        $_SESSION['cart'][$key]['quantity'] += $product['quantity'];
    } else {
        // If the product is not in the cart, add it to the cart
        $_SESSION['cart'][$key] = $product;
    }

    if (isset($_SESSION['user_id'])) {
        saveCartFromSession($_SESSION["cart"], $_SESSION['user_id']);
    }

} else {
    // Respond with an error message if the request is not valid
    http_response_code(400); // Bad Request
}
