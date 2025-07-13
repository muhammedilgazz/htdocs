<!DOCTYPE html>

<!--
 // Name: ekash
 // Description: Personal Finance Management Admin Dashboard PHP Template
 // Version: 1.0.0
 // Email : pixcelsthemes@gmail.com
 // Author: Pixcels Themes
 // URL: https://themeforest.net/user/pixcelsthemes/portfolio
 // Themeforest Profile : https://themeforest.net/user/pixcelsthemes/portfolio
-->

<html lang="en">

<?php include './partials/head.php'?>

<body class="dashboard">

    <?php include './partials/preloader.php'?>

    <div class="authincation">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-xl-5 col-md-6">
                    <div class="mini-logo text-center my-5">
                        <a href="index.php"><img src="assets/images/logo.png" alt=""></a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <a class="page-back text-muted" href="otp-phone.php">
                                <span><i class="fi fi-ss-angle-small-left"></i></span> Back</a>
                            <h3 class="text-center">OTP Verification</h3>
                            <p class="text-center mb-5">We will send one time code on ending in +xxx xxxxxxxx60.</p>
                            <form action="settings-security.php">
                                <div class="mb-3  mb-3">
                                    <label class="mb-3">Your OTP Code</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fi fi-sr-phone-call"></i>
                                            </span>
                                        </div>
                                        <input name="otp_code" type="text" class="form-control" value="11 22 33">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success w-100">Verify</button>
                                </div>
                            </form>
                            <div class="info mt-3">
                                <p class="text-muted">You dont recommended to save password to browsers!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include './partials/script.php'?>
</body>

</html>