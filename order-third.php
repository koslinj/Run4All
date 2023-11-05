<?php
include_once('utils/functions.php');

session_start();

if (isset($_SESSION['order'])) {
    echo "<pre>";
    var_dump($_SESSION['order']);
    echo "</pre>";
}

?>

<?php
$currentPage = 'RUN 4 ALL | Podsumowanie Zamówienia';
include_once('utils/template.php');
include_once('components/navbar.php');
?>

<h2>Podsumowanie:</h2>

<?php
include_once('components/footer.php');
?>
