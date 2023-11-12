<?php
require("../utils/admin_functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["status"]) && isset($_POST["orderId"])) {

    $status = $_POST["status"];
    $id = $_POST["orderId"];

    updateStatusAdmin($status, $id);

    http_response_code(200);
} else {
    http_response_code(400);
}
