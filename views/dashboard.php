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
                                    <h1 class="h3 mb-0">Dashboard</h1>
                                    <p class="text-muted mb-0">Xtreme Bütçe Yönetim Paneline Hoş Geldiniz</p>
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

                    <!-- Hızlı İşlemler -->
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
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Floating Action Button -->
    <div class="fab-container">
        <button class="fab fab-main ripple" id="fabMain">
        <i class="material-icons-round">add</i>
    </button>

        <div class="fab-options" id="fabOptions">
            <button class="fab fab-option" data-action="import-favorites" title="Favori Ürünleri İçe Aktar">
                <i class="material-icons-round">favorite</i>
            </button>
            <button class="fab fab-option" data-action="add-from-link" title="Linkten Alınacak Ekle">
                <i class="material-icons-round">link</i>
            </button>
            <button class="fab fab-option" data-action="bulk-add" title="Toplu Alınacak Ekle">
                <i class="material-icons-round">list</i>
            </button>
            <button class="fab fab-option" data-action="import-notes" title="Toplu Not İçe Aktar">
                <i class="material-icons-round">note</i>
            </button>
        </div>
    </div>

    <!-- Import Favorites Modal -->
    <div class="modal fade" id="importFavoritesModal" tabindex="-1" aria-labelledby="importFavoritesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importFavoritesModalLabel">Favori Ürünleri İçe Aktar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="favoritesText" class="form-label">Favori ürünlerinizi aşağıya yapıştırın (her satır bir ürün):</label>
                        <textarea class="form-control" id="favoritesText" rows="10" placeholder="Örnek format:
iPhone 15 Pro - 45000 TL - https://example.com/iphone - https://example.com/iphone.jpg
MacBook Air - 35000 TL - https://example.com/macbook - https://example.com/macbook.jpg
Samsung TV - 12000 TL - https://example.com/tv - https://example.com/tv.jpg"></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="material-icons-round me-2">info</i>
                        <strong>Format:</strong> Ürün Adı - Fiyat - Link - Resim Linki (opsiyonel)
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-primary" id="importFavoritesBtn">İçe Aktar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add from Link Modal -->
    <div class="modal fade" id="addFromLinkModal" tabindex="-1" aria-labelledby="addFromLinkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFromLinkModalLabel">Linkten Alınacak Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="productLink" class="form-label">Ürün Linki:</label>
                        <input type="url" class="form-control" id="productLink" placeholder="https://example.com/urun">
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Ürün Adı:</label>
                        <input type="text" class="form-control" id="productName" placeholder="Ürün adını girin">
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Fiyat (₺):</label>
                        <input type="number" class="form-control" id="productPrice" step="0.01" placeholder="0.00">
                    </div>
                    <div class="mb-3">
                        <label for="productCategory" class="form-label">Kategori:</label>
                        <select class="form-select" id="productCategory">
                            <option value="Elektronik">Elektronik</option>
                            <option value="Giyim">Giyim</option>
                            <option value="Ev & Yaşam">Ev & Yaşam</option>
                            <option value="Spor">Spor</option>
                            <option value="Kitap">Kitap</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Resim Linki (Opsiyonel):</label>
                        <input type="url" class="form-control" id="productImage" placeholder="https://example.com/resim.jpg">
                    </div>
                    <div class="mb-3">
                        <label for="productNotes" class="form-label">Notlar (Opsiyonel):</label>
                        <textarea class="form-control" id="productNotes" rows="3" placeholder="Ek notlarınız..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-primary" id="addFromLinkBtn">Ekle</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Add Modal -->
    <div class="modal fade" id="bulkAddModal" tabindex="-1" aria-labelledby="bulkAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkAddModalLabel">Toplu Alınacak Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bulkItemsText" class="form-label">Alınacak ürünlerinizi aşağıya yapıştırın (her satır bir ürün):</label>
                        <textarea class="form-control" id="bulkItemsText" rows="10" placeholder="Örnek format:
Laptop - 25000 TL - Elektronik - https://example.com/laptop.jpg
Spor Ayakkabı - 800 TL - Spor - https://example.com/ayakkabi.jpg
Kitap Seti - 150 TL - Kitap - https://example.com/kitap.jpg"></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="material-icons-round me-2">info</i>
                        <strong>Format:</strong> Ürün Adı - Fiyat - Kategori - Resim Linki (opsiyonel)
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-primary" id="bulkAddBtn">Toplu Ekle</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Notes Modal -->
    <div class="modal fade" id="importNotesModal" tabindex="-1" aria-labelledby="importNotesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importNotesModalLabel">Toplu Not İçe Aktar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="notesText" class="form-label">Notlarınızı aşağıya yapıştırın:</label>
                        <textarea class="form-control" id="notesText" rows="10" placeholder="Notlarınızı buraya yazın..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notesCategory" class="form-label">Kategori:</label>
                        <select class="form-select" id="notesCategory">
                            <option value="Genel">Genel</option>
                            <option value="Alışveriş">Alışveriş</option>
                            <option value="Fikirler">Fikirler</option>
                            <option value="Hatırlatmalar">Hatırlatmalar</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="material-icons-round me-2">info</i>
                        <strong>Not:</strong> Her satır ayrı bir not olarak kaydedilecektir.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-primary" id="importNotesBtn">İçe Aktar</button>
                </div>
            </div>
        </div>
    </div>

    

    <?php require_once 'C:/xampp/htdocs/views/partials/script.php'; ?>
    
    <!-- Page-specific scripts after main scripts load -->
    <script>
        console.log('=== INDEX.PHP PAGE SCRIPT ===');
        console.log('jQuery available:', typeof $ !== 'undefined');
        console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
        console.log('Chart.js available:', typeof Chart !== 'undefined');
        console.log('Toastr available:', typeof toastr !== 'undefined');
    </script>

    <!-- Page-specific scripts -->
    <script>
        // Page-specific initialization
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎯 Index page specific scripts loaded');
            
            // Initialize any page-specific functionality here
            if (typeof EkashCore !== 'undefined') {
                console.log('✅ Ekash modules available on index page');
            }
        });
    </script>

</body>
</html>