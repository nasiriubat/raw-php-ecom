document.addEventListener('DOMContentLoaded', function() {
    const updateCartButtons = document.querySelectorAll('.plus-btn, .minus-btn');

    updateCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const productId = cartItem.dataset.productId;
            const quantityElement = cartItem.querySelector('.quantity');
            let quantity = parseInt(quantityElement.textContent);

            if (this.classList.contains('plus-btn')) {
                quantity++;
            } else if (this.classList.contains('minus-btn') && quantity > 1) {
                quantity--;
            }

            // Create the data to send
            const data = new URLSearchParams();
            data.append('action', 'update_quantity');
            data.append('product_id', productId);
            data.append('quantity', quantity);

            // Send the fetch request
            fetch('./config/updatecart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: data
                })
                .then(response => response.json())
                .then(response => {
                    if (response && response[productId]) {
                        quantityElement.textContent = response[productId].quantity;
                        // Update total price or any other UI elements
                        document.getElementById('show-total-price').textContent = response.total_price;
                        document.getElementById('show-total-unit-price-' + productId).textContent = response[productId].total_price;
                    } else {
                        console.error('Invalid or empty response:', response);
                        sessionStorage.setItem('showAlert', 'Failed to update cart item');
                    }
                })
                .catch(error => {
                    console.error('Error updating cart:', error);
                    sessionStorage.setItem('showAlert', 'Error updating cart. Please try again.');
                });
        });
    });
});