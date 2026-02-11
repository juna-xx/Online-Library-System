<?php
require_once 'config.php';

// Checking the login
$isLoggedIn = isset($_SESSION['userID']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$userName = isset($_SESSION['fullName']) ? $_SESSION['fullName'] : '';
?>
<header>
    <nav>
         <a href="index.php" class="logo">
            <img  src="logo/book_logo_t.png"  alt="Library logo" class="logo-img" >
         </a>
         <!--the navigation links -->
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="cat.php">Catalog</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="mine.php">My Books</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="adhome.php">Admin</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>

        <div class="user-info">
            <?php if ($isLoggedIn): ?>
                <span class="user-name">Hello, <?= htmlspecialchars($userName) ?>!</span>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-secondary">Login</a>
                <a href="reg.php" class="btn btn-primary">Get Started</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
