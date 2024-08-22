<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <div class="login-container">
        <h2>E-Shop</h2>
        <form action="login.php" method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <div class="register-div">
            <a href="register.php">Sign Up</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showAlert = sessionStorage.getItem('showAlert');
            if (showAlert) {
                Toastify({
                    text: showAlert,
                    duration: 2000, // Duration in milliseconds
                    close: true, // Show close button
                    gravity: 'top', // Position
                    position: 'right', // Position
                    backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                    stopOnFocus: true, // Stop timeout on focus
                }).showToast();
                sessionStorage.removeItem('showAlert');
            }
        });
    </script>
</body>

</html>

<?php
include './config/db_connect.php';
include './config/helper_function.php';

if (isLoggedIn()) {
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = login($conn, $email, $password);
    if (!$user) {
        echo "<script>sessionStorage.setItem('showAlert', 'Login failed. Please check your credentials and try again.');window.location.href='login.php';</scrip>";
    }
    if ($user['role'] == 'admin') {
        echo "<script>sessionStorage.setItem('showAlert', 'Login successful!');window.location.href='./admin/index.php';</script>";
    } elseif ($user['role'] == 'customer') {
        echo "<script>sessionStorage.setItem('showAlert', 'Login successful!');window.location.href='./customer/index.php';</script>";
    } elseif ($user['role'] == 'rider') {
        echo "<script>sessionStorage.setItem('showAlert', 'Login successful!');window.location.href='./rider/index.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Login failed. Please check your credentials and try again.');window.location.href='login.php';</script>";
    }
}
?>