<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['userID'];
$userName = $_SESSION['fullName'];
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Handle book removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeBookID'])) {
    $removeBookID = $_POST['removeBookID'];

    // Make sure the book belongs to the current user
    $stmtCheck = $conn->prepare("SELECT * FROM userLibrary WHERE userID = ? AND bookID = ?");
    $stmtCheck->execute([$userID, $removeBookID]);
    $bookExists = $stmtCheck->fetch();

    if ($bookExists) {
        $stmt = $conn->prepare("DELETE FROM userLibrary WHERE userID = ? AND bookID = ?");
        $stmt->execute([$userID, $removeBookID]);
        // Refresh the page to see changes
        $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
        header("Location: mine.php" . ($statusFilter ? "?status=$statusFilter" : ""));
        exit();
    }
}

// Get user's books with filters
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

$query = "SELECT b.*, ul.reading_status, ul.reading_start_date, ul.reading_end_date,
          GROUP_CONCAT(DISTINCT a.authorName SEPARATOR ', ') as authors,
          GROUP_CONCAT(DISTINCT g.genreName SEPARATOR ', ') as genres,
          ul.user_libraryID
          FROM userLibrary ul
          JOIN books b ON ul.bookID = b.bookID
          LEFT JOIN booksAuthors ba ON b.bookID = ba.bookID
          LEFT JOIN authors a ON ba.authorID = a.authorID
          LEFT JOIN booksGenres bg ON b.bookID = bg.bookID
          LEFT JOIN genres g ON bg.genreID = g.genreID
          WHERE ul.userID = ?";

$params = [$userID];

if ($statusFilter) {
    $query .= " AND ul.reading_status = ?";
    $params[] = $statusFilter;
}

$query .= " GROUP BY b.bookID ORDER BY ul.reading_status, b.title";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get counts
$tbrCount = $conn->prepare("SELECT COUNT(*) as count FROM userLibrary WHERE userID = ? AND reading_status = 'TBR'");
$tbrCount->execute([$userID]);
$tbrCount = $tbrCount->fetch()['count'];

$readingCount = $conn->prepare("SELECT COUNT(*) as count FROM userLibrary WHERE userID = ? AND reading_status = 'READING'");
$readingCount->execute([$userID]);
$readingCount = $readingCount->fetch()['count'];

$readCount = $conn->prepare("SELECT COUNT(*) as count FROM userLibrary WHERE userID = ? AND reading_status = 'READ'");
$readCount->execute([$userID]);
$readCount = $readCount->fetch()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Books - Library</title>
    <link rel="stylesheet" href="css/design.css">       
    <link rel="stylesheet" href="css/mine-style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1 class="page-title">My Books</h1>

        <!-- Add Book Button -->
        <div style="text-align: right; margin-bottom: 1.5rem;">
            <a href="cat.php" class="btn btn-primary">+ Add Book</a>
        </div>

        <div class="stats">
            <a href="mine.php?status=TBR" class="stat-card <?= $statusFilter==='TBR'?'active':'' ?>">
                <div class="stat-number"><?= $tbrCount ?></div>
                <div class="stat-label">To Be Read</div>
            </a>

            <a href="mine.php?status=READING" class="stat-card <?= $statusFilter==='READING'?'active':'' ?>">
                <div class="stat-number"><?= $readingCount ?></div>
                <div class="stat-label">Currently Reading</div>
            </a>

            <a href="mine.php?status=READ" class="stat-card <?= $statusFilter==='READ'?'active':'' ?>">
                <div class="stat-number"><?= $readCount ?></div>
                <div class="stat-label">Finished</div>
            </a>

            <a href="mine.php" class="stat-card <?= $statusFilter===''?'active':'' ?>">
                <div class="stat-number"><?= $tbrCount + $readingCount + $readCount ?></div>
                <div class="stat-label">All Books</div>
            </a>
        </div>

        <?php if (count($books) > 0): ?>
            <div class="books-grid">
                <?php foreach($books as $book): ?>
                    <div class="book-card">
                        <?php if ($book['cover_image_path']): ?>
                            <img src="<?= htmlspecialchars($book['cover_image_path']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-cover">
                        <?php else: ?>
                            <div class="book-cover"></div>
                        <?php endif; ?>

                        <!-- Remove Book Button -->
                        <form method="POST" style="position:absolute; top:0; right:0;">
                            <input type="hidden" name="removeBookID" value="<?= $book['bookID'] ?>">
                            <button type="submit" class="remove-btn" title="Remove">×</button>
                        </form>

                        <div class="book-info" onclick="window.location.href='book.php?id=<?= $book['bookID'] ?>'">
                            <span class="status-badge status-<?= strtolower($book['reading_status']) ?>">
                                <?= $book['reading_status']==='TBR'?'To Be Read':$book['reading_status'] ?>
                            </span>
                            <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                            <div class="book-author"><?= htmlspecialchars($book['authors']) ?></div>
                            <div class="book-year"><?= $book['year'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-books">
                <p>You haven't added any books yet.</p>
                <p><a href="cat.php">Browse the catalog</a> to add books to your library!</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
