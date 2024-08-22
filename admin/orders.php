<?php
include '../config/db_connect.php';
include '../config/helper_function.php';
include './partial/header.php';

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
if (isset($_GET['completed'])) {
    $completedOrder = [];
    foreach ($orders as $order) {
        if ($order['status'] == 'Completed') {
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
    echo "<script>sessionStorage.setItem('showAlert', 'Order Accepted!');window.location.href='orders.php';</script>";
}
if (isset($_GET['rejectOrder'])) {
    $accept = updateById($conn, 'orders', $_GET['rejectOrder'], ['status' => 'Rejected']);
    echo "<script>sessionStorage.setItem('showAlert', 'Order Rejected!');window.location.href='orders.php';</script>";
}

?>
<div class="content">
    <div class="top-bar">
        <h2>All Orders</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
    </div>
    <div class="main-content">
        <div class="button-area">
            <a class="btn btn-all" href="orders.php">All Orders</a>
            <a class="btn btn-create" href="orders.php?pending">Pending Orders</a>
            <a class="btn btn-success" href="orders.php?completed">Completed Orders</a>
            <a class="btn btn-cancel" href="orders.php?rejected">Rejected Orders</a>
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
                <?php foreach ($orders as $key => $order) { ?>
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
                            <?php if (($order['status'] != 'Rejected')) {
                                if (($order['status'] != 'Accepted')) { ?>
                                    <a class="btn btn-edit" href="orders.php?acceptOrder=<?= $order['id'] ?>">Accept</a>
                                    <a class="btn btn-delete" href="orders.php?rejectOrder=<?= $order["id"] ?>">Reject</a>
                            <?php }
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
</body>

</html>