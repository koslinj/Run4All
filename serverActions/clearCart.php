<?php
require("../utils/functions.php");
session_start();

// Clear the shopping cart by unsetting the 'cart' session variable
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

if (isset($_SESSION['user_id'])) {
    clearCartInDb($_SESSION['user_id']);
}

header('Location: ../cart.php');
