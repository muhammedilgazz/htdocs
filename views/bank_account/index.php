<?php require_once 'C:/xampp/htdocs/views/partials/head.php'; ?>

<body>
    <div class="app-container">
        <?php require_once 'C:/xampp/htdocs/views/partials/sidebar.php'; ?>
        
        <div class="app-main">
            <?php require_once 'C:/xampp/htdocs/views/partials/header.php'; ?>
            
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="h3 mb-0">BankAccount</h1>
                                    <p class="text-muted mb-0">Banka hesapları yönetimi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <i class="bi bi-tools display-1 text-muted mb-3"></i>
                                    <h4 class="text-muted">Bu Sayfa Geliştirme Aşamasında</h4>
                                    <p class="text-muted">Banka hesapları yönetimi için sayfası yakında hazır olacak.</p>
                                    <?php if (isset($message)): ?>
                                        <div class="alert alert-info mt-3">
                                            <?= $message ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'C:/xampp/htdocs/views/partials/script.php'; ?>
</body>
</html>