<?php

include '../config/db_connect.php';
include '../config/helper_function.php';
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isCustomer()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}
$user = getCurrentUser();
$orders = getAllByID($conn, 'orders', 'userId', $user['id']);
include './partial/header.php' ?>
<div class="content">
    <div class="top-bar">
        <h2>Dashborad</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>

    </div>
    <div class="dashboard">
        <hr>
        <div class="main-content">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="10%">Order ID</th>
                        <th width="25%">Order Date</th>
                        <th width="25%">Total Price</th>
                        <th width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders) {
                        foreach ($orders as $key=>$order) {
                    ?>
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td><?= showDate($order['date']) ?></td>
                                <td><?= $order['total'] ?> BDT</td>
                                <td><span class="btn <?= $order['status'] == 'Accepted' ? 'btn-success' : ($order['status'] == 'Pending' ? 'btn-view' :'btn-delete' ) ?>"><?= ucfirst($order['status']) ?></span></td>

                            </tr>
                            <?php } }else{?> <tr><td colspan="4">No Data Found</td></tr> <?php }?>




                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

</body>

</html>