<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../admin/assets/css/styles.css">
</head>

<body>
    <nav class="navbar">
        <div class="site-name">
            <a href="../index.php"><i class="fa-solid fa-house"> </i>Go to home</a>
        </div>
        <div class="nav-right">
            <a href="profile.php">
                <?php
                $userData = getById($conn, 'user', getCurrentUser()['id']);
                $image = $userData['image'] ? './' . $userData['image'] : './../assets/images/margot.jpg';
                ?>
                <img class="img profile-img" src="<?= $image ?>" alt="profile-img"> </a>
            <a href="../logout.php"><button class="btn logout-btn">Logout</button></a>

        </div>
    </nav>
    <div class="container">
        <div class="sidebar">
            <h3>
                <a href="index.php">Rider Dashboard</a>
            </h3>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="delivered_orders.php">Delivered Orders</a></li>
                <li><a href="orders.php">My Orders</a></li>

            </ul>
        </div>