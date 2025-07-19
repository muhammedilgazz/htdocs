<?php
$page = "settings";
require_once ROOT_PATH . '/views/layouts/layoutTop.php';
?>

    <div class="content-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    $page_title = 'Settings';
                    $page_description = 'Welcome Ekash Finance Management';
                    $breadcrumb_active = 'Settings';
                    include ROOT_PATH . '/views/partials/page_header.php';
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12 col-xl-12">
                    <div class="settings-menu">
                        <a href="settings.php" class="<?= $page === 'settings' ? 'active' : '' ?>">Account</a>
                        <a href="settings-general.php" class="<?= $page === 'settings-general' ? 'active' : '' ?>">General</a>
                        <a href="settings-profile.php" class="<?= $page === 'settings-profile' ? 'active' : '' ?>">Profile</a>
                        <a href="settings-bank.php" class="<?= $page === 'settings-bank' ? 'active' : '' ?>">Add Bank</a>
                        <a href="settings-security.php" class="<?= $page === 'settings-security' ? 'active' : '' ?>">Security</a>
                        <a href="settings-session.php" class="<?= $page === 'settings-session' ? 'active' : '' ?>">Session</a>
                        <a href="settings-categories.php" class="<?= $page === 'settings-categories' ? 'active' : '' ?>">Categories</a>
                        <a href="settings-currencies.php" class="<?= $page === 'settings-currencies' ? 'active' : '' ?>">Currencies</a>
                        <a href="settings-api.php" class="<?= $page === 'settings-api' ? 'active' : '' ?>">Api</a>
                        <a href="support.php" class="<?= $page === 'support' ? 'active' : '' ?>">Support</a>
                    </div>
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="welcome-profile">
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/avatar/3.jpg" alt="">
                                            <div class="ms-3">
                                                <h4>Welcome, Hafsa Humaira!</h4>
                                                <p>Looks like you are not verified yet. Verify yourself to use the
                                                    full
                                                    potential of
                                                    Ekash.</p>
                                            </div>
                                        </div>
                                        <ul>
                                            <li><a href="#"><span class="verified"><i
                                                            class="fi fi-bs-check"></i></span>Verify
                                                    account</a></li>
                                            <li><a href="#"><span class="not-verified"><i
                                                            class="fi fi-rs-shield-check"></i></span>Two-factor
                                                    authentication
                                                    (2FA)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Download App</h4>
                                </div>
                                <div class="card-body">
                                    <div class="app-link">
                                        <h5>Get Verified On Our Mobile App</h5>
                                        <p>Verifying your identity on our mobile app more secure, faster, and
                                            reliable.
                                        </p>
                                        <a href="#" class="btn btn-primary"><img src="assets/images/android.svg"
                                                alt=""></a><br>
                                        <div class="mt-3"></div>
                                        <a href="#" class="btn btn-primary"><img src="assets/images/apple.svg"
                                                alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">VERIFY &amp; UPGRADE </h4>
                                </div>
                                <div class="card-body">
                                    <h5>Account Status :
                                        <span class="text-warning"> Pending</span>
                                    </h5>
                                    <p>Your account is unverified. Get verified to enable funding, trading, and
                                        withdrawal.</p>
                                    <a href="#" class="btn btn-primary">Get Verified</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Earn 30% Commission </h4>
                                </div>
                                <div class="card-body">
                                    <p>Refer your friends and earn 30% of <br> their trading fees.</p>
                                    <a href="affiliates.php" class="btn btn-primary">Referral Program</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once ROOT_PATH . '/views/layouts/layoutBottom.php'; ?>