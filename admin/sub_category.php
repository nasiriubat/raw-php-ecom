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
    $deleted = deleteById($conn, 'sub_category', $product_id);

    if ($deleted) {
        echo "<script>alert('Item deleted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to delete item. Please try again.');</script>";
    }
    header('Location: sub_category.php');
}

$sub_categories = getAll($conn, 'sub_category');
$categories = getAll($conn, 'category', 'ASC');

$catNames = [];
if ($categories) {
    foreach ($categories as $category) {
        $catNames[$category['id']] = $category['name'];
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
                <h2>Sub Categories</h2>
                <a href="" class="btn">Back</a>
            </div>
            <div class="main-content">
                <div class="button-area">
                    <a class="btn btn-create" href="./create_subcategory.php">Create Sub Category</a>
                </div>
                <?php if ($sub_categories) { ?>
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th width="5%">Sl.</th>
                                <th width="20%">Name</th>
                                <th width="20%">Parent Category</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($sub_categories) {
                                foreach ($sub_categories as $key => $item) {
                            ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $catNames[$item['parent_id']] ?? '' ?></td>
                                        <td class="action-btn">
                                            <a class="btn btn-edit" href="./edit_subcategory.php?id=<?= $item['id'] ?>">Edit</a>
                                            <a class="btn btn-delete" href="./sub_category.php?id=<?= $item['id'] ?>">Delete</a>
                                        </td>
                                    </tr>

                            <?php
                                }
                            }
                            ?>
                        </tbody>

                    </table>
                <?php } else { ?>
                    <div class="no-data-available">
                        No Available Data Found

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</body>

</html>