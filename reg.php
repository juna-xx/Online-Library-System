<?php
session_start();
require_once "config.php";

$register_error = "";
$register_success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = trim($_POST["fullName"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $register_error = "Please fill in all the fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $register_error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirmPassword) {
        $register_error = "Passwords do not match.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT userID FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $register_error = "Email already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (fullName, email, password, role) VALUES (?, ?, ?, 'user')"
            );

            if ($stmt->execute([$fullName, $email, $hashedPassword])) {
                $register_success = "Registration successful! You can now login.";
            } else {
                $register_error = "Something went wrong. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h2>Library Register</h2>

    <!-- Message for an error -->
    <?php if (!empty($register_error)): ?>
        <p style="color:red; margin-bottom:10px;">
            <?= htmlspecialchars($register_error) ?>
        </p>
    <?php endif; ?>

    <!-- Message of success -->
    <?php if (!empty($register_success)): ?>
        <p style="color:green; margin-bottom:10px;">
            <?= htmlspecialchars($register_success) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="reg.php" onsubmit="return validateRegister();">
        <div class="input-group">
            <label>Full Name</label>
            <input type="text" name="fullName" placeholder="Enter your full name:" required value="<?= isset($_POST['fullName']) ? htmlspecialchars($_POST['fullName']) : '' ?>">
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email"
                placeholder="Enter your email:"  required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password"  name="password" placeholder="Enter your password:" required>
        </div>

        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="confirmPassword" placeholder="Confirm your password:" required >
        </div>
       <p id="registerMsg"></p>
        <button type="submit">Register</button>
    </form>

    <div class="link">
        <p>Already have an account? <a href="login.php">Login</a></p>

        <p class="back-home">
            <a href="index.php">← Back to Home</a>
        </p>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
