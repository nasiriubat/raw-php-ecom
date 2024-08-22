<?php
include '../config/db_connect.php';
include '../config/helper_function.php';

$customers = getAll($conn, 'user');
if (isset($_GET['id'])) {
    $customer_id = intval($_GET['id']);

    $currentProduct = getById($conn, 'user', $customer_id);
    $currentImagePath = $currentProduct['image'];
    $deleted = deleteById($conn, 'user', $customer_id,'users');

    if ($deleted) {
        echo "<script>sessionStorage.setItem('showAlert', 'Customer deleted successfully!');window.location.href='customer.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Failed to delete Customer. Please try again.');window.location.href='customer.php';</script>";
    }
}
include './partial/header.php';
?>
<div class="content">
    <div class="top-bar">
        <h2>All Customers</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
    </div>
    <div class="main-content">

        <table class="custom-table margin-top-10">
            <thead>
                <tr>
                    <th width="5%">Sl.</th>
                    <th width="20%">Name</th>
                    <th width="20%">Address</th>
                    <th width="20%">Email</th>
                    <th width="15%">Phone</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($customers) {
                    foreach ($customers as $key => $customer) {
                        if ($customer['role'] != 'admin') {

                ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $customer['name'] ?></td>
                                <td><?= $customer['address'] ?></td>
                                <td><?= $customer['email'] ?></td>
                                <td><?= $customer['phone'] ?></td>
                                <td class="action-btn">
                                    <!-- <a class="btn btn-view" href="/">View</a>
                                <a class="btn btn-edit" href="/">Edit</a> -->
                                    <a class="btn btn-delete" href="./customers.php?id=<?= $customer['id'] ?>">Delete</a>

                                </td>
                            </tr>
                <?php   
                 }
                    }
                }else{
                   echo('No available data');
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
</body>

</html>