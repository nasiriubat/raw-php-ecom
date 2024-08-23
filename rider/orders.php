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
$orders = getAllByID($conn, 'orders', 'userId', $user['id']);

if (isset($_GET['cancelOrder'])) {
    $cancel = updateById($conn, 'orders', $_GET['cancelOrder'], ['status' => 'Cancelled']);

    if ($cancel['payment_method'] != 'cash') {
        $afterCommission = $cancel['total'] - (($cancel['total'] * 10) / 100);
        $commission = ($cancel['total'] * 10) / 100;
        $udata = [
            'user_id' => $user['id'],
            'amount' => $afterCommission,
        ];
        $data = createData($conn, 'wallet', $udata);
        $data = updateById($conn, 'orders', $cancel['id'], ['commission' => $commission]);
    }
    echo "<script>sessionStorage.setItem('showAlert', 'Order Cancelled!');window.location.href='orders.php';</script>";
}
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
                    <th width="5%">Sl.</th>
                    <th width="15%">Date</th>
                    <th width="35%">Products</th>
                    <th width="15%">Total Price</th>
                    <th width="15%">Payment Method</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders) {
                    foreach ($orders as $key => $order) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= showDate($order['date']) ?></td>
                            <td>
                                <ol>
                                <?php if ($order['order_details']) {
                                    foreach (json_decode($order['order_details']) as $key => $product) {
                                        if ($product->name == null) {
                                            continue;
                                        } ?>
                                        <li class="text-left"><?= $product->name ?> - <?= $product->unit_price ?> BDT/pc - Quantity : <?= $product->quantity ?>pc</li>
                                <?php }
                                } ?>
                                </ol>
                            </td>
                            <td><?= $order['total'] ?> BDT</td>
                            <td><?= ucfirst($order['payment_method']) ?> </td>
                            <td class="action-btn">
                                <?php
                                if ($order['status'] == 'Cancelled') { ?>
                                    <div class="text-center">
                                        <span class="btn btn-delete">Cancelled</span><br><br>
                                        <?php if($order['payment_method'] != 'cash'){ ?>
                                        <span>Refunded <?= $order['total'] - $order['commission'] ?> BDT</span>
                                        <?php } ?>
                                    </div>
                                <?php } else {
                                ?>
                                    <a class="btn btn-edit" href="orders.php?cancelOrder=<?= $order['id'] ?>">Cancel</a>
                                <?php } ?>
                            </td>
                        </tr>
                <?php }
                }else{?>
                     <tr><td colspan=6>No Data Found</td></tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>
</div>

</body>

</html>