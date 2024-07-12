<?php
include '../config/db_connect.php';
include '../config/helper_function.php';

if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='index.php';</script>";
}

$categories = getAll($conn, 'category', 'ASC');

if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);

    $deleted = deleteById($conn, 'category', $category_id);

    if ($deleted) {
        echo "<script>sessionStorage.setItem('showAlert', 'Category deleted successfully!');window.location.href='categories.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Failed to delete category. Please try again.');window.location.href='categories.php';</script>";
    }
}

include './partial/header.php';
?>

<div class="content">
    <div class="top-bar">
        <h2>All Categories</h2>
        <a href="" class="btn">Back</a>
    </div>
    <div class="main-content">
        <div class="button-area">
            <a class="btn btn-create" href="./create_category.php">Create Category</a>
        </div>
        <?php if ($categories) { ?>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="5%">Sl.</th>
                        <th width="75%">Category Name</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) { ?>
                        <tr>
                            <td><?= $category['id'] ?></td>
                            <td><?= $category['name'] ?></td>
                            <td class="action-btn">
                                <a class="btn btn-edit" href="edit_category.php?id=<?= $category['id'] ?>">Edit</a>
                                <a class="btn btn-delete" href="categories.php?id=<?= $category['id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showAlert = sessionStorage.getItem('showAlert');
        if (showAlert) {
            Toastify({
                text: showAlert,
                duration: 2000, // Duration in milliseconds
                close: true, // Show close button
                gravity: 'top', // Position
                position: 'right', // Position
                backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                stopOnFocus: true, // Stop timeout on focus
            }).showToast();
            sessionStorage.removeItem('showAlert');
        }
    });
</script>
<script src="./assets/js/scripts.js"></script>
</body>

</html>