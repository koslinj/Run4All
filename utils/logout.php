<?php
session_start();

// Destroy the session and log the user out
session_destroy();

// Redirect to the login page
header("Location: ../login_register.php");
exit();
?>
