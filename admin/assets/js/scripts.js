document.addEventListener('DOMContentLoaded', function () {
    const showAlert = sessionStorage.getItem('showAlert');
    if (showAlert) {
        Toastify({
            text: showAlert,
            duration: 2000, // Duration in milliseconds
            close: true, // Show close button
            gravity: 'top', // Position
            position: 'right', // Position
            backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
            stopOnFocus: true, // Stop timeout on focus
        }).showToast();
        sessionStorage.removeItem('showAlert');
    }

    document.getElementById('print').addEventListener('click', function() {
        let table = document.querySelector('.custom-table');
        
        html2canvas(table).then(function(canvas) {
            let imgData = canvas.toDataURL('image/png');
            let pdf = new jspdf.jsPDF('p', 'mm', 'a4');

            // Get page title for the heading
            let title = "Earning Report";

            // Set the font, add the title (heading) with padding
            let padding = 10; // Define padding value (10mm)
            pdf.setFontSize(20);
            pdf.text(title, padding, padding);  // X = 10mm, Y = 10mm

            // Calculate the image dimensions and adjust for padding
            let pageWidth = pdf.internal.pageSize.getWidth() - 2 * padding; // Adjust width for padding
            let imgWidth = pageWidth;
            let imgHeight = canvas.height * imgWidth / canvas.width;

            // Add the image of the table to the PDF, after the title with padding
            pdf.addImage(imgData, 'PNG', padding, 20, imgWidth, imgHeight);  // X = padding, Y = 20mm
            
            // Save the generated PDF
            pdf.save('table.pdf');
        });
    });
});

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
document.querySelector('.myForm').onsubmit = function (event) {
    event.preventDefault(); // Prevent form submission

    if (validateForm()) {
        // If the form is valid, submit it
        this.submit();
    }
};

//hdgf
const phoneInput = document.querySelector('input[type="tel"]');
phoneInput.addEventListener('input', function () {
    // Replace any non-numeric characters in the input with an empty string
    this.value = this.value.replace(/[^0-9]/g, '');
  });




