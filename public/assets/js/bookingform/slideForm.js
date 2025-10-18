function showForm2() {
    const form1 = document.querySelector('.form1');
    const form2 = document.querySelector('.form2');
    const nextButton = document.querySelector('.slideNextBtn');
    const submitBtn = document.querySelector('.submitBtn');
    const imgBox = document.querySelector('.imgBox');
    const logoImg = document.getElementById('logoImg');
    const backButton = document.getElementById('backButton');
    const logoBackBox = document.getElementById('logoBackBox');

    // Get all input fields in form1
    const patientNameField = document.getElementById('patientName');
    const patientPhoneField = document.getElementById('patientPhone');
    const emailField = document.getElementById('email');
    const ageField = document.getElementById('age');
    const genderField = document.querySelector('input[name="gender"]:checked');
    const referredByField = document.getElementById('referredBy');

    const patientName = patientNameField.value.trim();
    const patientPhone = patientPhoneField.value.trim();
    const email = emailField.value.trim();
    const age = ageField.value.trim();
    const referredBy = referredByField.value.trim();

    // Function to check if an input is empty and apply "border-red-500" class
    function isFieldEmpty(fieldValue, field, fieldName) {
        if (!fieldValue) {
            alert(`Please fill in the ${fieldName}.`);
            field.classList.add('border-red-500'); // Add the red border class
            return true;
        }
        field.classList.remove('border-red-500'); // Remove the red border class if filled
        return false;
    }

    // Phone number validation
    function isValidPhoneNumber(phone) {
        const phonePattern10 = /^\d{10}$/;  // Regular expression for exactly 10 digits
        const phonePattern12 = /^\d{12}$/;  // Regular expression for exactly 12 digits

        if (!(phonePattern10.test(phone) || phonePattern12.test(phone))) {
            alert("Please enter a valid 10-digit phone number (without country code).");
            patientPhoneField.classList.add('border-red-500'); // Add red border to phone field if invalid
            return false;
        }
        patientPhoneField.classList.remove('border-red-500'); // Remove red border if valid
        return true;
    }

    // Validation checks
    if (
        isFieldEmpty(patientName, patientNameField, "Patient Name") ||
        isFieldEmpty(patientPhone, patientPhoneField, "Phone Number") ||
        !isValidPhoneNumber(patientPhone) || // Phone number validation
        isFieldEmpty(email, emailField, "Email Address") ||
        isFieldEmpty(age, ageField, "Age") ||
        isFieldEmpty(genderField, document.querySelector('input[name="gender"]'), "Gender") ||
        referredBy === "Click here" // Check if "Click here" is selected
    ) {
        if (referredBy === "Click here") {
            referredByField.classList.add('border-red-500'); // Add red border for "Referred by"
            alert("Please select a valid option from the 'Referred by' dropdown.");
        } else {
            referredByField.classList.remove('border-red-500'); // Remove red border if valid
        }
        return; // Stop the function if any field is empty or invalid
    }

    // If all fields are filled and valid, proceed with the form slide transition
    form1.style.transform = 'translateX(-100%)';
    form1.classList.add('absolute');
    form2.classList.remove('absolute');
    form2.classList.add('nextForm');
    imgBox.classList.add('hideBanner');
    nextButton.classList.add('hidden');
    submitBtn.classList.remove('hidden');
    backButton.classList.remove('hidden');
    logoImg.classList.add('hidden');
    logoBackBox.classList.add('hover:bg-plight');
    setTimeout(function() {
        form1.style.opacity = '0';
    }, 300);

    // Scroll to the top of the form when the next form is shown
    window.scrollTo({ top: 0, behavior: 'smooth' });
}


function backForm() {
    const form1 = document.querySelector('.form1');
    const form2 = document.querySelector('.form2');
    const nextButton = document.querySelector('.slideNextBtn');
    const submitBtn = document.querySelector('.submitBtn');
    const imgBox = document.querySelector('.imgBox');
    const logoImg = document.getElementById('logoImg');
    const backButton = document.getElementById('backButton');
    const logoBackBox = document.getElementById('logoBackBox');
    
    
    form1.style.transform = 'translateX(0)';
    form1.classList.remove('absolute');
    form2.classList.add('absolute');
    form2.classList.remove('nextForm');
    imgBox.classList.remove('hideBanner');
    nextButton.classList.remove('hidden');
    submitBtn.classList.add('hidden');
    backButton.classList.add('hidden');
    logoBackBox.classList.remove('hover:bg-plight');
    logoImg.classList.remove('hidden');
    setTimeout(function(){
        form1.style.opacity = '100';
    },300);

    // Scroll to the top of the form when the next form is shown
    window.scrollTo({ top: 0, behavior: 'smooth' });
}


// Prevent form submission when pressing Enter
document.querySelectorAll('.form1 input').forEach(input => {
    input.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent the form from submitting
        }
    });
});


function showForm() {
    const form1 = document.querySelector('.form1');
    const form2 = document.querySelector('.form2');
    // const stepsBoxChild = document.querySelector('.stepsBoxChild');
    const nextButton = document.querySelector('.slideNextBtn');
    const submitBtn = document.querySelector('.submitBtn');
    const imgBox = document.querySelector('.imgBox');
    // const submitButton = document.getElementById('submitButton');

    form1.style.transform = 'translateX(-100%)';
    form1.classList.add('absolute');
    form2.classList.remove('absolute');
    // form1.style.display = 'none';
    // form2.style.display = 'block';
    // form2.style.right = '0';
    form2.classList.add('nextForm');
    imgBox.classList.add('hideBanner');
    // stepsBoxChild.classList.add('justify-end');
    nextButton.classList.add('hidden');
    submitBtn.classList.remove('hidden');
    setTimeout(function(){
        form1.style.opacity = '0';
   },300);
    // submitButton.setAttribute('id', 'submitButton');
    // nextButton.style.display = 'none';
    // submitButton.style.display = 'block';
}

function showForm3() {
    const form1 = document.querySelector('.form1');
    const form2 = document.querySelector('.form2');
    const stepsBoxChild = document.querySelector('.stepsBoxChild');
    const nextButton = document.querySelector('.slideNextBtn');
    const submitBtn = document.querySelector('.submitBtn');
    const imgBox = document.querySelector('.imgBox');
    // const submitButton = document.getElementById('submitButton');

    form1.style.transform = 'translateX(-100%)';
    // form1.style.display = 'none';
    // form2.style.display = 'block';
    // form2.style.right = '0';
    form2.classList.add('nextForm');
    imgBox.classList.add('hideBanner');
    stepsBoxChild.classList.add('justify-end');
    nextButton.classList.add('hidden');
    submitBtn.classList.remove('hidden');
    setTimeout(function(){
        form1.style.opacity = '0';
   },300);
    // submitButton.setAttribute('id', 'submitButton');
    // nextButton.style.display = 'none';
    // submitButton.style.display = 'block';
}

// Get a reference to the form and the submit button
// const mainForm = document.getElementById('mainForm');
// const submitButton = document.getElementById('submitButton');

// // Add an event listener to the external button
// submitButton.addEventListener('click', function () {
//     // Submit the form when the button is clicked
//     mainForm.submit();
// });

// document.addEventListener('scroll', function() {
//     const footer = document.getElementById('footer');
//     const scrolledToBottom = window.innerHeight + window.pageYOffset >= document.body.offsetHeight;

//     if (scrolledToBottom) {
//         footer.style.display = 'none';
//     } else {
//         footer.style.display = 'block';
//     }
// });


document.addEventListener("DOMContentLoaded", function () {
    const referredBySelect = document.getElementById("referredBy");
    const doctorInputBox = document.getElementById("doctorInputBox");
    const addDoctor = document.getElementById('addDoctor');
    const isCustomDoctorInput = document.getElementById('isCustomDoctorInput');

    // Function to toggle visibility of the doctor input box
    function toggleDoctorInputBox() {
        if (referredBySelect.value === "Doctor") {
            doctorInputBox.style.display = "block";
            addDoctor.classList.add('hidden');
            isCustomDoctorInput.value = "no";
        } else {
            doctorInputBox.style.display = "none";
            addDoctor.classList.remove('hidden');
            isCustomDoctorInput.value = "yes";
        }
    }

    // Initialize the visibility on page load
    toggleDoctorInputBox();

    // Add event listener to the "Referred by" dropdown
    referredBySelect.addEventListener("change", toggleDoctorInputBox);
});

