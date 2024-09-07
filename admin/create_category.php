<?php


include './partial/header.php';$setting = getSetting($conn);
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

        <div class="content  profile">
            <div class="top-bar">
                <h2>Create Category</h2>
                <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>

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
    <?php include './partial/footer.php' ?>
    <script src="./assets/js/scripts.js"></script>
</body>

</html>