<?php
session_start();
require_once 'config.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['userID']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$userName = isset($_SESSION['fullName']) ? $_SESSION['fullName'] : '';

// Get featured books
$featuredQuery = "SELECT b.*, 
    GROUP_CONCAT(DISTINCT a.authorName SEPARATOR ', ') as authors,
    GROUP_CONCAT(DISTINCT g.genreName SEPARATOR ', ') as genres
    FROM books b
    LEFT JOIN booksAuthors ba ON b.bookID = ba.bookID
    LEFT JOIN authors a ON ba.authorID = a.authorID
    LEFT JOIN booksGenres bg ON b.bookID = bg.bookID
    LEFT JOIN genres g ON bg.genreID = g.genreID
    GROUP BY b.bookID
    ORDER BY RAND()
    LIMIT 4";
$featuredBooks = $conn->query($featuredQuery)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Library - Home</title>
    <link rel="stylesheet" href="css/design.css">
	<link rel="stylesheet" href="css/books-index.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="hero">
    <div class="hero-content">
        <h2>Your Literary Journey Starts Here!</h2>
        <p>Explore thousands of timeless classics and discover your next book</p>
    </div>
</section>

<section class="featured">
    <div class="section-header">
        <h2 class="section-title">Featured Books</h2>
        <p class="section-subtitle">Books selected from our collection</p>
    </div>
    <div class="books-grid">
        <?php foreach($featuredBooks as $book): ?>
            <div class="book-card" onclick="window.location.href='book.php?id=<?= $book['bookID'] ?>'">
                <?php if ($book['cover_image_path']): ?>
                    <img src="<?= htmlspecialchars($book['cover_image_path']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-cover">
                <?php else: ?>
                    <div class="book-cover"></div>
                <?php endif; ?>
                <div class="book-info">
                    <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                    <div class="book-author"><?= htmlspecialchars($book['authors']) ?></div>
                    <div class="book-year"><?= $book['year'] ?></div>
                    <div class="book-genres">
                        <?php 
                        $bookGenres = explode(', ', $book['genres']);
                        foreach(array_slice($bookGenres,0,3) as $genre): 
                        ?>
                            <span class="genre-tag"><?= htmlspecialchars($genre) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!--the start adventure box-->
<?php if (!$isLoggedIn): ?>
<section class="cta-section">
    <div class="cta-box">
        <h2>Start Your Reading Adventure With Us!</h2>
        <p>Join our community and build your personal digital library today!</p>
        <div class="cta-buttons">
            <a href="reg.php" class="btn btn-primary">Create Free Account</a>
            <a href="cat.php" class="btn btn-secondary">Browse Catalog...</a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'footer.php'; ?>

</body>
</html>
