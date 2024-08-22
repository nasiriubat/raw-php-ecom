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

    $subcategory_id = intval($_GET['id']);
    $subcategory = getById($conn, 'sub_category', $subcategory_id);
    $categories = getAll($conn, 'category', 'ASC');
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $inputData = [
        'name' => $_POST['name'],
        'parent_id' => $_POST['parent_id'],

    ];

    $data = updateById($conn, 'sub_category', $id, $inputData);
    if ($data) {
        echo "<script>sessionStorage.setItem('showAlert', 'Update successful!');window.location.href='sub_category.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Update Failed, please try again.');window.location.href='sub_category.php';</script>";
    }
} else {
    echo "<script>window.location.href='sub_category.php';</script>";
}
include './partial/header.php';

?>


        <div class="content  profile">
            <div class="top-bar">
                <h2>Edit Sub Category</h2>
                                <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>

            </div>
            <form class="custom-form" action="edit_subcategory.php" method="post" enctype="multipart/form-data">
                <div class="form-div">
                    <input type="hidden" name="id" value="<?= $subcategory['id'] ?>">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= $subcategory['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Category:</label>
                        <select name="parent_id" id="parent_id" required>
                            <?php
                            if ($categories) {
                                foreach ($categories as $category) {
                            ?>
                                    <option <?= $category['id'] == $subcategory['parent_id'] ? 'selected' : '' ?> value=<?= $category['id'] ?>><?= $category['name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
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