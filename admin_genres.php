<?php
session_start();
require_once 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Genres - Admin</title>
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>
        
        <!-- success and error messages -->
        <div class="admin-content">
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">Operation completed successfully!</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">An error occurred. Please try again.</div>
            <?php endif; ?>
            
            <div class="admin-header">
                <h1>Genres</h1>
                <button class="add-btn" onclick="openAddModal()">Add Genre</button>
            </div>
            
            <table>
                <tr>
                    <th>Genre Name</th>
                    <th>Actions</th>
                </tr>
                <!-- table to display genres, as well as edit and delete buttons -->
                <?php
                try {
                    $query = "SELECT * FROM genres ORDER BY genreName";
                    $result = $conn->query($query);
                    
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['genreName']) . "</td>";
                        echo "<td>";
                        // when button is clicked, passes genre id and genre name of the current row to openEditModal() js button
                        echo "<button class='action-btn edit-btn' onclick='openEditModal(" . $row['genreID'] . ", \"" . htmlspecialchars($row['genreName']) . "\")'>Edit</button>";
                        // when delete button is clicked, passes current genre ID as a URL parameter to delete_genre.php
                        echo "<a href='delete_genre.php?id=" . $row['genreID'] . "' onclick='return confirm(\"Are you sure you want to delete this genre?\");'><button class='action-btn delete-btn'>Delete</button></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $ex) {
                    die($ex->getMessage());
                }
                ?>
            </table>
        </div>
    </div>
    
    <!-- Add Genre Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <h2>Add Genre</h2>
            <form action="add_genre.php" method="POST">
                <div class="form-group">
                    <label>Genre Name:</label>
                    <input type="text" name="genreName" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Add Genre</button>
                    <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Genre Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <h2>Edit Genre</h2>
            <form action="edit_genre.php" method="POST">
                <input type="hidden" name="genreID" id="editGenreID">
                <div class="form-group">
                    <label>Genre Name:</label>
                    <input type="text" name="genreName" id="editGenreName" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Update Genre</button>
                    <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="js/admin_genres.js"></script>
</body>
</html>
