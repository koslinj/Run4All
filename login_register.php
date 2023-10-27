<?php
require("utils/db.php");
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


<main>
    <h2>Registration</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="surname">Surname:</label>
        <input type="text" name="surname" required><br>

        <button type="submit" name="register">Register</button>
    </form>

    <h2>Login</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="login_email">Email:</label>
        <input type="email" name="login_email" required><br>

        <label for="login_password">Password:</label>
        <input type="password" name="login_password" required><br>

        <button type="submit" name="login">Login</button>
    </form>
</main>

<?php
include_once('components/footer.php');
?>

