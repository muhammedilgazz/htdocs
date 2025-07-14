<?php require_once 'C:/xampp/htdocs/views/layouts/layoutTop.php'; ?>

        <div class="content-body">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-xl-4">
                                    <div class="page-title-content">
                                        <h3>Profile</h3>
                                        <p class="mb-2">Welcome Ekash Finance Management</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="/">Home </a>
                                        <span><i class="fi fi-rr-angle-small-right"></i></span>
                                        <a href="#">Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-name">
                                    <div class="d-flex">
                                        <img src="assets/images/avatar/1.jpg" alt="">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0"><?= $user_profile['full_name'] ?></h4>
                                            <p><?= $user_profile['email'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-reg">
                                    <div class="registered">
                                        <h5><?= $user_profile['registered_date'] ?></h5>
                                        <p>Registered</p>
                                    </div>
                                    <span class="reg_divider"></span>
                                    <div class="rank">
                                        <h5>Referral</h5>
                                        <p><?= $user_profile['referral_count'] ?></p>
                                    </div>
                                </div>
                                <div class="profile-wallet-nav">
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a data-bs-toggle="tab" href="#city-bank" class="active">
                                                <span class="icons usd">
                                                    <i class="fi fi-rr-bank"></i>
                                                </span>
                                                City Bank
                                                <span><i class="fi fi-bs-angle-right"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tab" href="#debit-card">
                                                <span class="icons gift"><i class="fi fi-rr-credit-card"></i></span>
                                                Debit Card
                                                <span><i class="fi fi-bs-angle-right"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tab" href="#visa-card">
                                                <span class="icons cart"><i class="fi fi-brands-visa"></i></span>
                                                Visa Card
                                                <span><i class="fi fi-bs-angle-right"></i></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tab" href="#cash">
                                                <span class="icons link"><i
                                                        class="fi fi-rr-money-bill-wave-alt"></i></span>
                                                Cash
                                                <span><i class="fi fi-bs-angle-right"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="tab-content profile-wallet-tab">
                            <div class="tab-pane fade show active" id="city-bank">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="wallet-progress-data">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span>Spend</span>
                                                    <h3>$<?= $city_bank_wallet['spend'] ?></h3>
                                                </div>
                                                <div class="text-end">
                                                    <span>Budget</span>
                                                    <h3>$<?= $city_bank_wallet['budget'] ?></h3>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: <?= $city_bank_wallet['progress'] ?>%;" role="progressbar">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span><?= $city_bank_wallet['progress'] ?>%</span>
                                                <span><?= 100 - $city_bank_wallet['progress'] ?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            City Bank
                                        </h4>
                                        <div id="area-chart-action" class="nav d-block">
                                            <span class="active" data-bs-toggle="tab">
                                                Day
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Week
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Month
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Year
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="profileWallet"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="debit-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="wallet-progress-data">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span>Spend</span>
                                                    <h3>$<?= $debit_card_wallet['spend'] ?></h3>
                                                </div>
                                                <div class="text-end">
                                                    <span>Budget</span>
                                                    <h3>$<?= $debit_card_wallet['budget'] ?></h3>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: <?= $debit_card_wallet['progress'] ?>%;" role="progressbar">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span><?= $debit_card_wallet['progress'] ?>%</span>
                                                <span><?= 100 - $debit_card_wallet['progress'] ?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Debit Card
                                        </h4>
                                        <div id="area-chart-action2" class="nav d-block">
                                            <span class="active" data-bs-toggle="tab">
                                                Day
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Week
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Month
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Year
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="profileWallet2"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="visa-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="wallet-progress-data">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span>Spend</span>
                                                    <h3>$<?= $visa_card_wallet['spend'] ?></h3>
                                                </div>
                                                <div class="text-end">
                                                    <span>Budget</span>
                                                    <h3>$<?= $visa_card_wallet['budget'] ?></h3>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: <?= $visa_card_wallet['progress'] ?>%;" role="progressbar">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span><?= $visa_card_wallet['progress'] ?>%</span>
                                                <span><?= 100 - $visa_card_wallet['progress'] ?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Visa Card
                                        </h4>
                                        <div id="area-chart-action3" class="nav d-block">
                                            <span class="active" data-bs-toggle="tab">
                                                Day
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Week
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Month
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Year
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="profileWallet3"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cash">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="wallet-progress-data">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span>Spend</span>
                                                    <h3>$<?= $cash_wallet['spend'] ?></h3>
                                                </div>
                                                <div class="text-end">
                                                    <span>Budget</span>
                                                    <h3>$<?= $cash_wallet['budget'] ?></h3>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: <?= $cash_wallet['progress'] ?>%;" role="progressbar">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span><?= $cash_wallet['progress'] ?>%</span>
                                                <span><?= 100 - $cash_wallet['progress'] ?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Cash
                                        </h4>
                                        <div id="area-chart-action4" class="nav d-block">
                                            <span class="active" data-bs-toggle="tab">
                                                Day
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Week
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Month
                                            </span>
                                            <span data-bs-toggle="tab">
                                                Year
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="profileWallet4"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php require_once 'C:/xampp/htdocs/views/layouts/layoutBottom.php'; ?>