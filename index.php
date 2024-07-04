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
$categories = getAll($conn, 'category');
$products = getAll($conn, 'product');
$activeCatId = 0;
$searchText = '';

//search by category
if (isset($_GET['categoryId'])) {
    $activeCatId = $_GET['categoryId'];
    $products = productsByCategory($conn, $_GET['categoryId']);
}

//search by input
if (isset($_GET['search'])) {
    $searchText = $_GET['search'];
    $products = productsBySearch($conn, $_GET['search']);
}
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
                    <input type="text" value="<?= $searchText ?>" name="search" placeholder="Search...">
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
    <div class="container">
        <!-- Hero Section -->
        <section class="hero">
            <!-- Sidebar with Category List -->
            <div class="sidebar">
                <ul>
                    <?php if ($categories) { ?>
                        <li><a href="index.php" class="<?= $activeCatId == 0 ? 'active' : '' ?>">All</a></li>
                        <?php foreach ($categories as $category) {

                        ?>
                            <li><a class="<?= $activeCatId == $category['id'] ? 'active' : '' ?>" href="index.php?categoryId=<?= $category['id'] ?>"><?= showText($category['name'],20) ?></a></li>
                    <?php }
                    } ?>
                    <!-- Add more categories dynamically -->
                </ul>
            </div>
            <!-- Product List -->
            <div class="product-list">
                <?php if ($products) {
                    foreach ($products as $product) { ?>
                        <div class="product-card">
                            <a href="productDetails.php?id=1">
                                <img src="./uploads/<?= $product['image'] ?>" alt="<?= substr($product['name'], 0, 30) ?>">
                                <h4><?= showText($product['name']) ?></h4>
                            </a>
                            <p class="price">BDT <?= $product['price'] ?></p>
                            <a href="./add_to_cart.php?id=<?= $product['id'] ?>" class="add-to-cart">Add to Cart</a>
                        </div>
                    <?php }
                } else { ?>
                    <div class="not-found-div">
                        <img src="./assets/images/product.png" alt="">
                        <h3>Opps ! No Items found</h3>
                    </div>
                <?php } ?>

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