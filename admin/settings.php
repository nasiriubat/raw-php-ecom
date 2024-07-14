<?php
include './partial/header.php';
?>
        <div class="content">
            <div class="top-bar">
                <h2>Site Settings</h2>
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'javascript:history.go(-1)'; ?>" class="btn">Back</a>
            </div>
            <form class="custom-form" action="profile_update.php" method="post" enctype="multipart/form-data">
                <div class="form-div">
                    <div class="form-group">
                        <label for="site_name">Site Name:</label>
                        <input type="text" id="site_name" name="site_name" required>
                    </div>
                    <div class="form-group">
                        <label for="site_email">Contact Email:</label>
                        <input type="email" id="site_email" name="site_email" required>
                    </div>
                    <div class="form-group">
                        <label for="site_phone">Phone:</label>
                        <input type="text" id="site_phone" name="site_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="site_address">Address:</label>
                        <input type="text" id="site_address" name="site_address" required>
                    </div>
                    <div class="form-group">
                        <label for="currency_symbol">Currency Symbol:</label>
                        <input type="text" id="currency_symbol" name="currency_symbol" required>
                    </div>
                    <div class="form-group">
                        <label for="site_logo">Site Logo:</label>
                        <input type="file" id="site_logo" name="site_logo" accept="image/*">
                    </div>
                </div>
                <button type="submit">Update </button>
            </form>
        </div>
    </div>
    <?php include './partial/footer.php' ?>
<script src="./assets/js/scripts.js"></script>
</body>

</html>