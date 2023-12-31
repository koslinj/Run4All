<?php
require("utils/db.php");
require("utils/functions.php");

session_start();

// Check if user is logged in
if (!empty($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['errorLogin'])) {
    $errorLogin = $_GET["errorLogin"];
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['errorRegister'])) {
    $errorRegister = $_GET["errorRegister"];
    if($errorRegister == "Udało się zarejestrować!"){
        unset($errorRegister);
        $success = "Udało się zarejestrować!";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // User clicked the registration button
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);

        // Validate user input - perform additional validation as needed
        if (!preg_match('/^[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+$/', $name)) {
            $errorRegister = "Nieprawidłowe Imie!";
            header("Location: login_register.php?errorRegister=" . urlencode($errorRegister));
            exit();
        } elseif (!preg_match('/^[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+$/', $surname)) {
            $errorRegister = "Nieprawidłowe Nazwisko!";
            header("Location: login_register.php?errorRegister=" . urlencode($errorRegister));
            exit();
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorRegister = "Nieprawidłowy Adres Email!";
            header("Location: login_register.php?errorRegister=" . urlencode($errorRegister));
            exit();
        } elseif (strlen($password) < 5){
            $errorRegister = "Za krótkie hasło!";
            header("Location: login_register.php?errorRegister=" . urlencode($errorRegister));
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (password_email, password, name, surname, role) VALUES (:email, :password, :name, :surname, 'user')";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);

        try{
            $stmt->execute();
            $errorRegister = "Udało się zarejestrować!";
            header("Location: login_register.php?errorRegister=" . urlencode($errorRegister));
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == '23000'){
                $errorRegister = "Taki email już istnieje!";
                header("Location: login_register.php?errorRegister=" . urlencode($errorRegister));
                exit();
            } else{
                $errorRegister = "Nieznany błąd!";
                header("Location: login_register.php?errorRegister=" . urlencode($errorRegister));
                exit();
            }
        }


    } elseif (isset($_POST['login'])) {
        // User clicked the login button
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];

        // Validate user input - perform additional validation as needed

        $sql = "SELECT userId, password, role FROM users WHERE password_email = :email";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);

        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($password, $row['password'])) {
                // Successful login
                $_SESSION['user_id'] = $row['userId'];
                $_SESSION['role'] = $row['role'];

                if ($_SESSION['role'] === 'admin') {
                    header("Location: admin-panel.php");
                    exit();
                }

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
                $errorLogin = "Nieprawidłowy email lub hasło!";
                header("Location: login_register.php?errorLogin=" . urlencode($errorLogin));
                exit();
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
                <?php if(isset($errorLogin)): ?>
                    <h4 style="color: red; text-align: center"><?= $errorLogin ?></h4>
                <?php endif; ?>
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
                <?php if(isset($errorRegister)): ?>
                    <h4 style="color: red; text-align: center"><?= $errorRegister ?></h4>
                <?php endif; ?>
                <?php if(isset($success)): ?>
                    <h4 style="background-color: #9AFF91; text-align: center; padding: 10px; margin: 10px auto; border: 3px solid black">
                        <?= $success ?>
                    </h4>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <script>
        // Check if the error parameter is present in the URL
        if (window.location.search.includes("errorLogin=")) {
            // Use the history.replaceState method to remove the error parameter
            const newUrl = window.location.href.replace(/\?errorLogin=[^&]*/, '');
            history.replaceState({}, document.title, newUrl);
        }
        // Check if the error parameter is present in the URL
        if (window.location.search.includes("errorRegister=")) {
            // Use the history.replaceState method to remove the error parameter
            const newUrl = window.location.href.replace(/\?errorRegister=[^&]*/, '');
            history.replaceState({}, document.title, newUrl);
        }
    </script>
</main>

<?php
include_once('components/footer.php');
?>

