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
                                        <h3>Categories</h3>
                                        <p class="mb-2">Welcome Ekash Finance Management</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="index.php">Home </a>
                                        <span><i class="fi fi-rr-angle-small-right"></i></span>
                                        <a href="#">Categories</a>
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
                            <div class="col-xxl-4 col-xl-4 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Create a new categories</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="create-new-category">
                                            <form class="row">
                                                <div class="mb-3 col-12">
                                                    <label class="form-label">Name </label>
                                                    <input type="text" class="form-control" placeholder="category name">
                                                </div>
                                                <div class="mb-3 col-12">
                                                    <label class="form-label">Type </label>
                                                    <select class="form-select">
                                                        <option selected>Choose...</option>
                                                        <option>Income</option>
                                                        <option>Expenses</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-6">
                                                    <label class="form-label">Icon </label>
                                                    <select class="form-select">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-6">
                                                    <label class="form-label">Color </label>
                                                    <select class="form-select">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-success w-100">Create new category</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-8 col-xl-8 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Income Categories</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="category-type">
                                            <ul>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-purple-500 fi fi-rr-usd-circle"></i>
                                                            Salary</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-red-500 fi fi-rr-store-alt"></i>
                                                            Business</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-orange-500 fi fi-rr-life-ring"></i>
                                                            Client</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-amber-500 fi fi-rr-gift"></i> Gifts</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-yellow-500 fi fi-bs-user-shield"></i>
                                                            Insurance
                                                        </span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-lime-500 fi fi-rr-sack-dollar"></i>
                                                            Loan</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-green-500 fi fi-rr-add-document"></i>
                                                            Other</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Expense Categories</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="category-type">
                                            <ul>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-emerald-500 fi fi-rr-barber-shop"></i>
                                                            Beauty</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-teal-500 fi fi-rr-receipt"></i> Bills &
                                                            Fees</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-cyan-500 fi fi-rr-car-side"></i> Car</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-sky-500 fi fi-rr-graduation-cap"></i>
                                                            Education</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-blue-500 fi fi-rr-clapperboard-play"></i>
                                                            Entertainment</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-indigo-500 fi fi-sr-family"></i> Family</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-violet-500 fi fi-rr-hamburger-soda"></i> Food
                                                            &
                                                            Drink</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-purple-500 fi fi-rr-money-bills-simple"></i>
                                                            Salary</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-fuchsia-500 fi fi-rs-pineapple"></i>
                                                            Groceries</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-pink-500 fi fi-rr-user-md"></i>
                                                            Healthcare</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-purple-500 fi fi-rr-home"></i> Home</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-rose-500 fi fi-rs-shopping-bag"></i>
                                                            Shopping</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-orange-500 fi fi-br-running"></i> Sports
                                                        </span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-emerald-500 fi fi-rr-bowling"></i>
                                                            Hobbies</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-teal-500 fi fi-rr-plane"></i> Travel</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-cyan-500 fi fi-rr-bus"></i>
                                                            Transport</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="left-category">
                                                        <span class="drag-icon"><i
                                                                class="fi fi-ss-grip-lines"></i></span>
                                                        <span class="category-icon"><i
                                                                class="bg-indigo-500 fi fi-rr-briefcase"></i>
                                                            Work</span>
                                                    </div>
                                                    <div class="right-category">
                                                        <span><i class="fi fi-rs-pencil"></i></span>
                                                        <span><i class="fi fi-rr-eye"></i></span>
                                                        <span><i class="fi fi-rr-trash"></i></span>
                                                    </div>
                                                </li>
                                            </ul>
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