<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="********" required>
            <textarea name="address" placeholder="Address" rows="4" required></textarea>
            <input type="submit" value="Register">
        </form>
        <div class="register-div">
            <a href="login.php">Login</a>
        </div>
    </div>
</body>

</html>

<?php
include './config/db_connect.php';
include './config/helper_function.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $data_to_insert = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'password' => md5($password),
    ];

    $result = newRegister($conn, $data_to_insert);

    if ($result !== false) {
        echo "<script>sessionStorage.setItem('showAlert', 'Registration successful!');window.location.href='login.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Registration failed. Please try again later.');window.location.href='register.php';</script>";
    }
}
?>