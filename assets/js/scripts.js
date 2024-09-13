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
    
});

// Function to toggle dropdown visibility
function toggleDropdown() {
    var dropdown = document.querySelector('.dropdown');
    dropdown.classList.toggle('show');
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.toggle-btn ')) {
        var dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(function (dropdown) {
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            }
        });
    }
}

// Get the modal
var modal = document.getElementById("balanceModal");

// Get the <a> element that opens the modal
var btn = document.querySelector(".wallet-balance");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the "Balance" link, open the modal
btn.onclick = function(event) {
    event.preventDefault(); // Prevent the default action
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}




