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
//$temp = [
//    'variation1' => [
//        'size' => 'Small',
//        'color' => 'Red',
//        'price' => 19.99,
//    ],
//    'variation2' => [
//        'size' => 'Medium',
//        'color' => 'Blue',
//        'price' => 24.99,
//    ],
//];
//$_SESSION['bracket'] = $temp;
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION["cart"];
}

?>

<?php
$currentPage = 'RUN 4 ALL | Koszyk';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<main class="cart">
    <h2>Koszyk</h2>
    <?php
    if (isset($cart)){
        foreach ($cart as $item){
            foreach ($item as $k => $v){
                echo $k . " " . $v . "<br>";
            }
            echo "<br>";
        }
    }
    ?>
    <a href="serverActions/clearCart.php">Clear Cart</a>
    <a class="logout-link" href="utils/logout.php">Logout</a>
    <script src="jsActions/cart.js"></script>
</main>

<?php
include_once('components/footer.php');
?>

