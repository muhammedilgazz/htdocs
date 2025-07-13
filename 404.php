<?php
http_response_code(404);
require_once 'partials/head.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Sayfa Bulunamadı</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 text-center">
                <div class="error-page">
                    <h1 class="display-1 text-primary">404</h1>
                    <h2 class="mb-4">Sayfa Bulunamadı</h2>
                    <p class="mb-4">Aradığınız sayfa mevcut değil veya taşınmış olabilir.</p>
                    <a href="index.php" class="btn btn-primary">Ana Sayfaya Dön</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>