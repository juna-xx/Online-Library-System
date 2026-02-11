<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$genreID = $_GET['id'];

try {
    $query = "DELETE FROM genres WHERE genreID = :genreID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':genreID', $genreID);
    $result = $stmt->execute();
    
    if ($result) {
        header("Location: admin_genres.php?success=1");
    } else {
        header("Location: admin_genres.php?error=1");
    }
} catch (PDOException $ex) {
    die($ex->getMessage());
}
?>
