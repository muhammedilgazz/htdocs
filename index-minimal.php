<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';

// Güvenlik kontrolü
$security = new SecurityManager();
$security->checkSession();

// Veritabanı bağlantısı
$db = Database::getInstance();

// Kullanıcı bilgileri
$user_id = $_SESSION['user_id'] ?? 1;

// Dashboard verileri
$stats = $db->fetch("
    SELECT 
        (SELECT SUM(tutar) FROM harcama_kalemleri WHERE durum = 'Ödendi') as toplam_harcama,
        (SELECT SUM(tutar) FROM harcama_kalemleri WHERE durum = 'Beklemede') as bekleyen_harcama,
        (SELECT SUM(tutar) FROM odemeler WHERE durum = 'Ödendi') as toplam_odeme,
        (SELECT SUM(tutar) FROM odemeler WHERE durum = 'Beklemede') as bekleyen_odeme,
        (SELECT toplam_bakiye FROM bakiye ORDER BY id DESC LIMIT 1) as mevcut_bakiye
");

// Son işlemler
$recent_transactions = $db->fetchAll("
    SELECT 'harcama' as tip, kategori, urun as aciklama, tutar, durum, created_at 
    FROM harcama_kalemleri 
    ORDER BY created_at DESC LIMIT 5
");

$recent_payments = $db->fetchAll("
    SELECT 'odeme' as tip, kisi_adi as aciklama, tutar, durum, created_at 
    FROM odemeler 
    ORDER BY created_at DESC LIMIT 5
");

$all_transactions = array_merge($recent_transactions, $recent_payments);
usort($all_transactions, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

$all_transactions = array_slice($all_transactions, 0, 10);

// Kategori bazlı harcama analizi
$category_expenses = $db->fetchAll("
    SELECT kategori, SUM(tutar) as toplam_tutar, COUNT(*) as islem_sayisi
    FROM harcama_kalemleri 
    WHERE durum = 'Ödendi'
    GROUP BY kategori 
    ORDER BY toplam_tutar DESC
");

include 'partials/head.php';
?>

<body>
    <div class="app-container">
        <?php include 'partials/sidebar.php'; ?>
        
        <div class="app-main">
            <?php include 'partials/header.php'; ?>
            
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Dashboard Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="h3 mb-0">Dashboard</h1>
                                    <p class="text-muted mb-0">Welcome Ekash Finance Management</p>
                                </div>
                                <div class="d-flex gap-3">
                                    <button class="btn btn-primary ripple" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                        <i class="material-icons-round">add</i>
                                        Harcama Ekle
                                    </button>
                                    <button class="btn btn-success ripple" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
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
                                    <div class="stat-label">Total Balance</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($stats['mevcut_bakiye'], 0, ',', '.') ?></div>
                                <div class="stat-change">+12.5% from last month</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card success fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon success">
                                        <i class="material-icons-round">trending_up</i>
                                    </div>
                                    <div class="stat-label">Total Income</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($stats['toplam_odeme'], 0, ',', '.') ?></div>
                                <div class="stat-change">+8.3% from last month</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card danger fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon danger">
                                        <i class="material-icons-round">trending_down</i>
                                    </div>
                                    <div class="stat-label">Total Expenses</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($stats['toplam_harcama'], 0, ',', '.') ?></div>
                                <div class="stat-change negative">-5.2% from last month</div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card warning fade-in">
                                <div class="stat-header">
                                    <div class="stat-icon warning">
                                        <i class="material-icons-round">schedule</i>
                                    </div>
                                    <div class="stat-label">Pending</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($stats['bekleyen_harcama'] + $stats['bekleyen_odeme'], 0, ',', '.') ?></div>
                                <div class="stat-change">3 transactions</div>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik ve Tablo -->
                    <div class="row">
                        <!-- Harcama Analizi Grafiği -->
                        <div class="col-xl-8 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Balance Trends</h5>
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

                    <!-- Hızlı İşlemler -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card fade-in">
                                <div class="card-header">
                                    <h5 class="card-title">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-3">
                                            <a href="budgets.php" class="quick-action-card">
                                                <div class="quick-action-icon primary">
                                                    <i class="material-icons-round">pie_chart</i>
                                                </div>
                                                <h6>Budgets</h6>
                                                <p>Monthly budget planning</p>
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="analytics.php" class="quick-action-card">
                                                <div class="quick-action-icon success">
                                                    <i class="material-icons-round">analytics</i>
                                                </div>
                                                <h6>Analytics</h6>
                                                <p>Financial analysis</p>
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="goals.php" class="quick-action-card">
                                                <div class="quick-action-icon warning">
                                                    <i class="material-icons-round">flag</i>
                                                </div>
                                                <h6>Goals</h6>
                                                <p>Savings goals</p>
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="wallets.php" class="quick-action-card">
                                                <div class="quick-action-icon info">
                                                    <i class="material-icons-round">account_balance_wallet</i>
                                                </div>
                                                <h6>Wallets</h6>
                                                <p>Account management</p>
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

    <!-- Floating Action Button -->
    <button class="fab ripple" onclick="showSnackbar('FAB tıklandı!', 'info')">
        <i class="material-icons-round">add</i>
    </button>

    <!-- Harcama Ekleme Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addExpenseForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="kategori" required>
                                <option value="">Select Category</option>
                                <option value="Food">Food</option>
                                <option value="Transport">Transport</option>
                                <option value="Healthcare">Healthcare</option>
                                <option value="Education">Education</option>
                                <option value="Entertainment">Entertainment</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" name="urun" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" class="form-control" name="tutar" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outlined" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ödeme Ekleme Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addPaymentForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Person Name</label>
                            <input type="text" class="form-control" name="kisi_adi" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" class="form-control" name="tutar" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outlined" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'layouts/layoutBottom.php'; ?>

    <script>
        // Chart.js configuration
        const ctx = document.getElementById('expenseChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Balance',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
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
    </script>
</body>
</html> 