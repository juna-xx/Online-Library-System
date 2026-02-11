<?php
// to record and display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config.php';

// check if user is logged in
$isLoggedIn = isset($_SESSION['userID']);
$userID = $isLoggedIn ? $_SESSION['userID'] : null;

// get book ID from URL
$bookID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// part needed for the set status button
// handle status update if user selects a status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_status']) && $isLoggedIn) {
    $status = $_POST['reading_status'];
    $startDate = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
    $endDate = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    
    // check if book already in user library
    $checkStmt = $conn->prepare("SELECT user_libraryID FROM userLibrary WHERE userID = ? AND bookID = ?");
    $checkStmt->execute([$userID, $bookID]);
    
    if ($checkStmt->fetch()) {
        // update existing entry in userLibrary with the chosen status
        $updateStmt = $conn->prepare("UPDATE userLibrary SET reading_status = ?, reading_start_date = ?, reading_end_date = ? WHERE userID = ? AND bookID = ?");
        $updateStmt->execute([$status, $startDate, $endDate, $userID, $bookID]);
    } else {
        // insert new entry into userLibrary
        $insertStmt = $conn->prepare("INSERT INTO userLibrary (userID, bookID, reading_status, reading_start_date, reading_end_date) VALUES (?, ?, ?, ?, ?)");
        $insertStmt->execute([$userID, $bookID, $status, $startDate, $endDate]);
    }
    
    header("Location: book.php?id=$bookID&success=1");
    exit;
}

// handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review']) && $isLoggedIn) {
    $reviewText = trim($_POST['review_text']);
    if (!empty($reviewText)) {  // checking to make sure that user didn't leave text field empty
        // insert new review
        $insertReviewStmt = $conn->prepare("INSERT INTO reviews (userID, bookID, review_text) VALUES (?, ?, ?)");
        $insertReviewStmt->execute([$userID, $bookID, $reviewText]);
        
        header("Location: book.php?id=$bookID&review_success=1");
        exit;
    } else {
        header("Location: book.php?id=$bookID&review_error=1");
        exit;
    }
}

// fetch book details with author and genres
$bookStmt = $conn->prepare("
    SELECT b.*, 
           a.authorName,
           a.authorID,
           a.author_external_link,
           GROUP_CONCAT(DISTINCT g.genreName SEPARATOR ', ') as genres
    FROM books b
    LEFT JOIN booksAuthors ba ON b.bookID = ba.bookID
    LEFT JOIN authors a ON ba.authorID = a.authorID
    LEFT JOIN booksGenres bg ON b.bookID = bg.bookID
    LEFT JOIN genres g ON bg.genreID = g.genreID
    WHERE b.bookID = ?
    GROUP BY b.bookID
");
$bookStmt->execute([$bookID]);
$book = $bookStmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Book not found");
}

// getting user's current status for this book
$currentStatus = null;
if ($isLoggedIn) {
    $statusStmt = $conn->prepare("SELECT reading_status FROM userLibrary WHERE userID = ? AND bookID = ?");
    $statusStmt->execute([$userID, $bookID]);
    $statusResult = $statusStmt->fetch(PDO::FETCH_ASSOC);
    $currentStatus = $statusResult ? $statusResult['reading_status'] : null;
}

// needed to decide whether to display write review field to user or not
// checking if user already reviewed this book
$hasReviewed = false;
if ($isLoggedIn) {
    $userReviewStmt = $conn->prepare("SELECT reviewID FROM reviews WHERE userID = ? AND bookID = ?");
    $userReviewStmt->execute([$userID, $bookID]);
    $hasReviewed = $userReviewStmt->fetch() ? true : false;
}

// fetch reviews (2 most recent)
$reviewsStmt = $conn->prepare("
    SELECT r.*, u.fullName 
    FROM reviews r
    JOIN users u ON r.userID = u.userID
    WHERE r.bookID = ?
    ORDER BY r.review_created_at DESC
    LIMIT 2
");
$reviewsStmt->execute([$bookID]);
$reviews = $reviewsStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - Library</title>
    <link rel="stylesheet" href="css/design.css">
    <link rel="stylesheet" href="css/book.css">   
</head>
<body>
    <?php include 'header.php'; ?>

	<!-- success and error messages -->
    <div class="container">
        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">Status updated successfully!</div>
        <?php endif; ?>
        
        <?php if (isset($_GET['review_success'])): ?>
            <div class="success-message">Review submitted successfully!</div>
        <?php endif; ?>
        
        <?php if (isset($_GET['review_error'])): ?>
            <div class="error-message">Please write a review before submitting.</div>
        <?php endif; ?>

        <!-- Book Details -->
        <div class="book-details">
            <div class="book-cover-section">
                <img src="<?php echo htmlspecialchars($book['cover_image_path'] ?: 'images/default.jpg'); ?>" 
                     alt="<?php echo htmlspecialchars($book['title']); ?>" 
                     class="book-cover">
                <?php if ($book['authorName']): ?>
                    <a href="<?php echo htmlspecialchars($book['author_external_link'] ?: '#'); ?>" 
                       target="_blank" 
                       class="author-link">
                        <?php echo htmlspecialchars($book['authorName']); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="book-info">
                <h1 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h1>
                
                <div class="book-meta">
                    <span><strong>Year:</strong> <?php echo htmlspecialchars($book['year']); ?></span>
                    <span><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></span>
                </div>

                <?php if ($book['genres']): ?>
                <div class="genres">
                    <?php foreach (explode(', ', $book['genres']) as $genre): ?>
                        <span class="genre-tag"><?php echo htmlspecialchars($genre); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="book-description">
                    <?php echo htmlspecialchars($book['description']); ?>
                </div>
		
		<!-- displaying this only if user is logged in -->
                <?php if ($isLoggedIn): ?>
                <div class="status-section">
                    <button class="set-status-btn" onclick="toggleDropdown()">
                        <?php echo $currentStatus ? 'Update Status' : 'Set Status'; ?>
                    </button>
                    <div class="status-dropdown" id="statusDropdown">
                        <div class="status-option" onclick="setStatus('READ')">Finished</div>
                        <div class="status-option" onclick="setStatus('READING')">Reading</div>
                        <div class="status-option" onclick="setStatus('TBR')">To Be Read</div>
                    </div>
                </div>
                <?php else: ?>
                <p style="color: #999; font-style: italic; margin-top: 1rem;">Please log in to add this book to your library.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-section">
            <h2>Reviews</h2>
		
		<!-- user can leave a review only if logged in and if he hasn't reviewed before -->
            <?php if ($isLoggedIn && !$hasReviewed): ?>
            <div class="review-prompt" onclick="toggleReviewForm()">
                <p>Leave your review on this book...</p>
            </div>

            <form method="POST" class="review-form" id="reviewForm" action="book.php?id=<?php echo $bookID; ?>">
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <div class="form-group">
                    <textarea name="review_text" placeholder="Write your review here..." required></textarea>
                </div>
                <div class="form-buttons">
                    <button type="submit" name="submit_review" class="submit-btn">Submit Review</button>
                    <button type="button" class="cancel-btn" onclick="toggleReviewForm()">Cancel</button>
                </div>
            </form>
            <?php elseif ($isLoggedIn && $hasReviewed): ?>
            <p style="color: #666; font-style: italic; text-align: center; padding: 1rem; background: #f0f0f0; border-radius: 8px;">You have already reviewed this book.</p>
            <?php else: ?>
            <p style="color: #999; font-style: italic;">Please log in to leave a review.</p>
            <?php endif; ?>

            <?php if (count($reviews) > 0): ?>
                <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <div class="review-header">
                        <span class="review-author"><?php echo htmlspecialchars($review['fullName']); ?></span>
                        <span class="review-date"><?php echo date('F j, Y', strtotime($review['review_created_at'])); ?></span>
                    </div>
                    <div class="review-text">
                        <?php echo nl2br(htmlspecialchars($review['review_text'])); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #999; font-style: italic; text-align: center; padding: 2rem 0;">No reviews yet. Be the first to review this book!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Date Modal -->
    <div class="modal" id="dateModal">
        <div class="modal-content">
            <h3>Set Reading Dates</h3>
            <form method="POST" id="dateForm" action="book.php?id=<?php echo $bookID; ?>">
                <input type="hidden" name="reading_status" id="modalStatus">
                <div class="form-group">
                    <label>Start Date (optional):</label>
                    <input type="date" name="start_date">
                </div>
                <div class="form-group">
                    <label>End Date (optional):</label>
                    <input type="date" name="end_date">
                </div>
                <div class="form-buttons">
                    <button type="submit" name="set_status" class="submit-btn">Submit</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="js/book.js"></script>
</body>
</html>
