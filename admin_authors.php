<?php
session_start();
require_once 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Authors - Admin</title>
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>
        
        <!-- success and error messages (based on redirection from the add, delete, edit php scripts-->
        <div class="admin-content">
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">Operation completed successfully!</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">An error occurred. Please try again.</div>
            <?php endif; ?>
            
            <div class="admin-header">
                <h1>Authors</h1>
                <!-- when add button is clicked the add author modal is opened -->
                <button class="add-btn" onclick="openAddModal()">Add Author</button>
            </div>
            
            <!-- displaying authors on a table -->
            <table>
                <tr>
                    <th>Author Name</th>
                    <th>Actions</th>
                </tr>
                <?php
                try {
                    $query = "SELECT * FROM authors ORDER BY authorName";
                    $result = $conn->query($query);
                    
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['authorName']) . "</td>";
                        echo "<td>";
                        // edit button, when it is clicked the author id, name, and external link of the current row is passed to the openEditModal() js function and the edit author modal pops ups
                        echo "<button class='action-btn edit-btn' onclick='openEditModal(" . $row['authorID'] . ", \"" . htmlspecialchars($row['authorName']) . "\", \"" . htmlspecialchars($row['author_external_link']) . "\")'>Edit</button>";
                        // delete button
                        echo "<a href='delete_author.php?id=" . $row['authorID'] . "' onclick='return confirm(\"Are you sure you want to delete this author?\");'><button class='action-btn delete-btn'>Delete</button></a>";
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
    
    <!-- Add Author Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <h2>Add Author</h2>
            <form action="add_author.php" method="POST">
                <div class="form-group">
                    <label>Author Name:</label>
                    <input type="text" name="authorName" required>
                </div>
                <div class="form-group">
                    <label>External Link:</label>
                    <input type="text" name="author_external_link" placeholder="https://...">
                </div>
                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Add Author</button>
                    <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Author Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <h2>Edit Author</h2>
            <form action="edit_author.php" method="POST">
                <input type="hidden" name="authorID" id="editAuthorID">
                <div class="form-group">
                    <label>Author Name:</label>
                    <input type="text" name="authorName" id="editAuthorName" required>
                </div>
                <div class="form-group">
                    <label>External Link:</label>
                    <input type="text" name="author_external_link" id="editAuthorLink">
                </div>
                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Update Author</button>
                    <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="js/admin_authors.js"></script>
</body>
</html>
