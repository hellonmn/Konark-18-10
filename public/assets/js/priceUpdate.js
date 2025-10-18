document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".service-checkbox");
    const totalAmountElement = document.querySelector(".totalAmountBox .text-gray-900.font-bold");
    const discountElement = document.querySelector(".priceBox .totalAmountBox:nth-child(2) .text-gray-900.font-bold");
    const finalAmountElement = document.querySelector(".priceBox .totalAmountBox:nth-child(3) .text-gray-900.font-bold");
    const couponInput = document.getElementById('couponCode');
    const couponHiddenInput = document.getElementById('couponHiddenInput');
    const applyCouponButton = document.getElementById('applyCouponButton');
    const couponAlertMessage = document.getElementById('CouponAlertMessage');
    const selectedServiceIdsInput = document.getElementById('selectedServiceIds');
    
    let totalPrice = 0;
    let discountPrice = 0;
    let discountPercentage = 0;
    let discountType = '';
    let couponApplied = false;
    let maxDiscount = 0;  // <-- Declare maxDiscount globally
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Function to load data from local storage
    function loadFromLocalStorage() {
        const savedServices = JSON.parse(localStorage.getItem('selectedServices')) || [];
        const savedCoupon = localStorage.getItem('appliedCoupon') || '';
        const savedDiscountPrice = parseFloat(localStorage.getItem('discountPrice')) || 0;
        const savedDiscountPercentage = parseFloat(localStorage.getItem('discountPercentage')) || 0;
        const savedDiscountType = localStorage.getItem('discountType') || '';

        checkboxes.forEach(checkbox => {
            if (savedServices.includes(checkbox.getAttribute("data-id"))) {
                checkbox.checked = true;
            }
        });

        totalPrice = savedServices.reduce((sum, id) => sum + parseInt(document.querySelector(`.service-checkbox[data-id="${id}"]`).getAttribute("data-price"), 10), 0);
        discountPrice = savedDiscountPrice;
        discountPercentage = savedDiscountPercentage;
        discountType = savedDiscountType;
        couponApplied = savedCoupon !== '';

        updateTotalPrice();
        updateFinalPrice();

        if (couponApplied) {
            couponInput.value = savedCoupon;
            couponHiddenInput.value = savedCoupon;
            applyCouponButton.textContent = 'Remove';
            applyCouponButton.classList.add('bg-red-500');
            applyCouponButton.classList.remove('bg-primary');
            couponAlertMessage.textContent = 'Coupon applied successfully!';
            couponAlertMessage.classList.remove('hidden');
            couponAlertMessage.classList.add('text-green-500');
            couponInput.classList.add('border-green-500');

            disableCheckboxes(); // Disable services if coupon is already applied
        }
    }

    function saveToLocalStorage() {
        const selectedServiceIds = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedServiceIds.push(checkbox.getAttribute("data-id"));
            }
        });

        localStorage.setItem('selectedServices', JSON.stringify(selectedServiceIds));
        localStorage.setItem('appliedCoupon', couponApplied ? couponInput.value.trim() : '');
        localStorage.setItem('discountPrice', discountPrice);
        localStorage.setItem('discountPercentage', discountPercentage);
        localStorage.setItem('discountType', discountType);
    }

    function updateTotalPrice() {
        totalPrice = 0;
        let selectedServiceIds = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                totalPrice += parseInt(checkbox.getAttribute("data-price"), 10);
                selectedServiceIds.push(checkbox.getAttribute("data-id"));
            }
        });

        selectedServiceIdsInput.value = selectedServiceIds.join(',');

        totalAmountElement.textContent = `₹${totalPrice}`;
        updateFinalPrice();
        saveToLocalStorage();
    }

    function applyCoupon(couponCode) {
        applyCouponButton.innerHTML = '<div class="spinner-border text-white" role="status"><span class="sr-only">Loading...</span></div>';
        couponAlertMessage.classList.add('hidden');

        fetch(`/coupons/validate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ couponCode: couponCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                const today = new Date();
                const expiryDate = new Date(data.coupon.expiry);
                const minEligiblePrice = data.min;
                maxDiscount = parseInt(data.max, 10);  // <-- Set maxDiscount here

                if (expiryDate >= today) {
                    // Check if the total price meets the minimum eligibility for the coupon
                    if (totalPrice < minEligiblePrice) {
                        showError(`Minimum eligible price for this coupon is ₹${minEligiblePrice}.`);
                        resetButton();
                        return;
                    }

                    if (data.coupon.is_fix) {
                        discountPrice = parseInt(data.coupon.amount, 10);
                        discountType = 'INR';
                    } else {
                        discountPercentage = parseInt(data.coupon.percentage, 10);
                        discountPrice = (discountPercentage / 100) * totalPrice;

                        // Apply max discount limit
                        if (discountPrice > maxDiscount) {
                            discountPrice = maxDiscount;
                            showError(`Maximum discount limit of ₹${maxDiscount} has been applied.`);
                        }

                        discountType = '%';
                    }

                    updateFinalPrice();

                    couponHiddenInput.value = couponCode;

                    couponAlertMessage.textContent = 'Coupon applied successfully!';
                    couponAlertMessage.classList.remove('hidden');
                    couponAlertMessage.classList.add('text-green-500');
                    couponInput.classList.add('border-green-500');
                    couponInput.classList.remove('border-red-500');
                    couponInput.disabled = true;

                    applyCouponButton.textContent = 'Remove';
                    applyCouponButton.classList.add('bg-red-500');
                    applyCouponButton.classList.remove('bg-primary');
                    couponApplied = true;
                    saveToLocalStorage();

                    disableCheckboxes(); // Disable services after applying coupon
                } else {
                    showError("Coupon code has expired.");
                }
            } else {
                showError(data.message || "Invalid coupon code.");
            }
        })
        .catch(error => {
            console.error('Error validating coupon:', error);
            showError("Failed to apply coupon. Please try again.");
        })
        .finally(() => {
            resetButton();
        });
    }

    function updateFinalPrice() {
        if (discountType === 'INR') {
            discountElement.textContent = `₹${discountPrice}`;
        } else if (discountType === '%') {
            discountPrice = (discountPercentage / 100) * totalPrice;
    
            // Apply the max discount cap if applicable
            if (discountPrice > maxDiscount) {  
                discountPrice = maxDiscount;
                showError(`Maximum discount limit of ₹${maxDiscount} has been applied.`);
            }
            
            discountElement.textContent = `${discountPercentage}%`;
        }
    
        const finalPrice = totalPrice - discountPrice;
        finalAmountElement.textContent = `₹${finalPrice > 0 ? finalPrice : 0}`;
    }

    function resetButton() {
        applyCouponButton.innerHTML = couponApplied ? 'Remove' : 'Apply';
    }

    function showError(message) {
        couponAlertMessage.textContent = message;
        couponAlertMessage.classList.remove('hidden');
        couponAlertMessage.classList.add('text-red-500');
        couponAlertMessage.classList.remove('text-green-500');
        couponInput.classList.add('border-red-500');
        couponInput.classList.remove('border-green-500');
    }

    function disableCheckboxes() {
        checkboxes.forEach(checkbox => {
            checkbox.disabled = true;  // Disable all checkboxes after coupon is applied
        });
    }

    function enableCheckboxes() {
        checkboxes.forEach(checkbox => {
            checkbox.disabled = false;  // Re-enable all checkboxes if the coupon is removed
        });
    }

    applyCouponButton.addEventListener("click", function (event) {
        event.preventDefault();
        const couponCode = couponInput.value.trim();

        if (couponApplied) {
            // Remove the coupon
            couponInput.value = '';
            couponInput.disabled = false;
            discountPrice = 0;
            discountPercentage = 0;
            discountType = '';
            discountElement.textContent = `₹${discountPrice}`;
            updateFinalPrice();
            applyCouponButton.textContent = 'Apply';
            applyCouponButton.classList.remove('bg-red-500');
            applyCouponButton.classList.add('bg-primary');
            couponAlertMessage.classList.add('hidden');
            couponInput.classList.remove('border-green-500', 'border-red-500');
            couponHiddenInput.value = '';
            couponApplied = false;
            saveToLocalStorage();

            enableCheckboxes(); // Re-enable checkboxes after coupon is removed
        } else if (couponCode) {
            applyCoupon(couponCode);
        } else {
            showError("Please enter a coupon code.");
        }
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            updateTotalPrice();

            if (couponApplied) {
                updateFinalPrice();
            }
        });
    });

    // Load saved data from local storage
    loadFromLocalStorage();
});
