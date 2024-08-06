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

<div class="content  profile">
    <div class="top-bar">
        <h2>Profile</h2>
        <a href="" class="btn back">Back</a>
    </div>
    <form class="custom-form" action="profile_update.php" method="post" enctype="multipart/form-data">
        <div class="form-div">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="image">Profile Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
        </div>
        <button type="submit">Update</button>
    </form>
</div>
</div>

</body>

</html>