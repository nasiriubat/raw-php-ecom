<?php


include './partial/header.php';$setting = getSetting($conn);
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $category_id = intval($_GET['id']);
    $category = getById($conn, 'category', $category_id);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $id = $_POST['id'];
    $data = updateById($conn, 'category', $id, ['name' => $name]);
    if ($data) {
        echo "<script>sessionStorage.setItem('showAlert', 'Update successful!');window.location.href='categories.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Update Failed, please try again.');window.location.href='categories.php';</script>";
    }
} else {
    echo "<script>window.location.href='categories.php';</script>";

}


?>


        <div class="content  profile">
            <div class="top-bar">
                <h2>Edit Category</h2>
                                <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>

            </div>
            <form class="custom-form myForm" action="edit_category.php" method="post" enctype="multipart/form-data">
                <div class="form-div">
                    <input type="hidden" name="id" value="<?= $category['id'] ?>">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= $category['name'] ?>" required>
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