<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$bookID = $_GET['id'];

try {
    $query = "DELETE FROM books WHERE bookID = :bookID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':bookID', $bookID);
    $result = $stmt->execute();
    
    if ($result) {
        header("Location: admin_books.php?success=1");
    } else {
        header("Location: admin_books.php?error=1");
    }
} catch (PDOException $ex) {
    die($ex->getMessage());
}
?>
