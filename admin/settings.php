<?php

include './partial/header.php';$setting = getSetting($conn);
if (!isLoggedIn()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authenticated!');window.location.href='../index.php';</script>";
}

if (!isAdmin()) {
    echo "<script>sessionStorage.setItem('showAlert', 'Not Authorized!');window.location.href='../index.php';</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateData = [
        'site_name'=>$_POST['site_name'],
        'site_email'=>$_POST['site_email'],
        'site_phone'=>$_POST['site_phone'],
        'site_address'=>$_POST['site_address'],
        'currency_symbol'=>$_POST['currency_symbol'],
    ];
    $data = updateSetting($conn, 'setting',$updateData);
    if ($data) {
        echo "<script>sessionStorage.setItem('showAlert', 'Update successful!');window.location.href='settings.php';</script>";
    } else {
        echo "<script>sessionStorage.setItem('showAlert', 'Update Failed, please try again.');window.location.href='settings.php';</script>";
    }
}
?>
<div class="content">
    <div class="top-bar">
        <h2>Site Settings</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
    </div>
    <form class="custom-form myForm" action="settings.php" method="post" enctype="multipart/form-data">
        <div class="form-div">
            <div class="form-group">
                <label for="site_name">Site Name:</label>
                <input type="text" id="site_name" name="site_name" required value="<?= $setting['site_name'] ?>">
            </div>
            <div class="form-group">
                <label for="site_email">Contact Email:</label>
                <input type="email" id="site_email" name="site_email" required value="<?= $setting['site_email'] ?>">
            </div>
            <div class="form-group">
                <label for="site_phone">Phone:</label>
                <input type="tel" id="site_phone" name="site_phone" required value="<?= $setting['site_phone'] ?>">
            </div>
            <div class="form-group">
                <label for="site_address">Address:</label>
                <input type="text" id="site_address" name="site_address" required value="<?= $setting['site_address'] ?>">
            </div>
            <div class="form-group">
                <label for="currency_symbol">Currency Symbol:</label>
                <input type="text" id="currency_symbol" name="currency_symbol" required value="<?= $setting['currency_symbol'] ?>">
            </div>
            <!-- <div class="form-group">
                <label for="site_logo">Site Logo:</label>
                <input type="file" id="site_logo" name="site_logo" accept="image/*">
            </div> -->
        </div>
        <button type="submit">Update </button>
    </form>
</div>
</div>
<?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
</body>

</html>