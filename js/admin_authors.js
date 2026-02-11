// For Authors page
function openAddModal() {
    document.getElementById('addModal').classList.add('active');
}

function closeAddModal() {
    document.getElementById('addModal').classList.remove('active');
}

function openEditModal(id, name, link) {
	// sets the values of authorID, authorName, author_external_link fields, which are retrieved by edit_author.php when the form is submitted
    document.getElementById('editAuthorID').value = id;
    document.getElementById('editAuthorName').value = name;
    document.getElementById('editAuthorLink').value = link;
    // adds active class to the edit modal making it visible
    document.getElementById('editModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}

