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
                                        <h3>Currencies</h3>
                                        <p class="mb-2">Welcome Ekash Finance Management</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="index.php">Home </a>
                                        <span><i class="fi fi-rr-angle-small-right"></i></span>
                                        <a href="#">Currencies</a>
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
                            <div class="col-xl-3 col-sm-6">
                                <div class="stat-widget-2 d-flex align-items-center">
                                    <div class="widget-icon me-3 bg-primary"><span><i
                                                class="fi fi-br-dollar"></i></span>
                                    </div>
                                    <div class="widget-content">
                                        <h3>USD</h3>
                                        <p>1 USD = 0.92 Euro</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="stat-widget-2 d-flex align-items-center">
                                    <div class="widget-icon me-3 bg-success"><span><i class="fi fi-br-euro"></i></span>
                                    </div>
                                    <div class="widget-content">
                                        <h3>Euro</h3>
                                        <p>1 USD = 0.92 Euro</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="stat-widget-2 d-flex align-items-center">
                                    <div class="widget-icon me-3 bg-warning"><span><i class="fi fi-br-pound"></i></span>
                                    </div>
                                    <div class="widget-content">
                                        <h3>Pound</h3>
                                        <p>1 USD = 0.92 Euro</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="stat-widget-2 d-flex align-items-center">
                                    <div class="widget-icon me-3 bg-danger"><span><i class="fi fi-br-yen"></i></span>
                                    </div>
                                    <div class="widget-content">
                                        <h3>Yen</h3>
                                        <p>1 USD = 0.92 Euro</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Currency Exchange</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="buy-sell-widget">
                                            <form method="post" name="myform" class="currency_validate">
                                                <div class="mb-3">
                                                    <label class="form-label mb-3">Currency</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text">
                                                                <i class="fi fi-rr-usd-circle"></i>
                                                            </label>
                                                        </div>
                                                        <select name='currency' class="form-select">
                                                            <option>Select</option>
                                                            <option value="usd">USD</option>
                                                            <option value="euro">Euro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label mb-3">Payment Method</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text"><i
                                                                    class="fi fi-rr-credit-card"></i>
                                                            </label>
                                                        </div>
                                                        <select class="form-select" name="method">
                                                            <option>Select</option>
                                                            <option value="bank">Bank of America ********45845
                                                            </option>
                                                            <option value="master">Master Card ***********5458
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label mb-3">Enter your amount</label>
                                                    <div class="input-group">
                                                        <input type="text" name="currency_amount" class="form-control"
                                                            placeholder="0.0214 BTC">
                                                        <input type="text" name="usd_amount" class="form-control"
                                                            placeholder="125.00 USD">
                                                    </div>
                                                    <div class="d-flex justify-content-between mt-3">
                                                        <p class="mb-0">Monthly Limit</p>
                                                        <h6 class="mb-0">$49750 remaining</h6>
                                                    </div>
                                                </div>
                                                <button type="submit" name="submit"
                                                    class="btn btn-success btn-block">Exchange
                                                    Now</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Exchange Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td><span class="text-primary">Exchange Amount</span></td>
                                                        <td><span class="text-primary">75 USD </span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Payment Method</td>
                                                        <td>Bank of America Bank ***********5245</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Exchange Rate</td>
                                                        <td>1 USD = 0.92 Euro</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fee</td>
                                                        <td>$0.75 USD</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td>$68.00 Euro</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vat</td>
                                                        <td>
                                                            <div class="text-danger">$0.25 Euro</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Sub Total</td>
                                                        <td> $69.00 Euro</td>
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