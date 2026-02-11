<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$genreName = $_POST['genreName'];

try {
    $query = "INSERT INTO genres(genreName) VALUES (:genreName)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':genreName', $genreName);
    $result = $stmt->execute();
    
    if ($result) {
    	// redirects to success message
        header("Location: admin_genres.php?success=1");
    } else {
    	// redirects to error message
        header("Location: admin_genres.php?error=1");
    }
} catch (PDOException $ex) {
    die($ex->getMessage());
}
?>
