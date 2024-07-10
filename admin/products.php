<?php


include '../config/db_connect.php';
include '../config/helper_function.php';

if (!isLoggedIn()) {
    echo "<script>alert('Not Authenticated!');</script>";
    header('Location: index.php');
}

if (!isAdmin()) {
    echo "<script>alert('Not Authorized!');</script>";
    header('Location: index.php');
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    $currentProduct = getById($conn, 'product', $product_id);
    $currentImagePath = $currentProduct['image'];
    $deleted = deleteById($conn, 'product', $product_id);

    if ($deleted) {
        echo "<script>alert('Product deleted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to delete product. Please try again.');</script>";
    }
    header('Location: products.php');
}

$products = getAll($conn, 'product');
$subcategories = getAll($conn, 'sub_category', 'ASC');
$catNames = [];
if ($subcategories) {
    foreach ($subcategories as $item) {
        $catNames[$item['id']] = $item['name'];
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <nav class="navbar">
        <div class="site-name">
            <a href="../index.php">E-Shop</a>
        </div>
        <div class="nav-right">
            <a href="profile.html">
                <img class="img profile-img" src="./assets/images/margot.jpg" alt="profile-img">
            </a>
            <a href="../logout.php"><button class="btn logout-btn">Logout</button></a>

        </div>
    </nav>
    <div class="container">
        <div class="sidebar">
            <h3>
                <a href="index.php">Dashboard</a>
            </h3>
            <ul>
                <li><a href="profile.html">Profile</a></li>
                <li><a href="customers.html">Customers</a></li>
                <li><a href="orders.html">Orders</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="sub_category.php">Sub Categories</a></li>

                <li><a href="products.php">Products</a></li>
                <li><a href="settings.html">Settings</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="top-bar">
                <h2>All Products</h2>
                <a href="" class="btn">Back</a>
            </div>
            <div class="main-content">
                <div class="button-area">
                    <a class="btn btn-create" href="./create_product.php">Create Product</a>
                </div>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th width="5%">Sl.</th>
                            <th width="20%">Name</th>
                            <th width="20%">Sub Category</th>
                            <th width="20%">Price</th>
                            <th width="15%">Quantity</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($products) {
                            foreach ($products as $key => $product) {
                        ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $catNames[$product['sub_categoryId']] ?? '' ?></td>
                                    <td><b>BDT</b> <?= $product['price'] ?></td>
                                    <td><?= $product['stock'] ?></td>
                                    <td class="action-btn">
                                        <a class="btn btn-edit" href="./edit_product.php?id=<?= $product['id'] ?>">Edit</a>
                                        <a class="btn btn-delete" href="./products.php?id=<?= $product['id'] ?>">Delete</a>
                                    </td>
                                </tr>

                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>