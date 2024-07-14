document.addEventListener('DOMContentLoaded', function() {
    const stripe = Stripe('pk_test_51PcJZa2KWfFUQWKW5FZYxSYxyTijHuux51MH54OPlkEKTbMHqHwHOZhOGK2yXDdZDPQQ2ftsoXbni8xo6e5hJqun005NIv6pGM'); // Replace with your Stripe public key
    const elements = stripe.elements();
    const card = elements.create('card');
    const cardElementContainer = document.getElementById('card-element');
    const cardErrors = document.getElementById('card-errors');
    const form = document.getElementById('payment-form');
    const paymentMethodSelect = document.getElementById('payment_method');

    card.mount('#card-element');

    paymentMethodSelect.addEventListener('change', function(event) {
        if (event.target.value === 'stripe') {
            cardElementContainer.style.display = 'block';
        } else {
            cardElementContainer.style.display = 'none';
        }
    });

    form.addEventListener('submit', function(event) {
        document.getElementById('cart-submit-btn').disabled = true;
        if (paymentMethodSelect.value === 'stripe') {
            event.preventDefault();

            // Fetch cart data from the session
            fetch('./config/cart_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(cartData => {
                if (cartData.error) {
                    cardErrors.textContent = cartData.error;
                } else {
                    // Create Payment Intent
                    fetch('./config/stripe.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            amount: cartData.total_amount, // Amount in cents
                            email: document.getElementById('email').value,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            cardErrors.textContent = data.error;
                        } else {
                            stripe.confirmCardPayment(data.clientSecret, {
                                payment_method: {
                                    card: card,
                                    billing_details: {
                                        email: document.getElementById('email').value,
                                    },
                                },
                            }).then(result => {
                                if (result.error) {
                                    cardErrors.textContent = result.error.message;
                                } else {
                                    if (result.paymentIntent.status === 'succeeded') {
                                        // Add hidden input with transaction ID
                                        const transactionInput = document.createElement('input');
                                        transactionInput.type = 'hidden';
                                        transactionInput.name = 'ref_no';
                                        transactionInput.value = result.paymentIntent.id;
                                        form.appendChild(transactionInput);

                                        form.submit();
                                    }
                                }
                            });
                        }
                    })
                    .catch(error => {
                        cardErrors.textContent = 'Request failed: ' + error.message;
                    });
                }
            })
            .catch(error => {
                cardErrors.textContent = 'Request failed: ' + error.message;
            });
        }
    });
});