<?php require_once 'includes/auth_check.php'; ?>
<?php
    $script='<script src="assets/vendor/chartjs/chartjs.js"></script>
        <script src="assets/js/plugins/chartjs-donut.js"></script>';
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
                                        <h3>Income</h3>
                                        <p class="mb-2">Welcome Ekash Finance Management</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="index.php">Home </a>
                                        <span><i class="fi fi-rr-angle-small-right"></i></span>
                                        <a href="#">Income</a>
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
                            <div class=" col-xxl-4 col-xl-4 col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Income Breakdown</h4>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="chartjsDonut"></canvas>
                                        <div class="list-1 mt-3">
                                            <ul>
                                                <li>
                                                    <p class="mb-0">Food</p>
                                                    <h5 class="mb-0"><span>$1200</span>38%</h5>
                                                </li>
                                                <li>
                                                    <p class="mb-0">Transport</p>
                                                    <h5 class="mb-0"><span>$1200</span>38%</h5>
                                                </li>
                                                <li>
                                                    <p class="mb-0">Healthcare</p>
                                                    <h5 class="mb-0"><span>$1200</span>38%</h5>
                                                </li>
                                                <li>
                                                    <p class="mb-0">Education</p>
                                                    <h5 class="mb-0"><span>$1200</span>38%</h5>
                                                </li>
                                                <li>
                                                    <p class="mb-0">Clothes</p>
                                                    <h5 class="mb-0"><span>$1200</span>38%</h5>
                                                </li>
                                                <li>
                                                    <p class="mb-0">Pets</p>
                                                    <h5 class="mb-0"><span>$1200</span>38%</h5>
                                                </li>
                                                <li>
                                                    <p class="mb-0">Entertainment</p>
                                                    <h5 class="mb-0"><span>$1200</span>38%</h5>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Transaction History</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="transaction-table">
                                            <div class="table-responsive">
                                                <table class="table mb-0 table-responsive-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Date</th>
                                                            <th>Description</th>
                                                            <th>Amount</th>
                                                            <th>Currency</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-emerald-500 fi fi-rr-barber-shop"></i>
                                                                    Beauty</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-teal-500 fi fi-rr-receipt"></i> Bills
                                                                    &
                                                                    Fees</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-cyan-500 fi fi-rr-car-side"></i>
                                                                    Car</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-sky-500 fi fi-rr-graduation-cap"></i>
                                                                    Education</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-blue-500 fi fi-rr-clapperboard-play"></i>
                                                                    Entertainment</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-emerald-500 fi fi-rr-barber-shop"></i>
                                                                    Beauty</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-teal-500 fi fi-rr-receipt"></i> Bills
                                                                    &
                                                                    Fees</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-cyan-500 fi fi-rr-car-side"></i>
                                                                    Car</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-sky-500 fi fi-rr-graduation-cap"></i>
                                                                    Education</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="table-category-icon"><i
                                                                        class="bg-blue-500 fi fi-rr-clapperboard-play"></i>
                                                                    Entertainment</span>
                                                            </td>
                                                            <td>
                                                                12.12.2023
                                                            </td>
                                                            <td>
                                                                Grocery Items and Beverage soft drinks
                                                            </td>
                                                            <td>
                                                                -32.20
                                                            </td>
                                                            <td>USD</td>
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
        </div>

<?php include './layouts/layoutBottom.php'?>