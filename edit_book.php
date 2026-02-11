<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$bookID = $_POST['bookID'];
$title = $_POST['title'];
$year = $_POST['year'];
$isbn = $_POST['isbn'];
$description = $_POST['description'];
$coverImage = $_POST['cover_image_path'];
$authorID = $_POST['authorID'];

try {
    // start transaction
    $conn->beginTransaction();
    
    // update book
    $query = "UPDATE books SET title = :title, year = :year, isbn = :isbn, 
              description = :description, cover_image_path = :coverImage 
              WHERE bookID = :bookID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':coverImage', $coverImage);
    $stmt->bindParam(':bookID', $bookID);
    $stmt->execute();
    
    // delete existing author relationship
    $deleteAuthorQuery = "DELETE FROM booksAuthors WHERE bookID = :bookID";
    $deleteAuthorStmt = $conn->prepare($deleteAuthorQuery);
    $deleteAuthorStmt->bindParam(':bookID', $bookID);
    $deleteAuthorStmt->execute();
    
    // insert new author relationship
    if (!empty($authorID)) {
        $authorQuery = "INSERT INTO booksAuthors(bookID, authorID) VALUES (:bookID, :authorID)";
        $authorStmt = $conn->prepare($authorQuery);
        $authorStmt->bindParam(':bookID', $bookID);
        $authorStmt->bindParam(':authorID', $authorID);
        $authorStmt->execute();
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
