<?php
http_response_code(500);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/views/partials/head.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Sunucu Hatası</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 text-center">
                <div class="error-page">
                    <h1 class="display-1 text-danger">500</h1>
                    <h2 class="mb-4">Sunucu Hatası</h2>
                    <p class="mb-4">Bir sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.</p>
                    <a href="index.php" class="btn btn-primary">Ana Sayfaya Dön</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>