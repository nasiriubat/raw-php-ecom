<?php
include '../config/db_connect.php';
include '../config/helper_function.php';
include './partial/header.php';

if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}

$orders = getAll($conn, 'orders');


if (isset($_GET['orderByStatus'])) {
    $pendingOrder = [];
    foreach ($orders as $order) {
        if ($order['status'] == ucfirst($_GET['orderByStatus'])) {
            $pendingOrder[] = $order;
        }
    }
    $orders = $pendingOrder;
}


if (isset($_GET['acceptOrder'])) {
    $accept = updateById($conn, 'orders', $_GET['acceptOrder'], ['status' => 'Accepted']);
    echo "<script>sessionStorage.setItem('showAlert', 'Order Accepted!');window.location.href='index.php';</script>";
}
if (isset($_GET['rejectOrder'])) {
    $accept = updateById($conn, 'orders', $_GET['rejectOrder'], ['status' => 'Rejected']);
    echo "<script>sessionStorage.setItem('showAlert', 'Order Rejected!');window.location.href='index.php';</script>";
}
?>
<div class="content">
    <h2>Welcome to the Admin Dashboard</h2>
    <div class="dashboard">
        <div class="boxes">
            <div class="item total-orders">
                <p><?= dashboardData($conn)['total_orders'] ?></p>
                <h3>Total Orders</h3>
            </div>
            <div class="item completed-orders">
                <p><?= dashboardData($conn)['completed_orders'] ?></p>
                <h3>Completed Orders</h3>
            </div>
            <div class="item pending-orders">
                <p><?= dashboardData($conn)['total_earnings'] ?> </p>
                <h3>Total Earning (৳)</h3>
            </div>
            <div class="item total-customers">
                <p><?= number_format(dashboardData($conn)['total_commission'],2) ?> </p>
                <h3>Total Commission (৳)</h3>
            </div>
        </div>
        <div class="boxes">
            <div class="item completed-orders">
                <p><?= ucfirst(dashboardData($conn)['most_used_payment_method']) ?></p>
                <h3>Top Payment Method</h3>
            </div>
            <div class="item total-customers">
                <p><?= dashboardData($conn)['pending_orders'] ?></p>
                <h3>Pending Order</h3>
            </div>
            <div class="item total-orders">
                <p><?= dashboardData($conn)['total_riders'] ?></p>
                <h3>Total Riders</h3>
            </div>
            <div class="item pending-orders">
                <p><?= dashboardData($conn)['total_customers'] ?></p>
                <h3>Total Customer</h3>
            </div>



        </div>
        <hr>
        <div class="main-content">
            <div class="button-area">
                <a class="btn btn-all" href="index.php">All Orders</a>
                <a class="btn btn-create" href="index.php?orderByStatus=pending">Pending Orders</a>
                <a class="btn btn-success" href="index.php?orderByStatus=delivered">Completed Orders</a>
                <a class="btn btn-cancel" href="index.php?orderByStatus=rejected">Rejected Orders</a>
                <a class="btn btn-create" href="index.php?orderByStatus=cancelled">Cancelled Orders</a>
            </div>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="5%">Sl.</th>
                        <th width="15%">Customer Name</th>
                        <th width="15%">Address</th>
                        <th width="15%">Phone</th>
                        <th width="10%">Total Price</th>
                        <th width="10%">Date</th>
                        <th width="10%">Status</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders) {
                        foreach ($orders as $key => $order) { ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= json_decode($order['user_details'])->name ?></td>
                                <td><?= json_decode($order['user_details'])->address ?></td>
                                <td><?= json_decode($order['user_details'])->phone ?></td>
                                <td><?= $order['total'] ?> ৳</td>
                                <td><?= showDate($order['date']) ?></td>
                                <td><?= $order['status'] ?></td>
                                <td class="action-btn">
                                    <a class="btn btn-view" href="order_details.php?id=<?= $order['id'] ?>">View</a>
                                    <?php if (($order['status'] == 'Pending')) {
                                    ?>
                                        <a class="btn btn-edit" href="index.php?acceptOrder=<?= $order['id'] ?>">Accept</a>
                                        <a class="btn btn-delete" href="index.php?rejectOrder=<?= $order["id"] ?>">Reject</a>
                                    <?php }
                                    ?>
                                </td>
                            </tr>
                        <?php }
                    } else { ?> <tr>
                            <td colspan="8">No Data Found</td>
                        </tr> <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
</body>

</html>