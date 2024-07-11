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
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group w50">
                        <label for="email">Email: <small class="required">*</small></label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group w50">
                        <label for="phone">Phone: <small class="required">*</small></label>
                        <input type="text" id="phone" name="phone" required>
                    </div>
                    <div class="form-group w50">
                        <label for="payment_option">Payment Option: <small class="required">*</small></label>
                        <select name="payment_option" id="payment_option" required>
                            <option value="cash">Cash On Delivery</option>
                            <option value="stripe">Card</option>
                        </select>
                    </div>
                    <div class="form-group w100">
                        <label for="address">Address: <small class="required">*</small></label>
                        <input type="text" id="address" name="address" required>
                    </div>

                </div>
                <button type="submit">Checkout</button>
            </form>
        </div>
        <div class="cart-right">
            <h3>Cart Items</h3>
            <?php
            if (isset($cartItems['products'])) {
                foreach ($cartItems['products'] as $item) { ?>
                    <div class="cart-item d-flex">
                        <div class="p-details">
                            <h4><?= showText($item['name'], 20) ?></h4>
                            <p><b>Price :</b> <?= $item['unit_price'] ?></p>
                        </div>
                        <div class="plus-minus ">
                            <h4>Quantity</h4>
                            <div class="d-flex">
                                <button class="plus-btn">+</button>
                                <p><?= $item['quantity'] ?></p>
                                <button class="minus-btn">-</button>
                            </div>
                        </div>
                        <div class="total-unit-price">
                            <h4>Unit Total</h4>
                            <p><?= $item['total_price'] ?> <b>BDT</b></p>
                        </div>

                    </div>
                <?php } ?>

                <div class="total-div">
                    <h2>Total Price</h2>
                    <p><?= $cartItems['total_price'] ?> <b>BDT</b></p>
                </div>
            <?php } else { ?>
                <p>No Items added</p>
            <?php } ?>

        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy;All rights reserved.</p>
        </div>
    </footer>

</body>

</html>