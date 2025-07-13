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
                                    <h3>Session</h3>
                                    <p class="mb-2">Welcome Ekash Finance Management</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="breadcrumbs"><a href="index.php">Home </a>
                                    <span><i class="fi fi-rr-angle-small-right"></i></span>
                                    <a href="#">Session</a>
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
                        <div class="col-xxl-12">
                            <h4 class="card-title mb-3">Third-Party Applications </h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center"><span
                                            class="me-3 icon-circle bg-warning text-white"><i
                                                class="fi fi-rs-messages-question"></i></span>
                                        <div>
                                            <h5 class="mb-0">You haven't authorized any applications yet.</h5>
                                            <p>After connecting an application with your account, you can manage or
                                                revoke its
                                                access here.</p><a class="btn btn-primary">Authorize now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-3">Web Sessions</h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive table-icon">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Signed In</th>
                                                    <th>Browser</th>
                                                    <th>IP Address</th>
                                                    <th>Near</th>
                                                    <th>Current</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1 day ago</td>
                                                    <td>Chrome (Windows)</td>
                                                    <td>250.364.239.254</td>
                                                    <td>Bangladesh, Dhaka</td>
                                                    <td><span><i
                                                                class="fi fi-bs-check text-success me-1"></i></span><span><i
                                                                class="fi fi-sr-cross-small text-danger"></i></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1 day ago</td>
                                                    <td>Chrome (Windows)</td>
                                                    <td>250.364.239.254</td>
                                                    <td>Bangladesh, Dhaka</td>
                                                    <td><span><i
                                                                class="fi fi-bs-check text-success me-1"></i></span><span><i
                                                                class="fi fi-sr-cross-small text-danger"></i></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1 day ago</td>
                                                    <td>Chrome (Windows)</td>
                                                    <td>250.364.239.254</td>
                                                    <td>Bangladesh, Dhaka</td>
                                                    <td><span><i
                                                                class="fi fi-bs-check text-success me-1"></i></span><span><i
                                                                class="fi fi-sr-cross-small text-danger"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-3">Confirmed Devices</h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Confirmed</th>
                                                    <th>Browser</th>
                                                    <th>IP Address</th>
                                                    <th>Near</th>
                                                    <th>Current</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1 day ago</td>
                                                    <td>Chrome (Windows)</td>
                                                    <td> 250.364.239.254</td>
                                                    <td>Bangladesh, Dhaka</td>
                                                    <td><span><i
                                                                class="fi fi-bs-check text-success me-1"></i></span><span><i
                                                                class="fi fi-sr-cross-small text-danger"></i></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8 days ago</td>
                                                    <td>Chrome (Windows)</td>
                                                    <td> 250.364.239.254</td>
                                                    <td>Bangladesh, Dhaka</td>
                                                    <td><span><i
                                                                class="fi fi-bs-check text-success me-1"></i></span><span><i
                                                                class="fi fi-sr-cross-small text-danger"></i></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>15 days ago</td>
                                                    <td>Chrome (Windows)</td>
                                                    <td> 250.364.239.254</td>
                                                    <td>Bangladesh, Dhaka</td>
                                                    <td><span><i
                                                                class="fi fi-bs-check text-success me-1"></i></span><span><i
                                                                class="fi fi-sr-cross-small text-danger"></i></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-3">Account Activity</h4>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Source</th>
                                                    <th>IP Address</th>
                                                    <th>Location</th>
                                                    <th>When</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>verified second factor</td>
                                                    <td>api</td>
                                                    <td>157.119.239.254</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">about 1 hour ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>verified second factor</td>
                                                    <td>api</td>
                                                    <td>157.119.239.254</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">about 2 hours ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>second factor failure</td>
                                                    <td>api</td>
                                                    <td>157.119.239.254</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">about 2 hours ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>device confirmation completed</td>
                                                    <td>web</td>
                                                    <td>157.119.239.254</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">1 day ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signin</td>
                                                    <td>web</td>
                                                    <td>157.119.239.254</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">1 day ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>verified second factor</td>
                                                    <td>web</td>
                                                    <td>157.119.239.254</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">1 day ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signout</td>
                                                    <td>web</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">8 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signin</td>
                                                    <td>web</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">8 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>verified second factor</td>
                                                    <td>web</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">8 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signout</td>
                                                    <td>api</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">8 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signout</td>
                                                    <td>api</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">8 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>device confirmation completed</td>
                                                    <td>web</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">8 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signin</td>
                                                    <td>web</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">8 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>verified second factor</td>
                                                    <td>web</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">8 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signout</td>
                                                    <td>api</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>verified second factor</td>
                                                    <td>web</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signin</td>
                                                    <td>web</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signout</td>
                                                    <td>api</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>verified second factor</td>
                                                    <td>web</td>
                                                    <td>23.106.249.39</td>
                                                    <td>Singapore</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>verified second factor</td>
                                                    <td>api</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>xs verified</td>
                                                    <td>api</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>xs added</td>
                                                    <td>api</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                                <tr>
                                                    <td>signin</td>
                                                    <td>api</td>
                                                    <td>157.119.239.214</td>
                                                    <td>Bangladesh</td>
                                                    <td><a href="#">15 days ago</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-3">Close Account</h4>
                            <div class="card transparent">
                                <div class="card-body">
                                    <p>Withdraw funds and close your account - <span class="text-danger">this
                                            cannot be
                                            undone</span></p><a href="#" class="btn btn-danger">Close Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include './layouts/layoutBottom.php'?>