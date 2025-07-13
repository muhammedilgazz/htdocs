<?php include './layouts/layoutTop.php'?>

    <div class="content-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-xl-4">
                                <div class="page-title-content">
                                    <h3>Create Ticket</h3>
                                    <p class="mb-2">Welcome Ekash Finance Management</p>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="breadcrumbs"><a href="index.php">Home </a>
                                    <span><i class="fi fi-rr-angle-small-right"></i></span>
                                    <a href="#">Create Ticket</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create Ticket</h4>
                            <span>Cancel</span>
                        </div>
                        <div class="card-body">
                            <form action="support-tickets.php">
                                <div class="mb-3">
                                    <label class="form-label">What the type question do you want?</label>
                                    <select class="form-select">
                                        <option> Earning</option>
                                        <option> Withdrawals</option>
                                        <option> Profile</option>
                                        <option> General</option>
                                        <option> Others</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Employe Respond</label>
                                    <select class="form-select">
                                        <option> Earning</option>
                                        <option> Withdrawals</option>
                                        <option> Profile</option>
                                        <option> General</option>
                                        <option> Others</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">What language do you prefer to be answered?</label>
                                    <select class="form-select">
                                        <option> Earning</option>
                                        <option> Withdrawals</option>
                                        <option> Profile</option>
                                        <option> General</option>
                                        <option> Others</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Please provide a description of the problem you are
                                        encountering</label>
                                    <textarea rows="5" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include './layouts/layoutBottom.php'?>