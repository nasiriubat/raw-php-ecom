<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <nav class="navbar">
<div class="site-name">
        <a href="../index.php">E-Shop</a>
        </div>        <div class="nav-right">
            <a href="profile.html">
                <img class="img profile-img" src="./assets/images/margot.jpg" alt="profile-img">
            </a>
            <a href="../logout.php"><button class="btn logout-btn">Logout</button></a>

        </div>
    </nav>
    <div class="container">
        <div class="sidebar">
            <h3>
                <a href="index.html">Dashboard</a>
            </h3>
            <ul>
                <li><a href="profile.html">Profile</a></li>
                <li><a href="customers.html">Customers</a></li>
                <li><a href="orders.html">Orders</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="products.html">Products</a></li>
                <li><a href="settings.html">Settings</a></li>
            </ul>
        </div>
        <div class="content  profile">
            <div class="top-bar">
                <h2>Create Category</h2>
                <a href="" class="btn back">Back</a>
            </div>
            <form class="custom-form" action="create_category.php" method="post" enctype="multipart/form-data">
                <div class="form-div">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                </div>
                <button type="submit">Create</button>
            </form>
        </div>
    </div>

</body>

</html>
<?php
include '../config/db_connect.php';
include '../config/helper_function.php';

if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $data = createData($conn, 'category', ['name' => $name]);
    if ($data) {
        echo "<script>sessionStorage.setItem('showAlert', 'Insert successful!');window.location.href='categories.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Insert Failed, please try again.');window.location.href='categories.php';</script>";
    }
}
?>