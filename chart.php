<?php
    $script='<script src="assets/vendor/chartjs/chartjs.js"></script>
            <script src="assets/js/plugins/chartjs-bar.js"></script>
            <script src="assets/js/plugins/chartjs-line.js"></script>
            <script src="assets/js/plugins/chartjs-donut.js"></script>
            <script src="assets/js/plugins/chartjs-bar-budget-period.js"></script>
            <script src="assets/js/plugins/chartjs-bar-income-vs-expense.js"></script>
            <script src="assets/js/plugins/chartjs-bar-weekly-expense.js"></script>
            <script src="assets/js/plugins/chartjs-line-balance-overtime.js"></script>
            <script src="assets/js/plugins/chartjs-line-balance-trend.js"></script>
            <script src="assets/js/plugins/chartjs-line-balance-wallet.js"></script>
            <script src="assets/js/plugins/chartjs-line-total-balance.js"></script>
            <script src="assets/js/plugins/chartjs-donut-exchange.js"></script>
            <script src="assets/js/plugins/chartjs-profile-wallet.js"></script>
            <script src="assets/js/plugins/chartjs-profile-wallet2.js"></script>
            <script src="assets/js/plugins/chartjs-profile-wallet3.js"></script>
            <script src="assets/js/plugins/chartjs-profile-wallet4.js"></script>';
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
                                        <h3>Dashboard</h3>
                                        <p class="mb-2">Welcome Ekash Finance Management</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="index.php">Home </a>
                                        <span><i class="fi fi-rr-angle-small-right"></i></span>
                                        <a href="#">Dashboard</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Bar </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsBar"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Line </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsLine"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Donut </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsDonut"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Income vs Expense </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsIncomeVsExpense"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Weekly Expenses </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsWeeklyExpenses"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Balance Overtime </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsBalanceOvertime"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Balance Trend </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsBalanceTrend"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Budget Period </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsBudgetPeriod"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Balance Wallet </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsBalanceWallet"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Total Balance </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsTotalBalance"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Donut Exchange </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjsDonutExchange"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Area Chart</h4>
                                <div id="area-chart-action">
                                    <span> Day </span>
                                    <span> Week </span>
                                    <span> Month </span>
                                    <span> Year </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="profileWallet" class="chartjs"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include './layouts/layoutBottom.php'?>