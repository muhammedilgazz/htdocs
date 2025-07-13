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
        <div class="container">
            <div class="row justify-content-center align-items-center g-0">
                <div class="col-xl-8">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="welcome-content">
                                <div class="welcome-title">
                                    <div class="mini-logo">
                                        <a href="index.php">
                                            <img src="assets/images/logo-white.png" alt="" width="30" /></a>
                                    </div>
                                    <h3>Welcome to Ekash</h3>
                                </div>
                                <div class="privacy-social">
                                    <div class="privacy-link"><a href="#">Have an issue with 2-factor
                                            authentication?</a><br /><a href="#">Privacy Policy</a></div>
                                    <div class="intro-social">
                                        <ul>
                                            <li><a href="#"><i class="fi fi-brands-facebook"></i></a></li>
                                            <li><a href="#"><i class="fi fi-brands-twitter-alt"></i></a></li>
                                            <li><a href="#"><i class="fi fi-brands-linkedin"></i></a></li>
                                            <li><a href="#"><i class="fi fi-brands-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="auth-form">
                                <h4>Sign Up</h4>
                                <form action="#">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input name="fullName" type="text" class="form-control" />
                                        </div>
                                        <div class="col-12 mb-3"><label class="form-label">Email</label>
                                            <input name="email" type="text" class="form-control" />
                                        </div>
                                        <div class="col-12 mb-3"><label class="form-label">Password</label>
                                            <input name="password" type="text" class="form-control" />
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input name="acceptTerms" type="checkbox" class="form-check-input"
                                                    id="acceptTerms" />
                                                <label class="form-check-label" for="acceptTerms">I
                                                    certify that I
                                                    am 18 years of age or
                                                    older, and agree to the <a href="#" class="text-primary">User
                                                        Agreement</a> and <a href="#" class="text-primary">Privacy
                                                        Policy</a>.</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-grid gap-2"><button type="submit"
                                            class="btn btn-primary me-8 text-white">Sign Up</button></div>
                                </form>
                                <p class="mt-3 mb-0 undefined">Already have an account?<a class="text-primary"
                                        href="signin.php"> Sign In</a></p>
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