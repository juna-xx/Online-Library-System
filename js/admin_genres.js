// For Genres page
function openAddModal() {
    document.getElementById('addModal').classList.add('active');
}

function closeAddModal() {
    document.getElementById('addModal').classList.remove('active');
}

function openEditModal(id, name) {
	// assigns given text value for id and genre name to editGenreID and editGenreName fields of the form (which are then accessed through the edit_genre.php script when the edit form is submitted in case the user decides to make changes)
    document.getElementById('editGenreID').value = id;
    document.getElementById('editGenreName').value = name;
    // adds class active to the edit modal to make it visible when the edit button is clicked
    document.getElementById('editModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}
