<?php include './layouts/layoutTop.php'?>

        <div class="content-body">
            <div class="verification section-padding">
                <div class="container h-100">
                    <div class="row justify-content-center h-100 align-items-center">
                        <div class="col-xl-5 col-md-6">
                            <div class="card">
                                <!-- <div class="card-header">
                                <h4 class="card-title">Link a Debit card</h4>
                                </div> -->
                                <div class="card-body">
                                    <form action="verifying-id.php" class="identity-upload">
                                        <div class="identity-content">
                                            <h4>Upload your ID card</h4>
                                            <span>(Driving License or Government ID card)</span>
                                            <p>Uploading your ID helps as ensure the safety and security of your founds
                                            </p>
                                        </div>
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between mb-2">
                                                <label class="form-label">Upload Front ID </label>
                                                <span class="float-right">Maximum file size is 2mb</span>
                                            </div>
                                            <div class="file-upload-wrapper" data-text="front.jpg">
                                                <input name="file-upload-field" type="file" class="file-upload-field">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <label class="form-label">Upload Back ID </label>
                                                <span class="float-right">Maximum file size is 2mb</span>
                                            </div>
                                            <div class="file-upload-wrapper" data-text="back.jpg">
                                                <input name="file-upload-field" type="file" class="file-upload-field">
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <button type="submit" class="btn btn-success w-100">Submit</button>
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