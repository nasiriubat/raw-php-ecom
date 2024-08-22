<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../admin/assets/css/styles.css">
</head>

<body>
    <nav class="navbar">
        <div class="site-name">
            <a href="../index.php">E-Shop</a>
        </div>
        <div class="nav-right">
            <a href="profile.php">
            <?php
                $userData = getById($conn,'user',getCurrentUser()['id']);
                $image = $userData['image'] ? './'.$userData['image']: './assets/images/margot.jpg';
                 ?>
                <img class="img profile-img" src="<?= $image ?>" alt="profile-img">            </a>
            <a href="../logout.php"><button class="btn logout-btn">Logout</button></a>

        </div>
    </nav>
    <div class="container">
        <div class="sidebar">
            <h3>
                <a href="index.php">Dashboard</a>
            </h3>
            <ul>
                <li><a href="profile.php">Profile</a></li>

                <li><a href="orders.php">Orders</a></li>

            </ul>
        </div>