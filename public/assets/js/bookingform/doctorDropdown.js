document.addEventListener("DOMContentLoaded", function() {
    const triggerInput = document.getElementById('dropdown-trigger');
    const isCustomDoctorInput = document.getElementById('isCustomDoctorInput');
    const searchInput = document.getElementById('dropdown-search');
    const dropdownMenu = document.getElementById('dropdown-menu');
    const options = dropdownMenu.querySelectorAll('li:not(.sticky)'); // Exclude the search box
    const hiddenInput = document.getElementById('doctor_id');

    // Function to show the dropdown
    function showDropdown() {
        dropdownMenu.classList.remove('hidden');
    }

    // Function to hide the dropdown
    function hideDropdown() {
        dropdownMenu.classList.add('hidden');
    }

    // Function to set the selected option in the trigger input and hidden fields
    function setSelectedOption(option) {
        const doctorName = option.querySelector('#doctorNameDropDown').textContent;
        const clinicName = option.querySelector('.text-gray-500').textContent;
        const addDoctor = document.getElementById('addDoctor');
        
        triggerInput.value = `${doctorName}`;
        hiddenInput.value = option.getAttribute('data-id');
        hideDropdown();
        if (triggerInput.value === "Not in the list") {
            addDoctor.classList.remove('hidden');
            isCustomDoctorInput.value = "yes";
        } else {
            addDoctor.classList.add('hidden');
        }
    }

    // Show the dropdown when the trigger input is focused or clicked
    triggerInput.addEventListener('focus', showDropdown);
    triggerInput.addEventListener('click', showDropdown);

    // Handle option click
    options.forEach(option => {
        option.addEventListener('click', () => {
            setSelectedOption(option);
        });
    });

    // Hide dropdown on clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdownMenu.contains(e.target) && !triggerInput.contains(e.target)) {
            hideDropdown();
        }
    });

    // Prevent the dropdown from hiding when clicking inside the dropdown itself
    dropdownMenu.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // Add search functionality inside the dropdown
    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase();

        options.forEach(option => {
            const doctorName = option.querySelector('#doctorNameDropDown').textContent.toLowerCase();
            const clinicName = option.querySelector('.text-gray-500').textContent.toLowerCase();

            if (doctorName.includes(filter) || clinicName.includes(filter)) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    });
});
