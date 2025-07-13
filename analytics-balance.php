<?php require_once 'includes/auth_check.php'; ?>
<?php
    $script='<script src="assets/vendor/chartjs/chartjs.js"></script>
            <script src="assets/js/plugins/chartjs-line-balance-wallet.js"></script>
            <script src="assets/js/plugins/chartjs-line-total-balance.js"></script>';
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
                                        <h3>Balance</h3>
                                        <p class="mb-2">Welcome Ekash Finance Management</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="index.php">Home </a>
                                        <span><i class="fi fi-rr-angle-small-right"></i></span>
                                        <a href="#">Balance</a>
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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Total Balance </h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="chartjsTotalBalance"></canvas>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Balance by Wallet </h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="chartjsBalanceWallet"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include './layouts/layoutBottom.php'?>