<?php
require("../utils/functions.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    // Handle adding the product to the cart
    $productFromDb = getProductByProductId($_POST['product_id']);

    // Example: Product information to add to the cart
    $product = array(
        'id' => $productFromDb["productId"],
        'name' => $productFromDb["productName"],
        'price' => $productFromDb["price"],
        'quantity' => 1,
    );

    // Initialize the cart if it doesn't exist in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if the product is already in the cart
    if (array_key_exists($product['id'], $_SESSION['cart'])) {
        // If the product is in the cart, update the quantity
        $_SESSION['cart'][$product['id']]['quantity'] += $product['quantity'];
    } else {
        // If the product is not in the cart, add it to the cart
        $_SESSION['cart'][$product['id']] = $product;
    }

    // Respond with a success message
    echo "Product has been added to your cart.";
} else {
    // Respond with an error message if the request is not valid
    http_response_code(400); // Bad Request
    echo "Invalid request.";
}
