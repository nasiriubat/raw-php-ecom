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
    $deleted = deleteById($conn, 'sub_category', $product_id);

    if ($deleted) {
        echo "<script>sessionStorage.setItem('showAlert', 'Item deleted successfully!');window.location.href='sub_category.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Failed to delete item. Please try again.');window.location.href='sub_category.php';</script>";
    }
}

$sub_categories = getAll($conn, 'sub_category');
$categories = getAll($conn, 'category', 'ASC');

$catNames = [];
if ($categories) {
    foreach ($categories as $category) {
        $catNames[$category['id']] = $category['name'];
    }
}
include './partial/header.php';

?>


<div class="content">
    <div class="top-bar">
        <h2>Sub Categories</h2>
<a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
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

                            <?php } }else{?> <tr><td colspan="4">No Data Found</td></tr> <?php }?>

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
<?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
</body>

</html>