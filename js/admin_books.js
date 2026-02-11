// For Books page
function openAddModal() {
    document.getElementById('addModal').classList.add('active');
}

function closeAddModal() {
    document.getElementById('addModal').classList.remove('active');
}

function loadEditModal(bookID) {
    // we assign the data received by get_book.php to the corresponding form elements, and when the admin submits this form, these values are retrieved from the edit_book.php script via the post superglobal array
    fetch('get_book.php?id=' + bookID)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editBookID').value = data.bookID;
            document.getElementById('editTitle').value = data.title;
            document.getElementById('editYear').value = data.year;
            document.getElementById('editISBN').value = data.isbn;
            document.getElementById('editDescription').value = data.description;
            document.getElementById('editCoverImage').value = data.cover_image_path;
            // author dropdown (if there is no author, empty string)
            document.getElementById('editAuthorID').value = data.authorID || '';
            
            document.getElementById('editModal').classList.add('active');
        })
        .catch(error => console.error('Error:', error));
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}
