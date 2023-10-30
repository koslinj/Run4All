<?php
require("utils/db.php");
require("utils/functions.php");

session_start();

// Check if user is logged in
if (!empty($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // User clicked the registration button
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        // Validate user input - perform additional validation as needed

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (password_email, password, name, surname) VALUES (:email, :password, :name, :surname)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);

        try {
            $stmt->execute();
            echo "Registration successful. You can now log in.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['login'])) {
        // User clicked the login button
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];

        // Validate user input - perform additional validation as needed

        $sql = "SELECT userId, password FROM users WHERE password_email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);

        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($password, $row['password'])) {
                // Successful login
                $_SESSION['user_id'] = $row['userId'];
                if (isset($_SESSION['cart'])) {
                    $cart = $_SESSION["cart"];
                    saveCartFromSession($cart, $row['userId']);
                }else{
                    $_SESSION["cart"] = getCartByUserId($row['userId']);
                }
                header("Location: account.php");
                exit();
            } else {
                // Invalid login
                echo "Invalid email or password.";
            }
        } catch (PDOException $e) {
            // Login failed
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<?php
$currentPage = 'RUN 4 ALL | Logowanie';
include_once('utils/template.php');
include_once('components/navbar.php');
?>


<main class="login_register">
    <h2>Zaloguj się</h2>
    <div class="container">
        <div class="panel">
            <p>Mam już konto</p>
            <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="login_email">Email:</label>
                <input id="login_email" type="email" name="login_email" required><br>

                <label for="login_password">Hasło:</label>
                <input id="login_password" type="password" name="login_password" required><br>

                <button type="submit" name="login">
                    <img src="images/login_icon.png" alt="Login Icon" width="30px">
                    Zaloguj się
                </button>
            </form>
        </div>
        <div class="panel">
            <p>Jestem nowym użytkownikiem</p>
            <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="name">Imię:</label>
                <input id="name" type="text" name="name" required><br>

                <label for="surname">Nazwisko:</label>
                <input id="surname" type="text" name="surname" required><br>

                <label for="email">Email:</label>
                <input id="email" type="email" name="email" required><br>

                <label for="password">Hasło:</label>
                <input id="password" type="password" name="password" required><br>

                <button type="submit" name="register">
                    <img src="images/login_icon.png" alt="Login Icon" width="30px">
                    Utwórz konto
                </button>
            </form>
        </div>
    </div>
</main>

<?php
include_once('components/footer.php');
?>

