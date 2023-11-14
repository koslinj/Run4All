<?php
require("../utils/admin_functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["selectedProductId"]) && isset($_POST["sliderId"])) {

    $productId = $_POST["selectedProductId"];
    $sliderId = $_POST["sliderId"];

    $result = updateSliderAdmin($productId, $sliderId);

    header('Content-Type: application/json');
    echo json_encode($result);
    http_response_code(200);
} else {
    http_response_code(400);
}
