document.addEventListener('DOMContentLoaded', function() {
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
});

console.log('lololo')