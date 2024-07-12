<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ecommerce Store</title>
    <link rel="stylesheet" href="./assets/style.css"> <!-- Assuming you have a separate CSS file -->
</head>
<?php
include './config/helper_function.php';
include './config/db_connect.php';
$user = getCurrentUser();
if (isset($_GET['clearCart'])) {
    clearCart();
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    if (createOrder($conn, $name, $email, $phone, $address, $payment_method)) {
        echo "<script>sessionStorage.setItem('showAlert', 'Order placed successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Failed to place order. Please try again.'); window.location.href='index.php';</script>";
    }
}

$cartItems = showCart();
?>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="navbar-logo">
                <a href="index.php">Eshop</a>
            </div>
            <div class="search-bar">
                <form action="index.php">
                    <input type="text" value="<?= $searchText ?? '' ?>" name="search" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="navbar-links">

                <a href="cart.php">Cart</a>
                <?php
                if (isLoggedIn()) {
                    if (isAdmin()) { ?>
                        <a href="./admin/index.php">Dashboard</a>
                    <?php } else { ?>
                        <a href="./customer/index.php">Dashboard</a>
                    <?php } ?>
                    <a href="logout.php">Logout</a>
                <?php } else { ?>
                    <a href="login.php">Login</a>
                <?php } ?>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="cart-container">
        <div class="cart-left">
            <form class="custom-form" action="cart.php" method="post" enctype="multipart/form-data">
                <h3 class="">Delivery Information :</h3>
                <div class="form-div">
                    <div class="form-group w50">
                        <label for="name">Name: <small class="required">*</small></label>
                        <input type="text" id="name" name="name" value="<?= $user['name'] ?? '' ?>" required>
                    </div>
                    <div class="form-group w50">
                        <label for="email">Email: <small class="required">*</small></label>
                        <input type="email" id="email" name="email" value="<?= $user['email'] ?? '' ?>" required>
                    </div>
                    <div class="form-group w50">
                        <label for="phone">Phone: <small class="required">*</small></label>
                        <input type="text" id="phone" name="phone" value="<?= $user['phone'] ?? '' ?>" required>
                    </div>
                    <div class="form-group w50">
                        <label for="payment_option">Payment Option: <small class="required">*</small></label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="cash">Cash On Delivery</option>
                            <option value="stripe">Card</option>
                        </select>
                    </div>
                    <div class="form-group w100">
                        <label for="address">Address: <small class="required">*</small></label>
                        <textarea col="" rows="3" name="address" id="address"><?= $user['address'] ?? '' ?></textarea>
                    </div>

                </div>
                <?php if (getCartProductCount() != '') { ?>
                    <button type="submit">Checkout</button>
                <?php } ?>
            </form>
            <a class="btn" href="index.php">Continue Shopping</a>

        </div>
        <div class="cart-right">
            <div class="cart-header d-flex">
                <h3>Cart Items</h3>
                <a href="cart.php?clearCart">Clear cart</a>
            </div>
            <?php
            if (isset($cartItems['products']) && count($cartItems['products']) > 0) {
                foreach ($cartItems['products'] as $item) { ?>
                    <?php if (isset($item['id']) && !empty($item['id'])) { ?>
                        <div class="cart-item d-flex" data-product-id="<?= $item['id'] ?>">
                            <div class="p-details">
                                <h4><?= showText($item['name'], 20) ?></h4>
                                <p><b>Price :</b> <?= $item['unit_price'] ?></p>
                            </div>
                            <div class="plus-minus">
                                <h4>Quantity</h4>
                                <div class="d-flex">
                                    <button class="minus-btn">-</button>
                                    <p class="quantity"><?= $item['quantity'] ?></p>
                                    <button class="plus-btn">+</button>
                                </div>
                            </div>
                            <div class="total-unit-price">
                                <h4>Unit Total</h4>
                                <p><span id="show-total-unit-price-<?= $item['id'] ?>"><?= $item['total_price'] ?></span> <b>BDT</b></p>
                            </div>
                        </div>
                <?php }
                } ?>
                <div class="total-div d-flex">
                    <h2>Total Price</h2>
                    <p> <span id="show-total-price"><?= $cartItems['total_price'] ?></span> <b>BDT</b></p>
                </div>
            <?php } else { ?>
                <p class="no-item-added">No Items added</p>
            <?php } ?>

        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy;All rights reserved.</p>
        </div>
    </footer>
    <script>
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

                    // Create AJAX request
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', './config/updatecart.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.responseType = 'json';

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const response = xhr.response;
                            console.log(response[productId])
                            if (response && response[productId]) {
                                quantityElement.textContent = response[productId].quantity;
                                // Update total price or any other UI elements
                                document.getElementById('show-total-price').textContent = response.total_price;
                                document.getElementById('show-total-unit-price-' + productId).textContent = response[productId].total_price;
                            } else {
                                console.error('Invalid or empty response:', response);
                                sessionStorage.setItem('showAlert', 'Failed to update cart item');
                            }
                        } else {
                            console.error('Error updating cart:', xhr.statusText);
                            sessionStorage.setItem('showAlert', 'Error updating cart. Please try again.');
                        }
                    };

                    xhr.onerror = function() {
                        console.error('Request failed');
                        sessionStorage.setItem('showAlert', 'Request failed. Please try again.');
                    };

                    const data = `action=update_quantity&product_id=${productId}&quantity=${quantity}`;
                    xhr.send(data);
                });
            });
        });
    </script>



</body>

</html>