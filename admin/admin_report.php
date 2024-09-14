<?php

include './partial/header.php';
$setting = getSetting($conn);
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

?>
<div class="content">
    <div class="top-bar">
        <h2>Earning Report</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
    </div>
    <div class="main-content">
        <div class="button-area">
            <button class="btn print-btn" id="print">Print</button>
            <div class="">
                <a class="btn btn-all" href="admin_report.php">All Orders</a>
                <a class="btn btn-create" href="admin_report.php?orderByStatus=pending">Pending Orders</a>
                <a class="btn btn-success" href="admin_report.php?orderByStatus=delivered">Completed Orders</a>
                
                <a class="btn btn-cancel" href="admin_report.php?orderByStatus=rejected">Rejected Orders</a>
                <a class="btn btn-create" href="admin_report.php?orderByStatus=cancelled">Cancelled Orders</a>
            </div>
        </div>
        <?php if ($orders) { ?>
        <table class="custom-table margin-top-10">
            <thead>
                <tr>
                <th width="5%">Sl.</th>
                        <th width="15%">Customer Name</th>
                        <th width="15%">Address</th>
                        <th width="15%">Phone</th>
                        <th width="10%">Total Price</th>
                        <th width="10%">Date</th>
                        <th width="10%">Status</th>
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
                                <td><?= $order['total'] ?> <?= $setting['currency_symbol'] ?></td>
                                <td><?= showDate($order['date']) ?></td>
                                <td><?= $order['status'] ?></td>
                            </tr>
                        <?php }
                    }?>
            </tbody>
        </table>
        <?php } else {?>
        <p class="text-center" style="margin-top: 3rem;font-size:2rem">No data found.</p>
        <?php }?>
    </div>
</div>
</div>
<?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
<script src="./assets/js/datatable.js"></script>
</body>

</html>