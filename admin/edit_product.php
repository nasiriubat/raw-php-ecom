<?php
include '../config/db_connect.php';
include '../config/helper_function.php';

if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $product_id = intval($_GET['id']);
    $product = getById($conn, 'product', $product_id);
    $subcategories = getAll($conn, 'sub_category', 'ASC');
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $currentProduct = getById($conn, 'product', $id);

    $currentImagePath = '../uploads/' . $currentProduct['image'];
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
        'sub_categoryId' => $_POST['sub_categoryId'],
        'image' => $imagePath,
    ];

    $data = updateById($conn, 'product', $id, $inputData);
    if ($data) {
        echo "<script>sessionStorage.setItem('showAlert', 'Update successful!');window.location.href='products.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Update Failed, please try again.');window.location.href='products.php';</script>";
    }
} else {
    echo "<script>window.location.href='products.php';</script>";
}
include './partial/header.php';

?>


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
                        <select name="sub_categoryId" id="sub_categoryId" required>
                            <?php
                            if ($subcategories) {
                                foreach ($subcategories as $item) {
                            ?>
                                    <option <?= $item['id'] == $product['sub_categoryId'] ? 'selected' : '' ?> value=<?= $item['id'] ?>><?= $item['name'] ?></option>
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
    <?php include './partial/footer.php' ?>
    <script src="./assets/js/scripts.js"></script>
</body>

</html>