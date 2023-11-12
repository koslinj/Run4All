<?php
require("../utils/admin_functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["productId"]) && isset($_POST["size"]) && isset($_POST["type"])) {

    $id = $_POST["productId"];
    $size = $_POST["size"];
    $type = $_POST["type"];
    $insertId = insertOneSizeAdmin($id, $size, $type);

    http_response_code(200);
    echo $insertId;
} else {
    http_response_code(400);
}
