<?php
define("DBCONSTRING", "mysql:host=localhost;dbname=library");
define("DBUSER", "root");
define("DBPASS", "");

try {
    $conn = new PDO(DBCONSTRING, DBUSER, DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
