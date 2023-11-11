<?php
require("../utils/admin_functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["productId"])) {

    $id = $_POST["productId"];
    deleteProductAdmin($id);

    http_response_code(204);
} else {
    http_response_code(400);
}
