<?php
include '../config/db_connect.php';
include '../config/helper_function.php';

if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}
include './partial/header.php';
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
                    <h3 class="text-center">Pending Orders</h3>
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th width="10%">Order ID</th>
                                <th width="25%">Cutomer Name</th>
                                <th width="25%">Cutomer Address</th>
                                <th width="15%">Total amount</th>
                                <th width="15%">Status</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nishat Tasnim</td>
                                <td>Uttara, Dhaka</td>
                                <td>200$</td>
                                <td>Pending</td>
                                <td><a class="btn btn-view" href="/">View</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nishat Tasnim</td>
                                <td>Uttara, Dhaka</td>
                                <td>200$</td>
                                <td>Pending</td>
                                <td><a class="btn btn-view" href="/">View</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Nishat Tasnim</td>
                                <td>Uttara, Dhaka</td>
                                <td>200$</td>
                                <td>Pending</td>
                                <td><a class="btn btn-view" href="/">View</a></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Nishat Tasnim</td>
                                <td>Uttara, Dhaka</td>
                                <td>200$</td>
                                <td>Pending</td>
                                <td><a class="btn btn-view" href="/">View</a></td>
                            </tr>
                           
                           
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