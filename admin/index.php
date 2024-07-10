<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <nav class="navbar">
        <div class="site-name">
        <a href="../index.php">E-Shop</a>
        </div>
        <div class="nav-right">
            <a href="profile.html">
                <img class="img profile-img" src="./assets/images/margot.jpg" alt="profile-img">
            </a>
            <a href="../logout.php"><button class="btn logout-btn">Logout</button></a>

        </div>
    </nav>
    <div class="container">
        <div class="sidebar">
            <h3>
                <a href="index.html">Dashboard</a>
            </h3>
            <ul>
                <li><a href="profile.html">Profile</a></li>
                <li><a href="customers.html">Customers</a></li>
                <li><a href="orders.html">Orders</a></li>
                <li><a href="categories.php">Categories</a></li>                <li><a href="sub_category.php">Sub Categories</a></li>

                <li><a href="products.php">Products</a></li>
                <li><a href="settings.html">Settings</a></li>
            </ul>
        </div>
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
    
</body>

</html>