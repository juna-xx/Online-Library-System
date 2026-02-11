<?php
session_start();
require_once 'config.php';

/* Check Admin credentials */
$isLoggedIn = isset($_SESSION['userID']);
$isAdmin    = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (!$isLoggedIn || !$isAdmin) {
    header("Location: index.php");
    exit;
}

$userName = $_SESSION['fullName'] ?? 'Admin';

/*  Stats  */
$totalBooks   = $conn->query("SELECT COUNT(*) FROM books")->fetchColumn();
$totalAuthors = $conn->query("SELECT COUNT(*) FROM authors")->fetchColumn();
$totalGenres  = $conn->query("SELECT COUNT(*) FROM genres")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - My Library</title>
<link rel="stylesheet" href="css/admin-style.css">


</head>

<body>
<header>
    <nav>
         <a href="index.php" class="logo">
            <img  src="logo/book_logo_t.png"  alt="Library logo" class="logo-img" >
         </a>

        <ul class="nav-links">
            <li><a href="adhome.php">Dashboard</a></li>
        </ul>

        <div class="user-info">
            <span class="user-name">Hello, <?= htmlspecialchars($userName) ?>!</span>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </nav>
</header>

<main>
<section class="dashboard">
    <div class="dashboard-header">
        <h2>Admin Homepage</h2>
        <p>Manage your library efficiently</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-number"><?= $totalBooks ?></div>
            <div class="stat-label">Books</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $totalAuthors ?></div>
            <div class="stat-label">Authors</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $totalGenres ?></div>
            <div class="stat-label">Genres</div>
        </div>
    </div>

    <div class="admin-actions">
        <div class="action-card" onclick="location.href='admin_books.php'">Manage Books</div>
        <div class="action-card" onclick="location.href='admin_authors.php'">Manage Authors</div>
        <div class="action-card" onclick="location.href='admin_genres.php'">Manage Genres</div>
    </div>
</section>
</main>
<?php include 'footer.php'; ?> 

</body>
</html>
