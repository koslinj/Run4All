<?php
session_start();

// Clear the shopping cart by unsetting the 'cart' session variable
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

header('Location: ../cart.php');
