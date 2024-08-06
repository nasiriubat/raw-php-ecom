<?php

include '../config/db_connect.php';
include '../config/helper_function.php';
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isCustomer()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}
 include './partial/header.php' ?>
<div class="content">
    <div class="top-bar">
        <h2>Dashborad</h2>
        <a href="" class="btn back">Back</a>
    </div>
    <div class="dashboard">
        <hr>
        <div class="main-content">
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

</body>

</html>