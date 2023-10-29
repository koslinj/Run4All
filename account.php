<?php
include_once('utils/functions.php');

session_start();

// Check if the user is authenticated
if (empty($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: login_register.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = getUserByUserId($user_id);
?>

<?php
$currentPage = 'RUN 4 ALL | Moje Konto';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="account">
    <h2>Twoje konto</h2>
    <p>Imię: <?php echo $user["name"]; ?></p>
    <p>Nazwisko: <?php echo $user["surname"]; ?></p>
    <a class="logout-link" href="utils/logout.php">Logout</a>
</main>

<?php
include_once('components/footer.php');
?>
