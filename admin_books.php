<?php
session_start();
require_once 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Books - Admin</title>
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>
        
        <div class="admin-content">
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">Operation completed successfully!</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">An error occurred. Please try again.</div>
            <?php endif; ?>
            
            <div class="admin-header">
                <h1>Books</h1>
                <button class="add-btn" onclick="openAddModal()">Add Book</button>
            </div>
            
            <table>
                <tr>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Actions</th>
                </tr>
                <?php
                try {
                    $query = "SELECT * FROM books ORDER BY title";
                    $result = $conn->query($query);
                    
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
                        echo "<td>";
                        // passes book id to loadEditModal() when edit button is clicked
                        echo "<button class='action-btn edit-btn' onclick='loadEditModal(" . $row['bookID'] . ")'>Edit</button>";
                        // passes book id to delete_book.php as an URL parameter when delete button is clicked
                        echo "<a href='delete_book.php?id=" . $row['bookID'] . "' onclick='return confirm(\"Are you sure you want to delete this book?\");'><button class='action-btn delete-btn'>Delete</button></a>";
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
    
    <!-- Add Book Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <h2>Add Book</h2>
            <form action="add_book.php" method="POST">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Year:</label>
                    <input type="number" name="year">
                </div>
                <div class="form-group">
                    <label>ISBN:</label>
                    <input type="text" name="isbn">
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description"></textarea>
                </div>
                <div class="form-group">
                    <label>Cover Image Path:</label>
                    <input type="text" name="cover_image_path" placeholder="images/bookname.jpg">
                </div>
                <div class="form-group">
                    <label>Author:</label>
                    <select name="authorID" required>
                        <option value="">Select an author</option>
                        <?php
                        try {
                            $authorQuery = "SELECT * FROM authors ORDER BY authorName";
                            $authorResult = $conn->query($authorQuery);
                            
                            while ($authorRow = $authorResult->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $authorRow['authorID'] . '">';
                                echo htmlspecialchars($authorRow['authorName']);
                                echo '</option>';
                            }
                        } catch (PDOException $ex) {
                            echo "<option value=''>Error loading authors</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Genre:</label>
                    <select name="genreID" required>
                        <option value="">Select a genre</option>
                        <?php
                        try {
                            $genreQuery = "SELECT * FROM genres ORDER BY genreName";
                            $genreResult = $conn->query($genreQuery);
                            
                            while ($genreRow = $genreResult->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $genreRow['genreID'] . '">';
                                echo htmlspecialchars($genreRow['genreName']);
                                echo '</option>';
                            }
                        } catch (PDOException $ex) {
                            echo "<option value=''>Error loading genres</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Add Book</button>
                    <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Book Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <h2>Edit Book</h2>
            <form action="edit_book.php" method="POST">
                <input type="hidden" name="bookID" id="editBookID">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" id="editTitle" required>
                </div>
                <div class="form-group">
                    <label>Year:</label>
                    <input type="number" name="year" id="editYear">
                </div>
                <div class="form-group">
                    <label>ISBN:</label>
                    <input type="text" name="isbn" id="editISBN">
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" id="editDescription"></textarea>
                </div>
                <div class="form-group">
                    <label>Cover Image Path:</label>
                    <input type="text" name="cover_image_path" id="editCoverImage">
                </div>
                <div class="form-group">
                    <label>Author:</label>
                    <select name="authorID" id="editAuthorID" required>
                        <option value="">Select an author</option>
                        <?php
                        try {
                            $authorQuery = "SELECT * FROM authors ORDER BY authorName";
                            $authorResult = $conn->query($authorQuery);
                            
                            while ($authorRow = $authorResult->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $authorRow['authorID'] . '">';
                                echo htmlspecialchars($authorRow['authorName']);
                                echo '</option>';
                            }
                        } catch (PDOException $ex) {
                            echo "<option value=''>Error loading authors</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="submit-btn">Update Book</button>
                    <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <script src="js/admin_books.js"></script>
</body>
</html>
