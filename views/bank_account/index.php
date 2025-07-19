<?php require_once ROOT_PATH . '/views/partials/head.php'; ?>

<body>
    <div class="app-container">
        <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
        
        <div class="app-main">
            <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
            
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-12">
                            <?php
                            $page_title = 'Banka Hesapları';
                            $page_description = 'Banka hesapları yönetimi';
                            $breadcrumb_active = 'Banka Hesapları';
                            include ROOT_PATH . '/views/partials/page_header.php';
                            ?>
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

    <?php require_once ROOT_PATH . '/views/partials/script.php'; ?>
</body>
</html>