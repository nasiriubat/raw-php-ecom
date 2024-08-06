<?php
include '../config/db_connect.php';
include '../config/helper_function.php';
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

// if (!isCustomer()) {
//     echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
// }
include './partial/header.php' ?>

<div class="content">
    <div class="top-bar">
        <h2>All Orders</h2>
<a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
    </div>
    <div class="main-content">
        <div class="button-area">
            <a class="btn btn-all" href="/">All Orders</a>
            <a class="btn btn-create" href="/">Pending Orders</a>
            <a class="btn btn-success" href="/">Completed Orders</a>
            <a class="btn btn-cancel" href="/">Cancelled Orders</a>
        </div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th width="5%">Sl.</th>
                    <th width="20%">Customer Name</th>
                    <th width="20%">Address</th>
                    <th width="20%">Email</th>
                    <th width="15%">Total Price</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Nishat Tasnim</td>
                    <td>Uttara, Dhaka</td>
                    <td>customer@example.com</td>
                    <td>20$</td>
                    <td class="action-btn">
                        <a class="btn btn-view" href="/">View</a>
                        <a class="btn btn-edit" href="/">Edit</a>
                        <a class="btn btn-delete" href="/">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Nishat Tasnim</td>
                    <td>Uttara, Dhaka</td>
                    <td>customer@example.com</td>
                    <td>10$</td>
                    <td class="action-btn">
                        <a class="btn btn-view" href="/">View</a>
                        <a class="btn btn-edit" href="/">Edit</a>
                        <a class="btn btn-delete" href="/">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Nishat Tasnim</td>
                    <td>Uttara, Dhaka</td>
                    <td>customer@example.com</td>
                    <td>5$</td>
                    <td class="action-btn">
                        <a class="btn btn-view" href="/">View</a>
                        <a class="btn btn-edit" href="/">Edit</a>
                        <a class="btn btn-delete" href="/">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Nishat Tasnim</td>
                    <td>Uttara, Dhaka</td>
                    <td>customer@example.com</td>
                    <td>10$</td>
                    <td class="action-btn">
                        <a class="btn btn-view" href="/">View</a>
                        <a class="btn btn-edit" href="/">Edit</a>
                        <a class="btn btn-delete" href="/">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

</body>

</html>