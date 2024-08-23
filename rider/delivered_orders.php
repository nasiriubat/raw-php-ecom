<?php
include '../config/db_connect.php';
include '../config/helper_function.php';
include './partial/header.php';
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

// if (!isCustomer()) {
//     echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
// }
$user = getCurrentUser();
$orders = getAllByID($conn, 'orders', 'rider_id', $user['id']);


?>
<div class="content">
    <div class="top-bar">
        <h2>All Orders</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
    </div>
    <div class="main-content">

        <table class="custom-table">
            <thead>
                <tr>
                    <th width="5%">Order ID</th>
                    <th width="15%">Order Date</th>
                    <th width="20%">Customer</th>
                    <th width="15%">Phone</th>
                    <th width="20%">Address</th>
                    <th width="10%">Total Price</th>
                    <th width="15%">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders) {
                    foreach ($orders as $key => $order) {
                        if ($order['status'] == 'Delivered') {
                            $customerData = json_decode($order['user_details']);
                ?>
                            <tr>
                                <td>
                                    <p><?= $key + 1 ?></p>
                                </td>
                                <td><?= showDate($order['date']) ?></td>
                                <td><?= $customerData->name ?> </td>
                                <td><?= $customerData->phone ?> </td>
                                <td><?= $customerData->address ?> </td>
                                <td><?= $order['total'] ?> BDT</td>
                                <td>
                                  Delivered
                                </td>

                            </tr>
                    <?php }
                    }
                } else { ?> <tr>
                        <td colspan="8">No Data Found</td>
                    </tr> <?php } ?>




            </tbody>
        </table>
    </div>
</div>

</body>

</html>