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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $product_id = intval($_GET['id']);
    $product = getById($conn, 'product', $product_id);
    $categories = getAll($conn, 'category', 'ASC');
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $currentProduct = getById($conn, 'product', $id);

    $currentImagePath = '../uploads/'.$currentProduct['image'];
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if (file_exists($currentImagePath)) {
            unlink($currentImagePath);
        }
        $imagePath = saveImage('products', $_FILES['image']);
    } else {
        $imagePath = $currentImagePath;
    }
    $inputData = [
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'stock' => $_POST['stock'],
        'description' => $_POST['description'],
        'categoryId' => $_POST['categoryId'],
        'image' => $imagePath,
    ];

    $data = updateById($conn, 'product', $id, $inputData);
    if ($data) {
        echo "<script>alert('Update successful!');</script>";
        header('Location: products.php');
    } else {
        echo "<script>alert('Update Failed, please try again.');</script>";
        header('Location: products.php');
    }
} else {
    header('Location: products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
                <li><a href="products.php">Products</a></li>
                <li><a href="settings.html">Settings</a></li>
            </ul>
        </div>
        <div class="content  profile">
            <div class="top-bar">
                <h2>Edit Product</h2>
                <a href="" class="btn back">Back</a>
            </div>
            <form class="custom-form" action="edit_product.php" method="post" enctype="multipart/form-data">
                <div class="form-div">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= $product['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" value="<?= $product['price'] ?>" required><br>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock:</label>
                        <input type="number" name="stock" id="stock" value="<?= $product['stock'] ?>" required><br>
                    </div>

                    <div class="form-group">
                        <label for="stock">Category:</label>
                        <select name="categoryId" id="categoryId" required>
                            <?php
                            if ($categories) {
                                foreach ($categories as $category) {
                            ?>
                                    <option <?= $category['id'] == $product['categoryId'] ? 'selected' : '' ?> value=<?= $category['id'] ?>><?= $category['name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" id="description" name="description" value="<?= $product['description'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

</body>

</html>