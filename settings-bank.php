<?php require_once 'includes/auth_check.php'; ?>
<?php include './layouts/layoutTop.php'?>

    <div class="content-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-xl-4">
                                <div class="page-title-content">
                                    <h3>Bank</h3>
                                    <p class="mb-2">Welcome Ekash Finance Management</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="breadcrumbs"><a href="index.php">Home </a>
                                    <span><i class="fi fi-rr-angle-small-right"></i></span>
                                    <a href="#">Bank</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12 col-xl-12">
                    <div class="settings-menu">
                        <a href="settings.php">Account</a>
                        <a href="settings-general.php">General</a>
                        <a href="settings-profile.php">Profile</a>
                        <a href="settings-bank.php">Add Bank</a>
                        <a href="settings-security.php">Security</a>
                        <a href="settings-session.php">Session</a>
                        <a href="settings-categories.php">Categories</a>
                        <a href="settings-currencies.php">Currencies</a>
                        <a href="settings-api.php">Api</a>
                        <a href="support.php">Support</a>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Bank Account or Card</h4>
                        </div>
                        <div class="card-body">
                            <div class="verify-content">
                                <div class="d-flex align-items-center">
                                    <span class="me-3 icon-circle bg-primary text-white">
                                        <i class="fi fi-rs-bank"></i></span>
                                    <div class="primary-number">
                                        <h5 class="mb-0">Bank of America</h5>
                                        <small>Bank **************5421</small>
                                        <br>
                                        <span class="text-success">Verified</span>
                                    </div>
                                </div>
                                <button class=" btn btn-outline-primary">Manage</button>
                            </div>
                            <hr class="border opacity-1">
                            <div class="verify-content">
                                <div class="d-flex align-items-center">
                                    <span class="me-3 icon-circle bg-primary text-white"><i
                                            class="fi fi-rr-credit-card"></i></span>
                                    <div class="primary-number">
                                        <h5 class="mb-0">Master Card</h5>
                                        <small>Credit Card *********5478</small>
                                        <br>
                                        <span class="text-success">Verified</span>
                                    </div>
                                </div>
                                <button class=" btn btn-outline-primary">Manage</button>
                            </div>
                            <div class="mt-5">
                                <a href="add-bank.php" class="btn btn-primary m-2">Add New Bank</a>
                                <a href="add-card.php" class="btn btn-primary m-2">Add New Card</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include './layouts/layoutBottom.php'?>