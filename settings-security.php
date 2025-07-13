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
                                    <h3>Security</h3>
                                    <p class="mb-2">Welcome Ekash Finance Management</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="breadcrumbs"><a href="index.php">Home </a>
                                    <span><i class="fi fi-rr-angle-small-right"></i></span>
                                    <a href="#">Security</a>
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
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Social Security Card</h4>
                                </div>
                                <div class="card-body">
                                    <div class="id-card-img">
                                        <img src="assets/images/id.png" alt="" class="img-fluid">
                                    </div>
                                    <div class="id-info mt-3">
                                        <h4>Carla Pascle </h4>
                                        <ul>
                                            <li class="verified mb-0">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-br-id-badge"></i></span>
                                                    <div>
                                                        <h5>
                                                            0024 5687 2254 3698</h5>
                                                        <p>
                                                            <span><i class="fi fi-sr-badge-check"></i></span>
                                                            Verified
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <a href="id-front-and-back-upload.php" class="btn btn-primary mt-3">
                                            Add New ID
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Email Verification</h4>
                                </div>
                                <div class="card-body">
                                    <div class="email-verification">
                                        <ul>
                                            <li class="verified">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-rr-envelope"></i></span>
                                                    <div>
                                                        <h5> hello@example.com</h5>
                                                        <p> <span><i
                                                                    class="fi fi-sr-badge-check"></i></span>Verified
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="verified">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-rr-envelope"></i></span>
                                                    <div>
                                                        <h5> hello@example.com</h5>
                                                        <p> <span><i
                                                                    class="fi fi-sr-badge-check"></i></span>Verified
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="verified">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-rr-envelope"></i></span>
                                                    <div>
                                                        <h5> hello@example.com</h5>
                                                        <p> <span><i
                                                                    class="fi fi-sr-badge-check"></i></span>Verified
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pending">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-rr-envelope"></i></span>
                                                    <div>
                                                        <h5> hello@example.com</h5>
                                                        <p class="text-danger">
                                                            <span class="text-danger"><i
                                                                    class="fi fi-rs-circle-xmark"></i></span>Verification
                                                            pending
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <form action="verify-email.php">
                                        <input type="text" class="form-control" placeholder="hello@example.com ">
                                        <button class="btn btn-primary mt-3">Add New Email</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Phone Verification</h4>
                                </div>
                                <div class="card-body">
                                    <div class="phone-verification">
                                        <ul>
                                            <li class="verified">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-rr-phone-call"></i></span>
                                                    <div>
                                                        <h5> +1 135 468 45 </h5>
                                                        <p>
                                                            <span><i class="fi fi-sr-badge-check"></i></span>
                                                            Verified
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="verified">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-rr-phone-call"></i></span>
                                                    <div>
                                                        <h5> +1 135 468 45 </h5>
                                                        <p>
                                                            <span><i class="fi fi-sr-badge-check"></i></span>
                                                            Verified
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="verified">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-rr-phone-call"></i></span>
                                                    <div>
                                                        <h5> +1 135 468 45 </h5>
                                                        <p>
                                                            <span><i class="fi fi-sr-badge-check"></i></span>
                                                            Verified
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pending">
                                                <div class="d-flex">
                                                    <span class="round-icon"><i
                                                            class="fi fi-rr-phone-call"></i></span>
                                                    <div>
                                                        <h5> +1 135 468 45</h5>
                                                        <p class="text-danger">
                                                            <span class="text-danger"><i
                                                                    class="fi fi-rs-circle-xmark"></i></span>
                                                            Verification pending
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <form action="otp-code.php">
                                        <input type="text" class="form-control" placeholder="+1 135 468 45 ">
                                        <button class="btn btn-primary mt-3">Add New Phone</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include './layouts/layoutBottom.php'?>