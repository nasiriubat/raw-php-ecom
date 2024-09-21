<?php

include './partial/header.php';$setting = getSetting($conn);
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isrider()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}
$userData = getById($conn,'user',getCurrentUser()['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $currentImagePath = './' . $userData['image'];
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if (file_exists($currentImagePath)) {
            unlink($currentImagePath);
        }
        $imagePath = saveImage('users', $_FILES['image']);
    } else {
        $imagePath = $currentImagePath;
    }
    $newData = [
        'name'=>$_POST['name'],
        'email'=>$_POST['email'],
        'phone'=>$_POST['phone'],
        'address'=>$_POST['address'],
        'image'=>$imagePath,
        'password'=>md5($_POST['password']),
    ];
    $data = updateById($conn, 'user',$userData['id'],$newData);
    if ($data) {
        echo "<script>sessionStorage.setItem('showAlert', 'Update successful!');window.location.href='profile.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Update Failed, please try again.');window.location.href='profile.php';</script>";
    }
} ?>


<div class="content  profile">
    <div class="top-bar">
        <h2>Profile</h2>
                        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>

    </div>
    <form class="custom-form myForm" action="profile.php" method="post" enctype="multipart/form-data">
        <div class="form-div">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required value="<?= $userData['name'] ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?= $userData['email'] ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required value="<?= $userData['phone'] ?>">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required value="<?= $userData['address'] ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" >
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
<script src="../admin/assets/js/scripts.js"></script>
</body>

</html>