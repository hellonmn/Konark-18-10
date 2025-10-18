
function showForm() {
    const introContainer = document.querySelector('.introBox');
    const formContainer = document.querySelector('.formBox');
    const nextButton = document.querySelector('.slideNextBtn');
    const submitButton = document.getElementById('submitButton');

    introContainer.style.transform = 'translateX(-100%)';
    introContainer.style.display = 'none';
    formContainer.style.display = 'block';
    formContainer.style.transform = 'translateX(0)';
    submitButton.setAttribute('id', 'submitButton');
    nextButton.style.display = 'none';
    submitButton.style.display = 'block';
}

// Get a reference to the form and the submit button
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    const mainForm = document.getElementById('mainForm');

    // Get the submit button
    const submitButton = document.getElementById('submitButton');

    // Add click event listener to the submit button
    submitButton.addEventListener('click', function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Check if all required fields are filled out
        const doctorName = document.getElementById('doctor_name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();
        const clinicName = document.getElementById('clinic_name').value.trim();
        const clinicLocation = document.getElementById('clinic_location').value;
        const gpayNumber = document.getElementById('gpay_number').value.trim();
        const upi = document.getElementById('upi').value.trim();
        const representative = document.getElementById('representative').value;
        const meetingPurpose = document.getElementById('meeting_purpose').value;
        const feedback = document.getElementById('feedback').value.trim();
        const konarkTeam = document.getElementById('konark_team').value.trim();

        // Check if any required field is empty
        if (
            !doctorName ||
            !phone ||
            !email ||
            !clinicName ||
            !clinicLocation ||
            !gpayNumber ||
            !upi ||
            !representative ||
            !meetingPurpose ||
            !feedback ||
            !konarkTeam
        ) {
            alert('Please fill out all required fields.');
            return; // Prevent form submission
        }

        // If all required fields are filled out, submit the form
        mainForm.submit();
    });
});
