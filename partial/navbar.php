<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eshop</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/style.css"> <!-- Assuming you have a separate CSS file -->
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="navbar-logo">
                <a href="index.php">Eshop</a>
            </div>
            <div class="search-bar">
                <form action="index.php">
                    <input type="text" value="<?= $searchText ?? '' ?>" name="search" placeholder="Search...">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="navbar-links ">

                <a class="cart-btn" href="cart.php"><i class="fa-solid fa-cart-shopping cart-icon"><sup class="cart-count"><?= getCartProductCount() ?></sup></i> </a>
                <?php if (isLoggedIn()) { 
                    $user = getCurrentUser();
                    $wallet_amount = getById($conn,'wallet',$user['id'],'user_id');
                    
                    ?>
                    
                    <div class="dropdown">
                        <button class="toggle-btn" onclick="toggleDropdown()"><?= ucfirst(getCurrentUser()['role']) ?></button>
                        <div class="dropdown-content">
                            <?php if (isAdmin()) { ?>
                                <a href="./admin/index.php">Dashboard</a>
                            <?php } elseif (isRider()) { ?>
                                <a href="./rider/index.php">Dashboard</a>
                            <?php } else { ?>
                                <a href="./customer/profile.php">My Profile</a>
                                <a href="./customer/orders.php">My Orders</a>
                            <?php } ?>
                            <a ><?= $wallet_amount['amount'] ?> ৳</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <a href="login.php" class="btn login-btn">Login</a>
                <?php } ?>
            </div>
        </div>
    </nav>