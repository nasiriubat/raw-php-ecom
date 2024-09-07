<?php


include './partial/header.php';$setting = getSetting($conn);
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}

$subcategories = getAll($conn, 'sub_category', 'ASC');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump('start');
    $folderName = 'products';
    $file = $_FILES['image'];

    $imagePath = saveImage($folderName, $file);
    if ($imagePath) {
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'sub_categoryId' => $_POST['sub_categoryId'],
            'description' => $_POST['description'],
            'image' => $imagePath,
        ];
        $newData = createData($conn, 'product', $data);
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Failed to save the image. Please try again.');window.location.href='products.php';</script>";
    }
    if ($newData) {
        echo "<script>sessionStorage.setItem('showAlert', 'Insert successful!');window.location.href='products.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Insert Failed, please try again.');window.location.href='products.php';</script>";
    }
}


?>


<div class="content  profile">
    <div class="top-bar">
        <h2>Create Product</h2>
                        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>

    </div>
    <form class="custom-form" action="create_product.php" method="post" enctype="multipart/form-data">
        <div class="form-div">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="sub_categoryId">Sub Category:</label>
                <select name="sub_categoryId" id="sub_categoryId" required>
                    <?php
                    if ($subcategories) {
                        foreach ($subcategories as $item) {
                    ?>
                            <option value=<?= $item['id'] ?>><?= $item['name'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
        </div>
        <button type="submit">Create</button>
    </form>
</div>
</div>
<?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
</body>

</html>