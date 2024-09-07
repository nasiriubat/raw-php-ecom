<?php

include '../config/db_connect.php';
include '../config/helper_function.php';
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isRider()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}
$user = getCurrentUser();


if (isset($_GET['readyToDeliver'])) {
    $accept = updateById($conn, 'orders', $_GET['readyToDeliver'], ['status' => 'On the way', 'rider_id' => $user['id']]);
    echo "<script>sessionStorage.setItem('showAlert', 'Order On the way!');window.location.href='index.php';</script>";
}

if (isset($_GET['deliveryComplete'])) {
    $accept = updateById($conn, 'orders', $_GET['deliveryComplete'], ['status' => 'Delivered']);
    $balance = updateOrCreateWallet($conn,$accept['delivery_charge']);
    echo "<script>sessionStorage.setItem('showAlert', 'Order Delivered!');window.location.href='index.php';</script>";
}
// $user = getCurrentUser();
$orders = getAll($conn, 'orders');
include './partial/header.php' ?>
<div class="content">
    <div class="top-bar">
    <h2>Welcome to the Rider Dashboard</h2>

        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>

    </div>
    <div class="dashboard">
        <div class="boxes">
            <div class="item completed-orders">
                <p><?= riderInfo($conn)['order'] ?></p>
                <h3>Completed Orders</h3>
            </div>
            <div class="item total-orders">
                <p><?= riderInfo($conn)['earning'] ?> ৳</p>
                <h3>Total Earning</h3>
            </div>
            <div class="item total-customers">
                <p><?= $wallet['amount'] ?? 0 ?> ৳</p>
                <h3>Avalilable Balance</h3>
            </div>
        </div>
        <hr>
        <div class="main-content">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="5%">Order ID</th>
                        <th width="10%">Order Date</th>
                        <th width="20%">Customer</th>
                        <th width="15%">Phone</th>
                        <th width="20%">Address</th>
                        <th width="10%">Total Price</th>
                        <th width="20%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders) {
                        foreach ($orders as $key => $order) {
                            if ($order['status'] == 'Accepted' || $order['status'] == 'On the way') {
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
                                    <td><?= $order['total'] ?> ৳</td>
                                    <td>
                                        <?php if ($order['status'] == 'Accepted') { ?>
                                            <a class="btn btn-create " href="index.php?readyToDeliver=<?= $order['id'] ?>">Start Delivery</a>
                                        <?php } else { ?>
                                            <a class="btn btn-success " href="index.php?deliveryComplete=<?= $order['id'] ?>">Complete Delivery</a>
                                        <?php } ?>
                                    </td>

                                </tr>
                             <?php }
                                }
                            } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

</body>

</html>