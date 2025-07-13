<?php
    $script='<script>
                window.setTimeout(function() {
                    window.location.href = "verified-id.html";
                }, 2000);
            </script>';
?>
<?php include './layouts/layoutTop.php'?>

    <div class="content-body">
        <div class="verification section-padding">
            <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-xl-5 col-md-6">
                        <div class="card">
                            <div class="card-body identity-content">
                                <form action="verify-step-4.php">
                                    <span class="icon"><i class="fi fi-rr-shield-check"></i></span>
                                    <h4>We are verifying your ID</h4>
                                    <p>Your identity is being verified. We will email you once your verification
                                        has
                                        completed.
                                    </p>
                                    <div class="upload-loading text-center mb-3">
                                        <i class="fi fi-rs-loading"></i>
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