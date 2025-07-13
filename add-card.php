<?php include './layouts/layoutTop.php'?>

    <div class="content-body">
        <div class="verification section-padding">
            <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-xl-5 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Link a debit card</h4>
                            </div>
                            <div class="card-body">
                                <form action="bank-add-successful.php">
                                    <div class="row">
                                        <div class="mb-3 col-xl-12">
                                            <label class="form-label">Name on card </label>
                                            <input name="card_name" type="text" class="form-control" placeholder="Carla Pascle">
                                        </div>
                                        <div class="mb-3 col-xl-12">
                                            <label class="form-label">Card number </label>
                                            <input name="card_number" type="text" class="form-control"
                                                placeholder="5658 4258 6358 4756">
                                        </div>
                                        <div class="mb-3 col-xl-4">
                                            <label class="form-label">Expiration </label>
                                            <input name="expiration" type="text" class="form-control" placeholder="10/22">
                                        </div>
                                        <div class="mb-3 col-xl-4">
                                            <label class="form-label">CVC </label>
                                            <input name="cvc" type="text" class="form-control" placeholder="125">
                                        </div>
                                        <div class="mb-3 col-xl-4">
                                            <label class="form-label">Postal code </label>
                                            <input name="postal_code" type="text" class="form-control" placeholder="2368">
                                        </div>
                                        <div class="text-center col-12">
                                            <button type="submit" class="btn btn-success w-100">Save</button>
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