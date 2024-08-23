<?php


include '../config/db_connect.php';
include '../config/helper_function.php';

if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    $currentProduct = getById($conn, 'product', $product_id);
    $currentImagePath = $currentProduct['image'];
    $deleted = deleteById($conn, 'product', $product_id);

    if ($deleted) {
        echo "<script>sessionStorage.setItem('showAlert', 'Product deleted successfully!');window.location.href='products.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Failed to delete product. Please try again.');window.location.href='products.php';</script>";
    }
}

$products = getAll($conn, 'product');
$subcategories = getAll($conn, 'sub_category', 'ASC');
$catNames = [];
if ($subcategories) {
    foreach ($subcategories as $item) {
        $catNames[$item['id']] = $item['name'];
    }
}

include './partial/header.php';

?>


        <div class="content">
            <div class="top-bar">
                <h2>All Products</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
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

                                <?php } }else{?> <tr><td colspan="6">No Data Found</td></tr> <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include './partial/footer.php' ?>
    <script src="./assets/js/scripts.js"></script>
</body>

</html>