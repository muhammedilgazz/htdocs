<?php require_once 'includes/auth_check.php'; ?>
<?php
    $script='<script src="assets/vendor/chartjs/chartjs.js"></script>
            <script src="assets/vendor/circle-progress/circle-progress.min.js"></script>
            <script src="assets/js/plugins/circle-progress-init.js"></script>';
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
                                    <h3>Goals</h3>
                                    <p class="mb-2">Welcome Ekash Finance Management</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="breadcrumbs"><a href="index.php">Home </a>
                                    <span><i class="fi fi-rr-angle-small-right"></i></span>
                                    <a href="#">Goals</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="goals-tab">
                <div class="row g-0">
                    <div class="col-xl-3">
                        <div class="nav d-block">
                            <div class="row">
                                <div class="col-xl-12 col-md-6">
                                    <div class="goals-nav active" data-bs-toggle="pill" data-bs-target="#a1">
                                        <div class="goals-nav-circle">
                                            <div id="circle5"></div>
                                            <span>20%</span>
                                        </div>
                                        <div class="goals-nav-text">
                                            <h3>Car</h3>
                                            <p><strong>$1458.30</strong> / $4580.85</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-6">
                                    <div class="goals-nav" data-bs-toggle="pill" data-bs-target="#a2">
                                        <div class="goals-nav-circle">
                                            <div id="circle6"></div>
                                            <span>20%</span>
                                        </div>
                                        <div class="goals-nav-text">
                                            <h3>Laptop</h3>
                                            <p><strong>$1458.30</strong> / $4580.85</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-6">
                                    <div class="goals-nav" data-bs-toggle="pill" data-bs-target="#a3">
                                        <div class="goals-nav-circle">
                                            <div id="circle7"></div>
                                            <span>20%</span>
                                        </div>
                                        <div class="goals-nav-text">
                                            <h3>Vacation</h3>
                                            <p><strong>$1458.30</strong> / $4580.85</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-6">
                                    <div class="goals-nav" data-bs-toggle="pill" data-bs-target="#a4">
                                        <div class="goals-nav-circle">
                                            <div id="circle8"></div>
                                            <span>20%</span>
                                        </div>
                                        <div class="goals-nav-text">
                                            <h3>Phone</h3>
                                            <p><strong>$1458.30</strong> / $4580.85</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-goals-link">
                            <h5 class="mb-0">Add new goals</h5>
                            <a href="add-new-account.php">
                                <i class="fi fi-rr-square-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="tab-content goals-tab-content">
                            <div class="tab-pane show active" id="a1">
                                <div class="goals-tab-title">
                                    <h3>Car</h3>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span>Saved</span>
                                                        <h3>$1458.30</h3>
                                                    </div>
                                                    <div class="text-end">
                                                        <span>Goals</span>
                                                        <h3>$1458.30</h3>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: 25%;"
                                                        role="progressbar">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <span>25%</span>
                                                    <span>75%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Last Month</p>
                                                            <h3>$42,678</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Expenses</p>
                                                            <h3>$1,798</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Taxes</p>
                                                            <h3>$255.25</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Debt</p>
                                                            <h3>$365,478</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Available by Wallet</h4>
                                            </div>
                                            <div class="card-body available-wallet">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-yellow-500"><i
                                                                    class="fi fi-rr-bank"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">City Bank</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: 75%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-indigo-500"><i
                                                                    class="fi fi-rr-money-bills-simple"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">Cash Wallet</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-success"
                                                                    role="progressbar" style="width: 25%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-purple-500"><i
                                                                    class="fi fi-rr-credit-card"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">Visa Card</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                    style="width: 50%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">History </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table mb-0 table-responsive-sm goals-history-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>wallet</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="a2">
                                <div class="goals-tab-title">
                                    <h3>Laptop</h3>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span>Saved</span>
                                                        <h3>$1458.30</h3>
                                                    </div>
                                                    <div class="text-end">
                                                        <span>Goals</span>
                                                        <h3>$1458.30</h3>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: 25%;"
                                                        role="progressbar">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <span>25%</span>
                                                    <span>75%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Last Month</p>
                                                            <h3>$42,678</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Expenses</p>
                                                            <h3>$1,798</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Taxes</p>
                                                            <h3>$255.25</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Debt</p>
                                                            <h3>$365,478</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Available by Wallet</h4>
                                            </div>
                                            <div class="card-body available-wallet">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-yellow-500"><i
                                                                    class="fi fi-rr-bank"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">City Bank</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: 75%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-indigo-500"><i
                                                                    class="fi fi-rr-money-bills-simple"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">Cash Wallet</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-success"
                                                                    role="progressbar" style="width: 25%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-purple-500"><i
                                                                    class="fi fi-rr-credit-card"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">Visa Card</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                    style="width: 50%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">History </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table mb-0 table-responsive-sm goals-history-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>wallet</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="a3">
                                <div class="goals-tab-title">
                                    <h3>Vacation</h3>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span>Saved</span>
                                                        <h3>$1458.30</h3>
                                                    </div>
                                                    <div class="text-end">
                                                        <span>Goals</span>
                                                        <h3>$1458.30</h3>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: 25%;"
                                                        role="progressbar">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <span>25%</span>
                                                    <span>75%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Last Month</p>
                                                            <h3>$42,678</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Expenses</p>
                                                            <h3>$1,798</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Taxes</p>
                                                            <h3>$255.25</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Debt</p>
                                                            <h3>$365,478</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Available by Wallet</h4>
                                            </div>
                                            <div class="card-body available-wallet">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-yellow-500"><i
                                                                    class="fi fi-rr-bank"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">City Bank</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: 75%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-indigo-500"><i
                                                                    class="fi fi-rr-money-bills-simple"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">Cash Wallet</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-success"
                                                                    role="progressbar" style="width: 25%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-purple-500"><i
                                                                    class="fi fi-rr-credit-card"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">Visa Card</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                    style="width: 50%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">History </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table mb-0 table-responsive-sm goals-history-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>wallet</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="a4">
                                <div class="goals-tab-title">
                                    <h3>Phone</h3>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span>Saved</span>
                                                        <h3>$1458.30</h3>
                                                    </div>
                                                    <div class="text-end">
                                                        <span>Goals</span>
                                                        <h3>$1458.30</h3>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: 25%;"
                                                        role="progressbar">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mt-2">
                                                    <span>25%</span>
                                                    <span>75%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Last Month</p>
                                                            <h3>$42,678</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Expenses</p>
                                                            <h3>$1,798</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Taxes</p>
                                                            <h3>$255.25</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                        <div class="goals-widget">
                                                            <p>Debt</p>
                                                            <h3>$365,478</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Available by Wallet</h4>
                                            </div>
                                            <div class="card-body available-wallet">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-yellow-500"><i
                                                                    class="fi fi-rr-bank"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">City Bank</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: 75%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-indigo-500"><i
                                                                    class="fi fi-rr-money-bills-simple"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">Cash Wallet</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-success"
                                                                    role="progressbar" style="width: 25%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-grow-2 goals-wallet-progress">
                                                        <div class="goals-icon">
                                                            <span class="bg-purple-500"><i
                                                                    class="fi fi-rr-credit-card"></i></span>
                                                        </div>
                                                        <div class="goals-info flex-grow-2 me-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <h5 class="mb-1">Visa Card</h5>
                                                                <p class="mb-0">150$</p>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                    style="width: 50%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">History </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table mb-0 table-responsive-sm goals-history-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>wallet</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><span><i class="fi fi-rr-calendar"></i></span>
                                                                    29 Jan 2024</td>
                                                                <td><span><i
                                                                            class="fi fi-rr-credit-card"></i></span>
                                                                    Master Card</td>
                                                                <td>Necessities</td>
                                                                <td>
                                                                    <h5>+100.00$</h5>
                                                                    <span>12.368$</span>
                                                                </td>
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
        </div>
    </div>

<?php include './layouts/layoutBottom.php'?>