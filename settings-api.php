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
                                        <h3>Api</h3>
                                        <p class="mb-2">Welcome Ekash Finance Management</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="index.php">Home </a>
                                        <span><i class="fi fi-rr-angle-small-right"></i></span>
                                        <a href="#">Api</a>
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
                                <h4 class="card-title mb-3">Create API Key</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-xxl-6 col-xl-6 col-lg-6 mb-3"><label
                                                        class="form-label">Generate New
                                                        Key</label><input name="generateKey" type="text"
                                                        class="form-control"></div>
                                                <div class="col-xxl-6 col-xl-6 col-lg-6 mb-3"><label
                                                        class="form-label">Confirm
                                                        Passphrase</label><input name="confirmKey" type="text"
                                                        class="form-control"></div>
                                            </div>
                                            <div class="mt-3"><button type="submit"
                                                    class="btn btn-primary mr-2">Save</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <h4 class="card-title mb-3">Your API Keys</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive api-table">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Key</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>69e387f1-31c3-45ad-9c68-5a51e5e78b43</td>
                                                        <td>
                                                            <div class="form-check form-switch"><input
                                                                    class="form-check-input" type="checkbox" checked="">
                                                            </div>
                                                        </td>
                                                        <td><span><i class="fi fi-rs-trash"></i></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>69e387f1-31c3-45ad-9c68-5a51e5e78b43</td>
                                                        <td>
                                                            <div class="form-check form-switch"><input
                                                                    class="form-check-input" type="checkbox"></div>
                                                        </td>
                                                        <td><span><i class="fi fi-rs-trash"></i></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>69e387f1-31c3-45ad-9c68-5a51e5e78b43</td>
                                                        <td>
                                                            <div class="form-check form-switch"><input
                                                                    class="form-check-input" type="checkbox"></div>
                                                        </td>
                                                        <td><span><i class="fi fi-rs-trash"></i></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>69e387f1-31c3-45ad-9c68-5a51e5e78b43</td>
                                                        <td>
                                                            <div class="form-check form-switch"><input
                                                                    class="form-check-input" type="checkbox"></div>
                                                        </td>
                                                        <td><span><i class="fi fi-rs-trash"></i></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>69e387f1-31c3-45ad-9c68-5a51e5e78b43</td>
                                                        <td>
                                                            <div class="form-check form-switch"><input
                                                                    class="form-check-input" type="checkbox"></div>
                                                        </td>
                                                        <td><span><i class="fi fi-rs-trash"></i></span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include './layouts/layoutBottom.php'?>