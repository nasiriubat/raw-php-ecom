function validateForm() {
    // Clear previous errors
    clearErrors();

    let isValid = true;

    // Email validation
    const email = document.querySelector('input[type="email"]');
    if (email) {
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email.value)) {
            showError(email, 'Please enter a valid email address');
            isValid = false;
        }
    }

    // Phone validation
    const phone = document.querySelector('input[type="tel"]');
    if (phone) {
        const phonePattern = /^[0-9]{11}$/;
        if (!phonePattern.test(phone.value)) {
            showError(phone, 'Please enter a valid 11-digit phone number');
            isValid = false;
        }
    }

    // Currency validation
    const price = document.getElementById('price');
    if (price) {
        const pricePattern = /^[0-9]+(\.[0-9]{1,2})?$/;
        if (!pricePattern.test(price.value)) {
            showError(price, 'Please enter a valid price amount (e.g. 100.00)');
            isValid = false;
        }
    }

    return isValid;
}

// Function to display error messages
function showError(inputElement, message) {
    let error = document.createElement('div');
    error.className = 'error';
    error.style.color = 'red';
    error.innerHTML = message;
    inputElement.insertAdjacentElement('afterend', error);
}

// Function to clear previous error messages
function clearErrors() {
    const errors = document.querySelectorAll('.error');
    errors.forEach(error => error.remove());
}

// Attach the validation function to form submit
document.querySelector('.myForm').onsubmit = function () {
    document.querySelector('.myForm').onsubmit = function (event) {
        event.preventDefault(); // Prevent form submission

        if (validateForm()) {
            // If the form is valid, submit it
            this.submit();
        }
    };
};
