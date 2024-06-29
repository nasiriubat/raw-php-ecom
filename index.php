<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ecommerce Store</title>
    <link rel="stylesheet" href="./assets/style.css"> <!-- Assuming you have a separate CSS file -->
</head>
<?php
include './config/helper_function.php'
?>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="navbar-logo">
                <a href="index.php">Eshop</a>
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
    <div class="container">
        <!-- Hero Section -->
        <section class="hero">
            <!-- Sidebar with Category List -->
            <div class="sidebar">
                <ul>
                    <li><a href="categoryProduct.php?category=electronics">Electronics</a></li>
                    <li><a href="categoryProduct.php?category=clothing">Clothing</a></li>
                    <li><a href="categoryProduct.php?category=books">Books</a></li>
                    <!-- Add more categories dynamically -->
                </ul>
            </div>
            <!-- Product List -->
            <div class="product-list">
                <!-- Example product cards (replace with dynamic PHP fetching from database) -->
                <div class="product-card">
                    <a href="productDetails.php?id=1">
                        <img src="./assets/images/product.png" alt="Product 1">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$99.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="product-card">
                    <a href="productDetails.php?id=2">
                        <img src="./assets/images/product.png" alt="Product 2">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$49.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="product-card">
                    <a href="productDetails.php?id=3">
                        <img src="./assets/images/product.png" alt="Product 3">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$29.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="product-card">
                    <a href="productDetails.php?id=4">
                        <img src="./assets/images/product.png" alt="Product 4">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$79.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="product-card">
                    <a href="productDetails.php?id=1">
                        <img src="./assets/images/product.png" alt="Product 1">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$99.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div><div class="product-card">
                    <a href="productDetails.php?id=1">
                        <img src="./assets/images/product.png" alt="Product 1">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$99.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="product-card">
                    <a href="productDetails.php?id=2">
                        <img src="./assets/images/product.png" alt="Product 2">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$49.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="product-card">
                    <a href="productDetails.php?id=3">
                        <img src="./assets/images/product.png" alt="Product 3">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$29.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="product-card">
                    <a href="productDetails.php?id=4">
                        <img src="./assets/images/product.png" alt="Product 4">
                        <h4>Product Name</h4>
                    </a>
                    <p class="price">$79.99</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <!-- Add more product cards dynamically -->
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy;All rights reserved.</p>
        </div>
    </footer>

</body>

</html>