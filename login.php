<?php
session_start();
require_once "config.php";

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
	
    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            // Login success
            $_SESSION["userID"]   = $user["userID"];
            $_SESSION["fullName"] = $user["fullName"];
            $_SESSION["role"]     = $user["role"];

            // Redirection based on role
            if ($user["role"] === "admin") {
                header("Location: adhome.php");
                exit;
            } else {
                header("Location: mine.php");
                exit;
            }
        } else {
            $login_error = "Invalid email or password.";
        }
    } else {
        $login_error = "Please fill in all the fields.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Login</title>
    <link rel="stylesheet" href="css/style.css">
	
</head>
<body>

<div class="container">
    <h2>Library Login</h2>

    <!-- error message -->
    <?php if (!empty($login_error)): ?>
        <p style="color:red; margin-bottom:10px;">
            <?= htmlspecialchars($login_error) ?>
        </p>
    <?php endif; ?>
    <!--the form-->
    <form 
        method="POST"
        action="login.php"
        onsubmit="return validateLogin();"
    >
        <div class="input-group">
            <label>Email</label>
            <input 
                type="email" 
                name="email"
                id="loginEmail" 
                placeholder="Enter your email:"
                required
            >
        </div>

        <div class="input-group">
            <label>Password</label>
            <input 
                type="password" 
                name="password"
                id="loginPassword" 
                placeholder="Enter your password:"
                required
            >
        </div>

        <p id="loginMsg"></p>

        <button type="submit">Login</button>
    </form>
    <!--rederecting links-->
    <div class="link">
        <p>Don't have an account? <a href="reg.php">Register</a></p>

	        <p class="back-home">
            <a href="index.php">← Back to Home</a>
        </p>

</div>

<script src="script.js"></script>
</body>
</html>
