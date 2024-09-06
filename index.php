<?php
include './config/helper_function.php';
include './config/db_connect.php';
include './partial/navbar.php';
$categories = getAll($conn, 'category');
$subcategories = getSubcategoriesByCategory($conn);
$products = getAll($conn, 'product');
$home_page = true;
$cat_page = false;
$searchText = '';

if (isset($_GET['addToCart'])) {
    // clearCart();
    $productId = $_GET['addToCart'];
    $cartReturn = addToCart($conn, $productId);
    echo "<script>sessionStorage.setItem('showAlert', 'Product Added To Cart!'); window.location.href='index.php';</script>";
}
if (isset($_GET['buyNow'])) {
    // clearCart();
    $productId = $_GET['buyNow'];
    $cartReturn = addToCart($conn, $productId);
    echo "<script>sessionStorage.setItem('showAlert', 'Product Added To Cart!'); window.location.href='cart.php';</script>";
}
if (isset($_GET['subcategoryId'])) {
    $activeCatId = $_GET['subcategoryId'];
    $products = productsByCategory($conn, $_GET['subcategoryId']);
    $home_page = false;
}

if (isset($_GET['categoryId'])) {
    $activeCatId = $_GET['categoryId'];
    $allSubCategory = getSubcategoriesByCategory($conn);
    $products = getProductsByCategory($conn, $activeCatId);
    $home_page = false;
    $cat_page = true;
}

//search by input
if (isset($_GET['search'])) {
    $searchText = $_GET['search'];
    $products = productsBySearch($conn, $_GET['search']);
    $home_page = false;
}
?>

<!-- Main Content -->
<div class="container">
    <!-- Hero Section -->
    <section class="hero">
        <!-- Sidebar with Category List -->
        <div class="sidebar">
            <?php if ($categories) { ?>
                <ul class="category-list">
                    <?php foreach ($categories as $category) {
                        if (isset($subcategories[$category['id']])) { ?>
                            <li class="category-item">
                                <a href="index.php?categoryId=<?= $category['id'] ?>" class="sidebar-cat-item"><?= showText($category['name'], 20) ?></a>
                                <ul class="subcategory-list">
                                    <?php foreach ($subcategories[$category['id']] as $item) { ?>
                                        <li><a href="index.php?subcategoryId=<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                <?php }
                    }
                }
                ?>
                <!-- Add more categories dynamically -->
                </ul>
        </div>
        <div class="main">
            <!-- banner List -->
            <?php if ($home_page) { ?>

                <div class="banner-section">
                    <img src="./assets/images/banner.jpg" alt="">
                </div>

            <?php } ?>
            <?php if ($cat_page) { ?>
                <div class="sub-banner-section">
                    <ul>
                        <?php if (isset($allSubCategory[$activeCatId])) {
                            foreach ($allSubCategory[$activeCatId] as $subitem) { ?>
                                <li><a href="index.php?subcategoryId=<?= $subitem['id'] ?>"><?= $subitem['name'] ?></a></li>
                        <?php }
                        } ?>
                    </ul>
                </div>
            <?php } ?>
            <div class="product-list">
                <?php if ($products) {
                    foreach ($products as $product) { ?>
                        <div class="product-card">
                            <a href="productDetails.php?id=1">
                                <img src="./uploads/<?= $product['image'] ?>" alt="<?= substr($product['name'], 0, 30) ?>">
                                <h4><?= showText($product['name']) ?></h4>
                            </a>
                            <p class="price">৳ <?= $product['price'] ?></p>
                            <div class="card-buttons">
                                <a href="index.php?addToCart=<?= $product['id'] ?>" class="add-to-cart">Add to Cart</a>
                                <a href="index.php?buyNow=<?= $product['id'] ?>" class="add-to-cart buy-now">Buy Now</a>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="not-found-div">
                        <img src="./assets/images/product.png" alt="">
                        <h3>Opps ! No Items found</h3>
                    </div>
                <?php } ?>

            </div>
        </div>

    </section>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy;All rights reserved.</p>
    </div>
</footer>
<script src="./assets/js/scripts.js"></script>
</body>

</html>