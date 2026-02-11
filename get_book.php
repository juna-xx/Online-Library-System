<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$bookID = $_GET['id'];

try {
    // get book details
    $query = "SELECT * FROM books WHERE bookID = :bookID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':bookID', $bookID);
    $stmt->execute();
    
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // get book's author
    $authorQuery = "SELECT authorID FROM booksAuthors WHERE bookID = :bookID";
    $authorStmt = $conn->prepare($authorQuery);
    $authorStmt->bindParam(':bookID', $bookID);
    $authorStmt->execute();
    
    $authorRow = $authorStmt->fetch(PDO::FETCH_ASSOC);
    $book['authorID'] = $authorRow ? $authorRow['authorID'] : null;
    
    header('Content-Type: application/json');
    echo json_encode($book);
} catch (PDOException $ex) {
    die($ex->getMessage());
}
?>
