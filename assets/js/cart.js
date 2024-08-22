$(document).ready(function () {
    //hide-show wallet start
    const walletOption = document.getElementById('wallet');
    const walletAmount = parseFloat(walletOption.dataset.wallet);
    const totalPrice = parseFloat(document.getElementById('show-total-price').textContent);
    if (totalPrice > walletAmount) {
        walletOption.disabled = true;
    }
    //end
    $('.plus-btn, .minus-btn').on('click', function () {
        const cartItem = $(this).closest('.cart-item');
        const productId = cartItem.data('product-id');
        const quantityElement = cartItem.find('.quantity');
        let quantity = parseInt(quantityElement.text());

        

        if ($(this).hasClass('plus-btn')) {
            quantity++;
        } else if ($(this).hasClass('minus-btn') && quantity > 1) {
            quantity--;
        }

        // Create the data to send
        const data = {
            action: 'update_quantity',
            product_id: productId,
            quantity: quantity
        };

        // Send the AJAX request
        $.ajax({
            url: './config/updatecart.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response && response[productId]) {
                    quantityElement.text(response[productId].quantity);
                    // Update total price or any other UI elements
                    $('#show-total-price').text(response.total_price);
                    $('#show-total-unit-price-' + productId).text(response[productId].total_price);
                    if (parseFloat(response.total_price) > walletAmount) {
                        walletOption.disabled = true;
                    } else {
                        walletOption.disabled = false;
                    }
                } else {
                    console.error('Invalid or empty response:', response);
                    sessionStorage.setItem('showAlert', 'Failed to update cart item');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error updating cart:', error);
                sessionStorage.setItem('showAlert', 'Error updating cart. Please try again.');
            }
        });
    });
});
