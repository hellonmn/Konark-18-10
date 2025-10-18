document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".service-checkbox");
    const totalAmountElement = document.querySelector(".totalAmountBox .text-gray-900.font-bold");
    let totalPrice = 0;

    // Function to update the total price
    function updateTotalPrice() {
        totalPrice = 0;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                totalPrice += parseInt(checkbox.getAttribute("data-price"), 10);
            }
        });
        totalAmountElement.textContent = `₹${totalPrice}`;
    }

    // Event listener for checkbox change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateTotalPrice);
    });

    // Check if any pre-checked services are there and update the price on page load
    updateTotalPrice();
});
