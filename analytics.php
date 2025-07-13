<?php require_once 'includes/auth_check.php'; ?>
<?php
    $script='<script src="assets/vendor/chartjs/chartjs.js"></script>
            <script src="assets/js/plugins/chartjs-bar-weekly-expense.js"></script>';
?>
<?php include './layouts/layoutTop.php'?>

        <div class="content-body">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-xl-4">
                                    <div class="page-title-content">
                                        <h3>Analytics</h3>
                                        <p class="mb-2">Welcome Ekash Finance Management</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="index.php">Home </a>
                                        <span><i class="fi fi-rr-angle-small-right"></i></span>
                                        <a href="#">Analytics</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="settings-menu">
                            <a href="analytics.php">Analytics</a>
                            <a href="analytics-expenses.php">Expenses</a>
                            <a href="analytics-income.php">Income</a>
                            <a href="analytics-income-vs-expenses.php">Income vs Expenses</a>
                            <a href="analytics-balance.php">Balance</a>
                            <a href="analytics-transaction-history.php">Transaction History</a>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <div class="analytics-widget">
                                    <div class="widget-icon me-3 bg-primary"><span><i
                                                class="fi fi-rr-mobile"></i></span>
                                    </div>
                                    <div class="widget-content">
                                        <p>Daily Average</p>
                                        <h3>$5470.36</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="analytics-widget">
                                    <div class="widget-icon me-3 bg-success"><span><i
                                                class="fi fi-rr-replace"></i></span>
                                    </div>
                                    <div class="widget-content">
                                        <p>Change</p>
                                        <h3>+47.36%</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="analytics-widget">
                                    <div class="widget-icon me-3 bg-warning"><span><i
                                                class="fi fi-rs-receipt"></i></span>
                                    </div>
                                    <div class="widget-content">
                                        <p>Total Transaction</p>
                                        <h3>354</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="analytics-widget">
                                    <div class="widget-icon me-3 bg-danger">
                                        <span><i class="fi fi-ss-confetti"></i></span>
                                    </div>
                                    <div class="widget-content">
                                        <p>Categories</p>
                                        <h3>40</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Weekly Expenses </h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="chartjsWeeklyExpenses"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

$layoutPath = './layouts/layoutBottom.php';
if (file_exists($layoutPath) && is_file($layoutPath)) {
    include $layoutPath;
} else {
    // Handle error or log the issue
    error_log("Layout file not found or is not a file: " . $layoutPath);
}
?>