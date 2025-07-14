<?php require_once 'C:/xampp/htdocs/views/partials/head.php'; ?>

<body>
    <?php // Preloader can be added back if needed, for now, it is removed to simplify. ?>
    
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
                                    <h1 class="h3 mb-0">Gösterge Paneli</h1>
                                    <p class="text-muted mb-0">Ekash Finans Yönetimi'ne Hoş Geldiniz</p>
                                </div>
                                <div class="d-flex gap-3">
                                    <button class="btn btn-outlined-primary ripple" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                        <i class="material-icons-round">add</i>
                                        Harcama Ekle
                                    </button>
                                    <button class="btn btn-outlined-success ripple" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                        <i class="material-icons-round">payment</i>
                                        Ödeme Ekle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kompakt İstatistik Kartları -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon primary">
                                        <i class="material-icons-round">account_balance_wallet</i>
                                    </div>
                                    <div class="stat-label">Toplam Bakiye</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($stats['mevcut_bakiye'], 0, ',', '.') ?></div>
                                <div class="stat-change">+12.5% geçen aydan</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card success fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon success">
                                        <i class="material-icons-round">trending_up</i>
                                    </div>
                                    <div class="stat-label">Toplam Gelir</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($stats['toplam_odeme'], 0, ',', '.') ?></div>
                                <div class="stat-change">+8.3% geçen aydan</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card danger fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon danger">
                                        <i class="material-icons-round">trending_down</i>
                                    </div>
                                    <div class="stat-label">Toplam Gider</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($stats['toplam_harcama'], 0, ',', '.') ?></div>
                                <div class="stat-change negative">-5.2% geçen aydan</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card warning fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon warning">
                                        <i class="material-icons-round">schedule</i>
                                    </div>
                                    <div class="stat-label">Bekleyen</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($stats['bekleyen_harcama'] + $stats['bekleyen_odeme'], 0, ',', '.') ?></div>
                                <div class="stat-change">3 işlem</div>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik ve Tablo -->
                    <div class="row">
                        <!-- Harcama Analizi Grafiği -->
                        <div class="col-xl-8 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Bakiye Trendleri</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="expenseChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Son İşlemler -->
                        <div class="col-xl-4 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Recent Transactions</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <?php foreach (array_slice($all_transactions, 0, 4) as $transaction): ?>
                                        <div class="list-group-item border-0 px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-<?= $transaction['tip'] == 'harcama' ? 'danger' : 'success' ?> bg-opacity-10 rounded-circle p-2">
                                                        <i class="material-icons-round text-<?= $transaction['tip'] == 'harcama' ? 'danger' : 'success' ?>">
                                                            <?= $transaction['tip'] == 'harcama' ? 'remove' : 'add' ?>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1"><?= htmlspecialchars($transaction['aciklama']) ?></h6>
                                                    <small class="text-muted">
                                                        <?= date('d.m.Y', strtotime($transaction['created_at'])) ?>
                                                    </small>
                                                </div>
                                                <div class="text-end">
                                                    <h6 class="mb-1 text-<?= $transaction['tip'] == 'harcama' ? 'danger' : 'success' ?>">
                                                        <?= $transaction['tip'] == 'harcama' ? '-' : '+' ?>₺<?= number_format($transaction['tutar'], 2, ',', '.') ?>
                                                    </h6>
                                                    <small class="badge badge-<?= $transaction['durum'] == 'Ödendi' ? 'success' : 'warning' ?>">
                                                        <?= $transaction['durum'] == 'Ödendi' ? 'Paid' : 'Due' ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
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
        // Chart.js logic from the old index file
        document.addEventListener('DOMContentLoaded', function() {
            const expenseChartElement = document.getElementById('expenseChart');
            if (expenseChartElement && typeof Chart !== 'undefined') {
                try {
                    const ctx = expenseChartElement.getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // Example labels
                            datasets: [{
                                label: 'Balance',
                                data: [12000, 19000, 15000, 25000, 22000, 30000], // Example data
                                borderColor: '#6366F1',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Chart initialization error:', error);
                }
            }
        });
    </script>
</body>
</html>
