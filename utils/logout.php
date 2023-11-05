<?php
session_start();

// Delete the user id
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}

if (isset($_SESSION['order'])) {
    unset($_SESSION['order']);
}

// Redirect to the login page
header("Location: ../login_register.php");
exit();
?>
