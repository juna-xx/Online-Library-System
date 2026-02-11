<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$authorID = $_GET['id'];

try {
    $query = "DELETE FROM authors WHERE authorID = :authorID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':authorID', $authorID);
    $result = $stmt->execute();
    
    if ($result) {
        header("Location: admin_authors.php?success=1");
    } else {
        header("Location: admin_authors.php?error=1");
    }
} catch (PDOException $ex) {
    die($ex->getMessage());
}
?>

