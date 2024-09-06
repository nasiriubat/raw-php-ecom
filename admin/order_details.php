<?php
include '../config/db_connect.php';
include '../config/helper_function.php';

if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='index.php';</script>";
}


if (isset($_GET['id'])) {
    $orderId = intval($_GET['id']);
    $order = getById($conn, 'orders', $orderId);
    $userDetails = json_decode($order['user_details']);
    $orderDetails = json_decode($order['order_details']);
}

include './partial/header.php';
?>

<div class="content">
    <div class="top-bar">
        <h2>Order Details</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
    </div>
    <div class="main-content">
        <div class="order-details">
            <div class="order-left">
                <h2><?= showText($userDetails->name,30) ?></h2>
                <p class="d-flex"><b>Email : </b><?= $userDetails->email ?></p>
                <p class="d-flex"><b>Phone : </b><?= $userDetails->phone ?></p>
                <p class="d-flex"><b>Address :</b><?= $userDetails->address ?></p>
            </div>
            <div class="order-right">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th width="5%">Sl.</th>
                            <th width="50%">Name</th>
                            <th width="20%">Unit Price</th>
                            <th width="10%">Quantity</th>
                            <th width="20%">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $key => $item) {
                            if ($item->name != null) { ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= showText($item->name,50) ?></td>
                                    <td><?= $item->unit_price ?> ৳</td>
                                    <td><?= $item->quantity ?> pc</td>
                                    <td><?= $item->total_price ?> ৳</td>
                                </tr>
                        <?php }
                        } ?>
                        <tr class="net-total">
                            <td colspan="3">Net Total</td>
                            <td colspan="2"><?= $order['total'] ?> ৳</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
</body>

</html>
<!-- [{"product_id":16,"name":"ball","unit_price":"33.00","quantity":3,"total_price":99},{"product_id":14,"name":"dfng","unit_price":"33.00","quantity":3,"total_price":99},{"product_id":"total_price","name":null,"unit_price":null,"quantity":null,"total_price":0}] -->