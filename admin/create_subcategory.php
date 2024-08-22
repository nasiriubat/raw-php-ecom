<?php
include '../config/db_connect.php';
include '../config/helper_function.php';

if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}

$categories = getAll($conn, 'category', 'ASC');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'parent_id' => $_POST['parent_id'],
    ];
    $newData = createData($conn, 'sub_category', $data);
    if ($newData) {
        echo "<script>sessionStorage.setItem('showAlert', 'Insert successful!');window.location.href='sub_category.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Insert Failed, please try again.');window.location.href='sub_category.php';</script>";
    }
}
include './partial/header.php';

?>



        <div class="content  profile">
            <div class="top-bar">
                <h2>Create Sub Category</h2>
                                <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>

            </div>
            <form class="custom-form" action="create_subcategory.php" method="post" enctype="multipart/form-data">
                <div class="form-div">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Category:</label>
                        <select name="parent_id" id="parent_id" required>
                            <?php
                            if ($categories) {
                                foreach ($categories as $category) {
                            ?>
                                    <option value=<?= $category['id'] ?>><?= $category['name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
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