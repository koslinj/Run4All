<?php
require_once("db.php");
function getProductByName(string $productName)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE productName = :product");
    $stmt->bindParam(':product', $productName);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $product[0];
}

function getProductByProductId(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $product[0];
}

function getCategoriesByProductId(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT c.category, c.type FROM categories AS c JOIN products_categories AS pc ON c.categoryId = pc.categoryId WHERE pc.productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

function getSizesByProductId(int $productId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT size FROM sizes WHERE productId = :id");
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sizes;
}

function getProducerByProducerId(int $producerId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM producers WHERE producerId = :id");
    $stmt->bindParam(':id', $producerId);
    $stmt->execute();
    $prooducers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $prooducers[0];
}

function getUserByUserId(int $userId)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users[0];
}

function getAddressesByUserId(int $userId)
{
    global $conn;
    $sql = "SELECT * FROM addresses WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $addresses;
}

function getAddressByAddressId(int $addressId)
{
    global $conn;
    $sql = "SELECT * FROM addresses WHERE addressId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $addressId);
    $stmt->execute();
    $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $addresses[0];
}

function getContactsByUserId(int $userId, $type)
{
    global $conn;
    $sql = "SELECT * FROM contacts WHERE userId = :id AND type = :type";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $contacts;
}

function getOrdersByNameAndSurname($name, $surname)
{
    global $conn;
    $sql = "SELECT * FROM orders WHERE name = :name AND surname = :surname ORDER BY date desc";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':surname', $surname);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $orders;
}

function getDetailsByOrderId($id)
{
    global $conn;
    $sql = "SELECT * FROM details WHERE orderId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $details;
}

function createQuery($type): array
{
    $whereClause = "";
    $params = array();

    // Check for category parameter
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $whereClause .= "c.category = :category AND ";
        $params[':category'] = $category;
    }

    // Check for producer parameter
    if (isset($_GET['producer'])) {
        $producer = $_GET['producer'];
        $whereClause .= "pr.producer = :producer AND ";
        $params[':producer'] = $producer;
    }

    // Check for size parameter
    if (isset($_GET['size'])) {
        $size = $_GET['size'];
        $whereClause .= "s.size = :size AND ";
        $params[':size'] = $size;
    }

    $whereClause .= "c.type = :type AND ";
    $params[':type'] = $type;

    $whereClause = rtrim($whereClause, 'AND ');

    $sql = "SELECT p.*, pr.path as producerPath FROM products as p";

    $sql .= " JOIN products_categories as pc ON p.productId = pc.productId 
JOIN categories as c ON pc.categoryId = c.categoryId
JOIN producers as pr ON pr.producerId = p.producerId
JOIN sizes as s ON s.productId = p.productId";

    if (!empty($whereClause)) {
        $sql .= " WHERE $whereClause";
    }
    return array($params, $sql);
}

function getProducts($params, $sql)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $originalArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $uniqueProductIds = [];
    $products = [];

    foreach ($originalArray as $item) {
        $productId = $item['productId'];

        // Check if the product ID is not already in the list of unique product IDs
        if (!in_array($productId, $uniqueProductIds)) {
            $products[] = $item; // Add the item to the filtered array
            $uniqueProductIds[] = $productId; // Add the product ID to the list of unique IDs
        }
    }
    return $products;
}

function getCartByUserId(int $userId)
{
    global $conn;
    $sql = "SELECT p.productId, p.productName, p.price, p.path, c.quantity, c.size
            FROM carts as c JOIN products p on p.productId = c.productId 
            WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $cart;
}

function clearCartInDb(int $userId)
{
    global $conn;
    $sql = "DELETE FROM carts WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
}

function saveCartFromSession($cart, int $userId)
{
    global $conn;
    $sql = "DELETE FROM carts WHERE userId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    foreach ($cart as $product){
        $sql = "INSERT INTO carts(userId, productId, quantity, size) VALUES(:userId, :productId, :quantity, :size)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':productId', $product["productId"]);
        $stmt->bindParam(':quantity', $product["quantity"]);
        $stmt->bindParam(':size', $product["size"]);
        $stmt->execute();
    }
}

function updateAddress(int $addressId, $town, $street, $number)
{
    global $conn;
    $sql = "UPDATE addresses SET town = :town, street = :street, number = :number WHERE addressId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $addressId);
    $stmt->bindParam(':town', $town);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':number', $number);
    $stmt->execute();
}

function deleteAddress(int $id)
{
    global $conn;
    $sql = "DELETE FROM addresses WHERE addressId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deleteContact(int $id)
{
    global $conn;
    $sql = "DELETE FROM contacts WHERE contactId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function updateContact(int $contactId, $value)
{
    global $conn;
    $sql = "UPDATE contacts SET value = :value WHERE contactId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $contactId);
    $stmt->bindParam(':value', $value);
    $stmt->execute();
}

function insertAddress(int $userId, $town, $street, $number, $type)
{
    global $conn;
    $sql = "INSERT INTO addresses(userId, town, street, number, type) VALUES(:id, :town, :street, :number, :type)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->bindParam(':town', $town);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':number', $number);
    $stmt->bindParam(':type', $type);
    $stmt->execute();
}

function insertContact(int $userId, $value, $type)
{
    global $conn;
    $sql = "INSERT INTO contacts(userId, value, type) VALUES(:id, :value, :type)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->bindParam(':value', $value);
    $stmt->bindParam(':type', $type);
    $stmt->execute();
}

function insertOrder($order, $sum)
{
    global $conn;
    $sql = "INSERT INTO orders
    (name, surname, email, phone, town, street, number, value, status, payment, deliverer)
    VALUES(:name, :surname, :email, :phone, :town, :street, :number, :value, 'przetwarzane', :payment, :deliverer)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $order["name"]);
    $stmt->bindParam(':surname', $order["surname"]);
    $stmt->bindParam(':email', $order["email"]);
    $stmt->bindParam(':phone', $order["phone"]);
    $stmt->bindParam(':town', $order["town"]);
    $stmt->bindParam(':street', $order["street"]);
    $stmt->bindParam(':number', $order["number"]);
    $stmt->bindParam(':value', $sum);
    $stmt->bindParam(':payment', $order["payment"]);
    $stmt->bindParam(':deliverer', $order["deliverer"]);
    $stmt->execute();

    return $conn->lastInsertId();
}

function insertOrderDetails($cart, $orderId)
{
    global $conn;
    $sql = "INSERT INTO details(orderId, productName, quantity, price, size)
    VALUES(:orderId, :productName, :quantity, :price, :size)";

    foreach ($cart as $product){
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':productName', $product["productName"]);
        $stmt->bindParam(':quantity', $product["quantity"]);
        $stmt->bindParam(':price', $product["price"]);
        $stmt->bindParam(':size', $product["size"]);
        $stmt->execute();
    }
}

function getAllCategories($type)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM categories WHERE type = :type");
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

function getAllProducers()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM producers");
    $stmt->execute();
    $producers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $producers;
}

function getAllSizes($type)
{
    global $conn;
    $stmt = $conn->prepare("SELECT DISTINCT size FROM sizes WHERE type = :type ORDER BY size");
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $sizes;
}

function getAllDeliverers()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM deliverers");
    $stmt->execute();
    $deliverers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $deliverers;
}

function getAllPayments()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM payments");
    $stmt->execute();
    $deliverers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $deliverers;
}
