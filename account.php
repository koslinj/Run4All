<?php
session_start();

// Check if the user is authenticated
if (empty($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: login_register.php");
    exit();
}

// If the user is logged in, you can display the content of the dashboard here
$user_id = $_SESSION['user_id'];
// Fetch user-specific data from the database if needed
?>

<?php
$currentPage = 'RUN 4 ALL | Moje Konto';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main>
    <h1>Welcome to the Dashboard</h1>
    <!-- Your dashboard content goes here -->
    <p>User ID: <?php echo $user_id; ?></p>
    <a href="utils/logout.php">Logout</a>
</main>

<?php
include_once('components/footer.php');
?>
