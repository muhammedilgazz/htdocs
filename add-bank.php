<?php include './layouts/layoutTop.php'?>

    <div class="content-body">
        <div class="verification section-padding">
            <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-xl-5 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Link a bank account</h4>
                            </div>
                            <div class="card-body">
                                <form action="bank-add-successful.php">
                                    <div class="form-row">
                                        <div class="mb-3 col-xl-12">
                                            <label class="mr-sm-2">Routing number </label>
                                            <input name="routing_number" type="text" class="form-control" placeholder="25487">
                                        </div>
                                        <div class="mb-3 col-xl-12">
                                            <label class="mr-sm-2">Account number </label>
                                            <input name="account_number" type="text" class="form-control" placeholder="36475">
                                        </div>
                                        <div class="mb-3 col-xl-12">
                                            <label class="mr-sm-2">Fulll name </label>
                                            <input name="full_name" type="text" class="form-control" placeholder="Carla Pascle">
                                        </div>
                                        <div class="mb-3 col-xl-12">
                                            <img src="assets/images/routing.png" alt="" class="img-fluid">
                                        </div>
                                        <div class="col-12 mt-5">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="add-new-account.php"
                                                        class="btn btn-primary w-100">Back</a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="settings-bank.php"
                                                        class="btn btn-success  w-100">Save</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include './layouts/layoutBottom.php'?>