document.addEventListener('DOMContentLoaded', function () {
    // Select all edit buttons
    const editButtons = document.querySelectorAll('.edit-button');

    // Reference to the edit modal and form
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('editForm');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Get data attributes from the button
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const role = this.getAttribute('data-role');

            // Populate the form fields
            editForm.querySelector('input[name="id"]').value = id;
            editForm.querySelector('#edit_name').value = name;
            editForm.querySelector('#edit_email').value = email;
            editForm.querySelector('#edit_role').value = role;

            // Update the form action to point to the correct update route
            editForm.action = `/representatives/${id}`;

            // Show the modal (handled by data-modal-toggle, but ensure modal is not hidden)
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        });
    });
});