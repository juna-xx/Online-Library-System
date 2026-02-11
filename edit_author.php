<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$authorID = $_POST['authorID'];
$authorName = $_POST['authorName'];
$authorLink = $_POST['author_external_link'];

try {
    $query = "UPDATE authors SET authorName = :authorName, author_external_link = :authorLink WHERE authorID = :authorID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':authorName', $authorName);
    $stmt->bindParam(':authorLink', $authorLink);
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
