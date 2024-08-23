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


if (isset($_GET['pending'])) {
    $pendingOrder = [];
    foreach ($orders as $order) {
        if ($order['status'] == 'Pending') {
            $pendingOrder[] = $order;
        }
    }
    $orders = $pendingOrder;
}
if (isset($_GET['cancelled'])) {
    $pendingOrder = [];
    foreach ($orders as $order) {
        if ($order['status'] == 'Cancelled') {
            $pendingOrder[] = $order;
        }
    }
    $orders = $pendingOrder;
}
if (isset($_GET['completed'])) {
    $completedOrder = [];
    foreach ($orders as $order) {
        if ($order['status'] == 'Delivered') {
            $completedOrder[] = $order;
        }
    }
    $orders = $completedOrder;
}
if (isset($_GET['rejected'])) {
    $rejectedOrder = [];
    foreach ($orders as $order) {
        if ($order['status'] == 'Rejected') {
            $rejectedOrder[] = $order;
        }
    }
    $orders = $rejectedOrder;
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
                <p>02</p>
                <h3>Total Orders</h3>
            </div>
            <div class="item pending-orders">
                <p>02</p>
                <h3>Pending Orders</h3>
            </div>
            <div class="item completed-orders">
                <p>02</p>
                <h3>Completed Orders</h3>
            </div>
            <div class="item total-customers">
                <p>02</p>
                <h3>Total Customers</h3>
            </div>
        </div>
        <hr>
        <div class="main-content">
            <div class="button-area">
                <a class="btn btn-all" href="index.php">All Orders</a>
                <a class="btn btn-create" href="index.php?pending">Pending Orders</a>
                <a class="btn btn-success" href="index.php?completed">Completed Orders</a>
                <a class="btn btn-cancel" href="index.php?rejected">Rejected Orders</a>
                <a class="btn btn-create" href="index.php?cancelled">Cancelled Orders</a>
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
                                <td><?= $order['total'] ?> BDT</td>
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