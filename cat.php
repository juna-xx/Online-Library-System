<?php
session_start();
require_once "config.php";

$isLoggedIn = isset($_SESSION['userID']);
$userID = $isLoggedIn ? $_SESSION['userID'] : null;

// Fetch books already in user's library
$libraryBookIDs = [];
if ($isLoggedIn) {
    $stmt = $conn->prepare("SELECT bookID FROM userLibrary WHERE userID = ?");
    $stmt->execute([$userID]);
    $libraryBookIDs = $stmt->fetchAll(PDO::FETCH_COLUMN); // array of bookIDs
}

// Get search and filter
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$genreFilter = isset($_GET['genre']) ? $_GET['genre'] : '';

// Build query
$query = "SELECT b.*, 
          GROUP_CONCAT(DISTINCT a.authorName SEPARATOR ', ') AS authors,
          GROUP_CONCAT(DISTINCT g.genreName SEPARATOR ', ') AS genres
          FROM books b
          LEFT JOIN booksAuthors ba ON b.bookID = ba.bookID
          LEFT JOIN authors a ON ba.authorID = a.authorID
          LEFT JOIN booksGenres bg ON b.bookID = bg.bookID
          LEFT JOIN genres g ON bg.genreID = g.genreID
          WHERE 1=1";

$params = [];
if ($searchTerm !== '') {
    $query .= " AND (b.title LIKE ? OR a.authorName LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
}
if ($genreFilter !== '') {
    $query .= " AND EXISTS (
        SELECT 1 
        FROM booksGenres bg2
        JOIN genres g2 ON bg2.genreID = g2.genreID
        WHERE bg2.bookID = b.bookID
        AND g2.genreName = ?
    )";
    $params[] = $genreFilter;
}

$query .= " GROUP BY b.bookID ORDER BY b.title ASC";
$stmt = $conn->prepare($query);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get genres
$genres = $conn->query("SELECT DISTINCT genreName FROM genres ORDER BY genreName")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catalog - Library</title>
<link rel="stylesheet" href="css/cat-style.css">
<link rel="stylesheet" href="css/design.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <h1 class="page-title">Book Catalog</h1>

    <div class="filters">
        <form method="GET">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Search</label>
                    <input type="text" name="search" placeholder="Search by title or author..." value="<?= htmlspecialchars($searchTerm) ?>">
                </div>
                <div class="filter-group">
                    <label>Genre</label>
                    <select name="genre">
                        <option value="">All Genres</option>
                        <?php foreach($genres as $genre): ?>
                            <option value="<?= htmlspecialchars($genre['genreName']) ?>" <?= $genreFilter === $genre['genreName'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($genre['genreName']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <a href="cat.php" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>
    </div>
 
 
 
    <!--the book grid that holds the details retrieved from the db-->
    <?php if (count($books) > 0): ?>
        <div class="books-grid">
            <?php foreach($books as $book): ?>
                <div class="book-card" onclick="window.location.href='book.php?id=<?= $book['bookID'] ?>'">
                    <?php if ($book['cover_image_path']): ?>
                        <img src="<?= htmlspecialchars($book['cover_image_path']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-cover">
                    <?php else: ?>
                        <div class="book-cover"></div>
                    <?php endif; ?>

                    <div class="book-info">
                        <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                        <div class="book-author"><?= htmlspecialchars($book['authors']) ?></div>
                        <div class="book-year"><?= htmlspecialchars($book['year']) ?></div>
                        <div class="book-genres">
                            <?php foreach(array_slice(explode(', ', $book['genres']),0,3) as $genre): ?>
                                <span class="genre-tag"><?= htmlspecialchars($genre) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-results">
            <p>No books found. Try adjusting your search criteria.</p>
        </div>
    <?php endif; ?>
</div>
 
</body>
</html>
