<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ecommerce Store</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="./assets/style.css"> <!-- Assuming you have a separate CSS file -->
</head>

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
               
                <a href="cart.php">Cart <sup class="cart-count"><?= getCartProductCount() ?></sup></a>
                <?php if (isLoggedIn()) { ?>
                    <div class="dropdown">
                        <button class="toggle-btn" onclick="toggleDropdown()">My Account</button>
                        <div class="dropdown-content">
                            <?php if (isAdmin()) { ?>
                                <a href="./admin/index.php">Dashboard</a>
                            <?php } else { ?>
                                <a href="./customer/profile.php">My Profile</a>
                            <?php } ?>
                            <a href="./customer/orders.php">My Orders</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <a href="login.php" class="btn">Login</a>
                <?php } ?>
            </div>
        </div>
    </nav>