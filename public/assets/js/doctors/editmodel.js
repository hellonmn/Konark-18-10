document.addEventListener('DOMContentLoaded', function () {
    // Select all edit buttons
    const editButtons = document.querySelectorAll('.edit-button');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Get the data attributes from the clicked button
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const phone = this.getAttribute('data-phone');
            const clinic_name = this.getAttribute('data-clinic-name');
            const clinic_location = this.getAttribute('data-clinic-location');

            // Populate the modal inputs with the service data
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_clinic_name').value = clinic_name;
            document.getElementById('edit_clinic_location').value = clinic_location;

            // Update the hidden input with the service ID
            document.querySelector('input[name="id"]').value = id;

            // Update the form action with the correct service ID
            const form = document.querySelector('#editForm');
            form.action = `/doctors/${id}`;
        });
    });
});
