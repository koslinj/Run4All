<?php
$servername = "localhost";
$port = 3308;
$dbname = "iab_240712";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

