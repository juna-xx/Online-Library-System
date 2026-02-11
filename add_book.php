<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$title = $_POST['title'];
$year = $_POST['year'];
$isbn = $_POST['isbn'];
$description = $_POST['description'];
$coverImage = $_POST['cover_image_path'];
$authorID = $_POST['authorID'];
$genreID = $_POST['genreID'];

try {
    // start transaction
    $conn->beginTransaction();
    
    // insert book
    $query = "INSERT INTO books(title, year, isbn, description, cover_image_path) 
              VALUES (:title, :year, :isbn, :description, :coverImage)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':coverImage', $coverImage);
    $stmt->execute();
    
    // get the new book ID
    $bookID = $conn->lastInsertId();
    
    // insert book-author relationship
    if (!empty($authorID)) {
        $authorQuery = "INSERT INTO booksAuthors(bookID, authorID) VALUES (:bookID, :authorID)";
        $authorStmt = $conn->prepare($authorQuery);
        $authorStmt->bindParam(':bookID', $bookID);
        $authorStmt->bindParam(':authorID', $authorID);
        $authorStmt->execute();
    }
    
    // insert book-genre relationship
    if (!empty($genreID)) {
        $genreQuery = "INSERT INTO booksGenres(bookID, genreID) VALUES (:bookID, :genreID)";
        $genreStmt = $conn->prepare($genreQuery);
        $genreStmt->bindParam(':bookID', $bookID);
        $genreStmt->bindParam(':genreID', $genreID);
        $genreStmt->execute();
    }
    
    // commit transaction
    $conn->commit();
    
    header("Location: admin_books.php?success=1");
} catch (PDOException $ex) {
    // rollback transaction on error
    $conn->rollBack();
    die($ex->getMessage());
}
?>
