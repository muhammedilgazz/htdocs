<?php 
// Fixed: Use relative path instead of hard-coded Windows path
require_once __DIR__ . '/partials/head.php'; 
?>

<body>
    <div class="app-container">
        <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
        
        <div class="app-main">
            <?php require_once __DIR__ . '/partials/header.php'; ?>
            
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Enhanced Dashboard Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="h3 mb-0 text-gradient">Dashboard</h1>
                                    <p class="text-muted mb-0">Hoş geldin! Finansal durumuna göz at.</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary btn-sm" onclick="refreshDashboard()">
                                        <i class="material-icons-round">refresh</i>
                                        Yenile
                                    </button>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#quickActionModal" style="background:#1f2e4e; border:none; font-size:0.9rem; padding:0.5rem 1rem;">
                                        <i class="bi bi-plus-circle me-2"></i>Hızlı Ekle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card danger fade-in animate-card" data-aos="fade-up" data-aos-delay="100">
                                <div class="stat-header">
                                    <div class="stat-icon danger">
                                        <i class="material-icons-round">trending_down</i>
                                    </div>
                                    <div class="stat-label">Aylık Gider</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($total_expenses, 2, ',', '.') ?></div>
                                <div class="stat-progress">
                                    <div class="progress-bar danger" style="width: 70%"></div>
                                </div>
                                <div class="stat-footer">
                                    <span class="text-danger">-5.2%</span>
                                    <span class="text-muted">geçen aya göre</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card warning fade-in animate-card" data-aos="fade-up" data-aos-delay="200">
                                <div class="stat-header">
                                    <div class="stat-icon warning">
                                        <i class="material-icons-round">shopping_cart</i>
                                    </div>
                                    <div class="stat-label">Aylık Alınacaklar</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($total_wishlist, 2, ',', '.') ?></div>
                                <div class="stat-progress">
                                    <div class="progress-bar warning" style="width: 45%"></div>
                                </div>
                                <div class="stat-footer">
                                    <span class="text-warning">+2.1%</span>
                                    <span class="text-muted">geçen aya göre</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card info fade-in animate-card" data-aos="fade-up" data-aos-delay="300">
                                <div class="stat-header">
                                    <div class="stat-icon info">
                                        <i class="material-icons-round">receipt_long</i>
                                    </div>
                                    <div class="stat-label">Borç Ödemeleri</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($total_debt_payments, 2, ',', '.') ?></div>
                                <div class="stat-progress">
                                    <div class="progress-bar info" style="width: 80%"></div>
                                </div>
                                <div class="stat-footer">
                                    <span class="text-info">+1.8%</span>
                                    <span class="text-muted">geçen aya göre</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stat-card success fade-in animate-card" data-aos="fade-up" data-aos-delay="400">
                                <div class="stat-header">
                                    <div class="stat-icon success">
                                        <i class="material-icons-round">account_balance_wallet</i>
                                    </div>
                                    <div class="stat-label">Toplam Bakiye</div>
                                </div>
                                <div class="stat-value">₺<?= number_format($total_balance, 2, ',', '.') ?></div>
                                <div class="stat-progress">
                                    <div class="progress-bar success" style="width: 65%"></div>
                                </div>
                                <div class="stat-footer">
                                    <span class="text-success">+8.5%</span>
                                    <span class="text-muted">geçen aya göre</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Charts and Analytics -->
                    <div class="row mb-4">
                        <!-- Expense Analysis Chart -->
                        <div class="col-xl-8 mb-4">
                            <div class="card modern-card" data-aos="fade-up">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Kategoriye Göre Gider Dağılımı</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Bu Ay
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Bu Ay</a></li>
                                            <li><a class="dropdown-item" href="#">Son 3 Ay</a></li>
                                            <li><a class="dropdown-item" href="#">Bu Yıl</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="categoryExpenseChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="col-xl-4 mb-4">
                            <div class="card modern-card" data-aos="fade-up" data-aos-delay="100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Son İşlemler</h5>
                                    <a href="/expense" class="btn btn-sm btn-link">Tümünü Gör</a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recent_transactions as $transaction): ?>
                                        <div class="list-group-item border-0 px-4 py-3 transaction-item">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="transaction-icon bg-<?= $transaction['type'] == 'expense' ? 'danger' : 'warning' ?> bg-opacity-10 rounded-circle p-2">
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

                    <!-- Enhanced Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card modern-card" data-aos="fade-up">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="material-icons-round me-2">bolt</i>
                                        Hızlı İşlemler
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="quick-actions-grid">
                                        <a href="/expense" class="quick-action-card primary">
                                            <div class="quick-action-icon">
                                                <i class="material-icons-round">receipt_long</i>
                                            </div>
                                            <h6>Yeni Gider</h6>
                                            <p>Harcama kaydet</p>
                                        </a>
                                        <a href="/wishlist" class="quick-action-card warning">
                                            <div class="quick-action-icon">
                                                <i class="material-icons-round">shopping_cart</i>
                                            </div>
                                            <h6>Alınacak Ekle</h6>
                                            <p>Wishlist yönet</p>
                                        </a>
                                        <a href="/project" class="quick-action-card success">
                                            <div class="quick-action-icon">
                                                <i class="material-icons-round">task</i>
                                            </div>
                                            <h6>Proje Ekle</h6>
                                            <p>Yeni proje</p>
                                        </a>
                                        <a href="/note" class="quick-action-card info">
                                            <div class="quick-action-icon">
                                                <i class="material-icons-round">note_add</i>
                                            </div>
                                            <h6>Not Ekle</h6>
                                            <p>Hızlı not</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Features Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card modern-card" data-aos="fade-up">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="material-icons-round me-2">dashboard</i>
                                        Tüm Özellikler
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Row 1 -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/expense" class="feature-card danger">
                                                <i class="material-icons-round">receipt_long</i>
                                                <span class="fw-bold">Gider Yönetimi</span>
                                                <small class="text-muted">Harcama takibi</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/wishlist" class="feature-card warning">
                                                <i class="material-icons-round">shopping_cart</i>
                                                <span class="fw-bold">Alınacaklar</span>
                                                <small class="text-muted">Wishlist yönetimi</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/tax" class="feature-card info">
                                                <i class="material-icons-round">receipt</i>
                                                <span class="fw-bold">Borç Takibi</span>
                                                <small class="text-muted">Vergi, SGK, İcra</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/bankaccount" class="feature-card success">
                                                <i class="material-icons-round">account_balance</i>
                                                <span class="fw-bold">Banka Hesapları</span>
                                                <small class="text-muted">IBAN yönetimi</small>
                                            </a>
                                        </div>
                                        <!-- Row 2 -->
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/accountpassword" class="feature-card secondary">
                                                <i class="material-icons-round">vpn_key</i>
                                                <span class="fw-bold">Hesap Şifreleri</span>
                                                <small class="text-muted">Güvenli saklama</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/project" class="feature-card primary">
                                                <i class="material-icons-round">task</i>
                                                <span class="fw-bold">Projeler</span>
                                                <small class="text-muted">Proje yönetimi</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/note" class="feature-card dark">
                                                <i class="material-icons-round">note</i>
                                                <span class="fw-bold">Notlar</span>
                                                <small class="text-muted">Not defteri</small>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <a href="/settings" class="feature-card muted">
                                                <i class="material-icons-round">settings</i>
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

    <!-- Quick Action Modal -->
    <div class="modal fade" id="quickActionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hızlı İşlem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="/expense" class="btn btn-outline-danger w-100 h-100 py-3">
                                <i class="material-icons-round mb-2">receipt_long</i><br>
                                Gider Ekle
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/wishlist" class="btn btn-outline-warning w-100 h-100 py-3">
                                <i class="material-icons-round mb-2">shopping_cart</i><br>
                                Alınacak Ekle
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/note" class="btn btn-outline-info w-100 h-100 py-3">
                                <i class="material-icons-round mb-2">note_add</i><br>
                                Not Ekle
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/project" class="btn btn-outline-success w-100 h-100 py-3">
                                <i class="material-icons-round mb-2">task</i><br>
                                Proje Ekle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/partials/script.php'; ?>
    
    <script>
    // Enhanced Dashboard functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize animations
        initializeAnimations();
        
        // Initialize charts
        initializeDashboardCharts();
        
        // Initialize dashboard features
        initializeDashboardFeatures();
    });

    function initializeAnimations() {
        // Animate cards on load
        const cards = document.querySelectorAll('.animate-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in');
        });
    }

    function initializeDashboardCharts() {
        // Enhanced Category Expense Chart
        const ctx = document.getElementById('categoryExpenseChart');
        if (ctx) {
            const categoryData = <?= json_encode($category_expenses) ?>;
            
            const labels = categoryData.map(item => item.category_type);
            const data = categoryData.map(item => item.total_amount);
            const colors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
                '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
            ];

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Toplam Harcama',
                        data: data,
                        backgroundColor: colors,
                        borderColor: '#fff',
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${context.label}: ₺${value.toLocaleString('tr-TR')} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        }
    }

    function initializeDashboardFeatures() {
        // Refresh dashboard functionality
        window.refreshDashboard = function() {
            showInfo('Dashboard yenileniyor...');
            setTimeout(() => {
                location.reload();
            }, 1000);
        };

        // Add hover effects to cards
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add click effects to quick action cards
        const quickActionCards = document.querySelectorAll('.quick-action-card');
        quickActionCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('div');
                ripple.className = 'ripple-effect';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    }
    </script>

    <style>
    /* Enhanced Dashboard Styles */
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .modern-card {
        border: none;
        border-radius: 0px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.15);
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .stat-progress {
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
        margin: 1rem 0 0.5rem;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 2px;
        transition: width 0.6s ease;
    }

    .progress-bar.danger { background: #dc3545; }
    .progress-bar.warning { background: #ffc107; }
    .progress-bar.info { background: #17a2b8; }
    .progress-bar.success { background: #28a745; }

    .stat-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .quick-action-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        border: 2px solid transparent;
        border-radius: 12px;
        background: var(--bs-body-bg);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .quick-action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .quick-action-card.primary:hover { border-color: #007bff; }
    .quick-action-card.warning:hover { border-color: #ffc107; }
    .quick-action-card.success:hover { border-color: #28a745; }
    .quick-action-card.info:hover { border-color: #17a2b8; }

    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .feature-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1.5rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        background: var(--bs-body-bg);
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
    }

    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .feature-card.danger:hover { border-color: #dc3545; }
    .feature-card.warning:hover { border-color: #ffc107; }
    .feature-card.info:hover { border-color: #17a2b8; }
    .feature-card.success:hover { border-color: #28a745; }
    .feature-card.primary:hover { border-color: #007bff; }
    .feature-card.secondary:hover { border-color: #6c757d; }
    .feature-card.dark:hover { border-color: #343a40; }

    .feature-card i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .transaction-item {
        transition: all 0.3s ease;
    }

    .transaction-item:hover {
        background: rgba(0, 0, 0, 0.02);
        transform: translateX(5px);
    }

    .transaction-icon {
        transition: all 0.3s ease;
    }

    .transaction-item:hover .transaction-icon {
        transform: scale(1.1);
    }

    .ripple-effect {
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }

    /* Dark mode improvements */
    [data-bs-theme="dark"] .modern-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .quick-action-card,
    [data-bs-theme="dark"] .feature-card {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .transaction-item:hover {
        background: rgba(255, 255, 255, 0.05);
    }
    </style>

</body>
</html>