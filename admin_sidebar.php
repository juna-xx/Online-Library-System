<?php
// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<div class="admin-sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="admin_genres.php">Genres</a></li>
        <li><a href="admin_authors.php">Authors</a></li>
        <li><a href="admin_books.php">Books</a></li>
    </ul>
</div>
