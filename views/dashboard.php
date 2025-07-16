<?php require_once 'C:/xampp/htdocs/views/partials/head.php'; ?>

<body>
    <div class="app-container">
        <?php require_once 'C:/xampp/htdocs/views/partials/sidebar.php'; ?>
        
        <div class="app-main">
            <?php require_once 'C:/xampp/htdocs/views/partials/header.php'; ?>
            
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Dashboard Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="h3 mb-0">Dashboard</h1>
                                    <p class="text-muted mb-0">Xtreme Bütçe Yönetim Paneline Hoş Geldiniz</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kompakt İstatistik Kartları -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card danger fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon danger">
                                        <i class="material-icons-round">trending_down</i>
                                    </div>
                                    <div class="stat-label">Aylık Gider</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($total_expenses, 2, ',', '.') ?></div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card warning fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon warning">
                                        <i class="material-icons-round">shopping_cart</i>
                                    </div>
                                    <div class="stat-label">Aylık Alınacaklar</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($total_wishlist, 2, ',', '.') ?></div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card info fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon info">
                                        <i class="material-icons-round">receipt_long</i>
                                    </div>
                                    <div class="stat-label">Aylık Borç Ödemeleri</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($total_debt_payments, 2, ',', '.') ?></div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card primary fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon primary">
                                        <i class="material-icons-round">account_balance_wallet</i>
                                    </div>
                                    <div class="stat-label">Toplam Bakiye</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($total_balance, 2, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik ve Tablo -->
                    <div class="row">
                        <!-- Harcama Analizi Grafiği -->
                        <div class="col-xl-8 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Kategoriye Göre Gider Dağılımı</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="categoryExpenseChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Son İşlemler -->
                        <div class="col-xl-4 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Son İşlemler</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recent_transactions as $transaction): ?>
                                        <div class="list-group-item border-0 px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-<?= $transaction['type'] == 'expense' ? 'danger' : 'warning' ?> bg-opacity-10 rounded-circle p-2">
                                                        <i class="material-icons-round text-<?= $transaction['type'] == 'expense' ? 'danger' : 'warning' ?>">
                                                            <?= $transaction['type'] == 'expense' ? 'receipt' : 'shopping_cart' ?>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1"><?= htmlspecialchars($transaction['description']) ?></h6>
                                                    <small class="text-muted">
                                                        <?= date('d.m.Y', strtotime($transaction['date'])) ?>
                                                    </small>
                                                </div>
                                                <div class="text-end">
                                                    <h6 class="mb-1 text-danger">
                                                        -₺<?= number_format($transaction['amount'], 2, ',', '.') ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card fade-in">
                                <div class="card-header">
                                    <h5 class="card-title">Hızlı İşlemler</h5>
                                </div>
                                <div class="card-body">
                                    <div class="quick-actions-grid">
                                        <a href="/budgets" class="quick-action-card">
                                            <div class="quick-action-icon primary">
                                                <i class="material-icons-round">pie_chart</i>
                                            </div>
                                            <h6>Bütçeler</h6>
                                            <p>Aylık bütçe planlaması</p>
                                        </a>
                                        <a href="/analytics" class="quick-action-card">
                                            <div class="quick-action-icon success">
                                                <i class="material-icons-round">analytics</i>
                                            </div>
                                            <h6>Analizler</h6>
                                            <p>Finansal analiz</p>
                                        </a>
                                        <a href="/goals" class="quick-action-card">
                                            <div class="quick-action-icon warning">
                                                <i class="material-icons-round">flag</i>
                                            </div>
                                            <h6>Hedefler</h6>
                                            <p>Tasarruf hedefleri</p>
                                        </a>
                                        <a href="/wallets" class="quick-action-card">
                                            <div class="quick-action-icon info">
                                                <i class="material-icons-round">account_balance_wallet</i>
                                            </div>
                                            <h6>Cüzdanlar</h6>
                                            <p>Hesap yönetimi</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Hızlı Erişim Bölümü -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="material-icons-round me-2">bolt</i>
                                        Hızlı Erişim
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Gider Ekleme -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/expense" class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="material-icons-round mb-2" style="font-size: 2rem;">receipt_long</i>
                                                <span class="fw-bold">Yeni Gider</span>
                                                <small class="text-muted">Gider ekle/düzenle</small>
                                            </a>
                                        </div>

                                        <!-- Wishlist Ekleme -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/wishlist" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="material-icons-round mb-2" style="font-size: 2rem;">shopping_cart</i>
                                                <span class="fw-bold">Alınacak Ekle</span>
                                                <small class="text-muted">Wishlist yönetimi</small>
                                            </a>
                                        </div>

                                        <!-- İhtiyaç Ekleme -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/wishlist?type=ihtiyac" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="material-icons-round mb-2" style="font-size: 2rem;">local_grocery_store</i>
                                                <span class="fw-bold">İhtiyaç Ekle</span>
                                                <small class="text-muted">Temel ihtiyaçlar</small>
                                            </a>
                                        </div>

                                        <!-- Raporlar -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/expense?report=monthly" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="material-icons-round mb-2" style="font-size: 2rem;">analytics</i>
                                                <span class="fw-bold">Raporlar</span>
                                                <small class="text-muted">Aylık/yıllık analiz</small>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- İkinci Satır - Ek Özellikler -->
                                    <div class="row g-3 mt-2">
                                        <!-- Hesap Şifreleri -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/accountpassword" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="material-icons-round mb-2" style="font-size: 2rem;">vpn_key</i>
                                                <span class="fw-bold">Hesap Şifreleri</span>
                                                <small class="text-muted">Güvenli saklama</small>
                                            </a>
                                        </div>

                                        <!-- Banka Hesapları -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/bankaccount" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="material-icons-round mb-2" style="font-size: 2rem;">account_balance</i>
                                                <span class="fw-bold">Banka Hesapları</span>
                                                <small class="text-muted">IBAN bilgileri</small>
                                            </a>
                                        </div>

                                        <!-- Borç Takibi -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/tax" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="material-icons-round mb-2" style="font-size: 2rem;">receipt</i>
                                                <span class="fw-bold">Borç Takibi</span>
                                                <small class="text-muted">Vergi, SGK, İcra</small>
                                            </a>
                                        </div>

                                        <!-- Ayarlar -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/settings" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                                <i class="material-icons-round mb-2" style="font-size: 2rem;">settings</i>
                                                <span class="fw-bold">Ayarlar</span>
                                                <small class="text-muted">Sistem ayarları</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'C:/xampp/htdocs/views/partials/script.php'; ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kategoriye Göre Gider Dağılımı Grafiği
        const ctx = document.getElementById('categoryExpenseChart').getContext('2d');
        const categoryData = <?= json_encode($category_expenses) ?>;
        
        const labels = categoryData.map(item => item.category_type);
        const data = categoryData.map(item => item.total_amount);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Toplam Harcama',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
    </script>

</body>
</html>
