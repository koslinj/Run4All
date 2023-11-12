<?php
require("../utils/admin_functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["sizeId"])) {

    $id = $_POST["sizeId"];
    deleteSizeAdmin($id);

    http_response_code(204);
} else {
    http_response_code(400);
}
