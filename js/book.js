// toggle status dropdown
function toggleDropdown() {
    const dropdown = document.getElementById('statusDropdown');
    // if the element doesn't ahve the class active add it
    // if it does, remove it
    dropdown.classList.toggle('active');
}

// to set reading status
// retrieves value passed by the dropdown and assigns it to the reading status element
function setStatus(status) {
    if (status === 'READ') {
        // show date modal for finished books
        document.getElementById('modalStatus').value = status;
        document.getElementById('dateModal').classList.add('active');
    } else {
        // for READING and TBR, submit directly without dates
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="reading_status" value="${status}">
            <!-- to make sure that status handler runs -->
            <input type="hidden" name="set_status" value="1">
        `;
        document.body.appendChild(form);
        form.submit();
    }
    toggleDropdown();
}

// close date modal
function closeModal() {
    document.getElementById('dateModal').classList.remove('active');
}

// toggle review form
function toggleReviewForm() {
    const form = document.getElementById('reviewForm');
    form.classList.toggle('active');
}

