<?php
require("../utils/admin_functions.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["type"])) {

    $type = $_GET["type"];
    $categories = getCategoriesByTypeAdmin($type);

    // Return the categories as JSON
    header('Content-Type: application/json');
    echo json_encode($categories);

    http_response_code(200);
} else {
    http_response_code(400);
}
