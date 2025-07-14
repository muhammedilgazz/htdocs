<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
require_once 'includes/auth_check.php';
require_once 'classes/UIHelper.php';
require_once 'classes/Expense.php';

// Güvenlik kontrolü
$security = new SecurityManager();
$security->checkSession();

// Veritabanı bağlantısı
$db = Database::getInstance();

// Kullanıcı bilgileri
$user_id = $_SESSION['user_id'] ?? null;
$user = null;
if ($user_id) {
    $stmt = $db->getPdo()->prepare("SELECT name, middle_name, surname, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $full_name = trim($user['name'] . ' ' . ($user['middle_name'] ?? '') . ' ' . $user['surname']);
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email'] = $user['email'];
    }
}

// Dashboard verileri
$stats = $db->fetch("
    SELECT 
        (SELECT SUM(e.amount) FROM expense_items e JOIN status_types s ON e.status_id = s.id WHERE s.name = 'Tamamlandı') as toplam_harcama,
        (SELECT SUM(e.amount) FROM expense_items e JOIN status_types s ON e.status_id = s.id WHERE s.name = 'Beklemede') as bekleyen_harcama,
        (SELECT SUM(p.amount) FROM payments p JOIN status_types s ON p.status_id = s.id WHERE s.name = 'Tamamlandı') as toplam_odeme,
        (SELECT SUM(p.amount) FROM payments p JOIN status_types s ON p.status_id = s.id WHERE s.name = 'Beklemede') as bekleyen_odeme,
        (SELECT total_balance FROM balances ORDER BY id DESC LIMIT 1) as mevcut_bakiye
");

// Son işlemler
$recent_transactions = $db->fetchAll("
    SELECT 'harcama' as tip, c.name as kategori, e.item_name as aciklama, e.amount as tutar, s.name as durum, e.created_at 
    FROM expense_items e 
    JOIN categories c ON e.category_id = c.id 
    JOIN status_types s ON e.status_id = s.id 
    ORDER BY e.created_at DESC LIMIT 5
");

$recent_payments = $db->fetchAll("
    SELECT 'odeme' as tip, p.person_name as aciklama, p.amount as tutar, s.name as durum, p.created_at 
    FROM payments p 
    JOIN status_types s ON p.status_id = s.id 
    ORDER BY p.created_at DESC LIMIT 5
");

$all_transactions = array_merge($recent_transactions, $recent_payments);
usort($all_transactions, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

$all_transactions = array_slice($all_transactions, 0, 10);

// Kategori bazlı harcama analizi
$category_expenses = $db->fetchAll("
    SELECT c.name as kategori, SUM(e.amount) as toplam_tutar, COUNT(*) as islem_sayisi
    FROM expense_items e 
    JOIN categories c ON e.category_id = c.id 
    JOIN status_types s ON e.status_id = s.id 
    WHERE s.name = 'Tamamlandı'
    GROUP BY c.name 
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

                    <!-- Hızlı İşlemler -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card fade-in">
                                <div class="card-header">
                                    <h5 class="card-title">Hızlı İşlemler</h5>
                                </div>
                                <div class="card-body">
                                    <div class="quick-actions-grid">
                                        <a href="budgets.php" class="quick-action-card">
                                            <div class="quick-action-icon primary">
                                                <i class="material-icons-round">pie_chart</i>
                                            </div>
                                            <h6>Bütçeler</h6>
                                            <p>Aylık bütçe planlaması</p>
                                        </a>
                                        <a href="analytics.php" class="quick-action-card">
                                            <div class="quick-action-icon success">
                                                <i class="material-icons-round">analytics</i>
                                            </div>
                                            <h6>Analizler</h6>
                                            <p>Finansal analiz</p>
                                        </a>
                                        <a href="goals.php" class="quick-action-card">
                                            <div class="quick-action-icon warning">
                                                <i class="material-icons-round">flag</i>
                                            </div>
                                            <h6>Hedefler</h6>
                                            <p>Tasarruf hedefleri</p>
                                        </a>
                                        <a href="wallets.php" class="quick-action-card">
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

    

    <?php include 'layouts/layoutBottom.php'; ?>
    
    <!-- Page-specific scripts after main scripts load -->
    <script>
        console.log('=== INDEX.PHP PAGE SCRIPT ===');
        console.log('jQuery available:', typeof $ !== 'undefined');
        console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
        console.log('Chart.js available:', typeof Chart !== 'undefined');
        console.log('Toastr available:', typeof toastr !== 'undefined');
    </script>

    <!-- Enhanced FAB JavaScript -->
    <script>
        $(document).ready(function() {
            // FAB Toggle
            $('#fabMain').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('.fab-container').toggleClass('active');
            });

            // Close FAB when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('.fab-container').length) {
                    $('.fab-container').removeClass('active');
                }
            });

            // FAB Option Click Handlers
            $('.fab-option').click(function() {
                const action = $(this).data('action');
                $('.fab-container').removeClass('active');
                
                switch(action) {
                    case 'import-favorites':
                        $('#importFavoritesModal').modal('show');
                        break;
                    case 'add-from-link':
                        $('#addFromLinkModal').modal('show');
                        break;
                    case 'bulk-add':
                        $('#bulkAddModal').modal('show');
                        break;
                    case 'import-notes':
                        $('#importNotesModal').modal('show');
                        break;
                }
            });

            // Import Favorites
            $('#importFavoritesBtn').click(function() {
                const favoritesText = $('#favoritesText').val().trim();
                if (!favoritesText) {
                    showError('Lütfen favori ürünlerinizi girin');
                    return;
                }

                $(this).prop('disabled', true).html('<span class="loading"></span> İçe Aktarılıyor...');

                $.ajax({
                    url: 'ajax/import_favorites.php',
                    type: 'POST',
                    data: {
                        favorites_text: favoritesText,
                        csrf_token: '<?= generate_csrf_token() ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            $('#importFavoritesModal').modal('hide');
                            $('#favoritesText').val('');
                            
                            // Sayfayı yenile
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function() {
                        showError('Bir hata oluştu');
                    },
                    complete: function() {
                        $('#importFavoritesBtn').prop('disabled', false).text('İçe Aktar');
                    }
                });
            });

            // Add from Link
            $('#addFromLinkBtn').click(function() {
                const productName = $('#productName').val().trim();
                const productPrice = $('#productPrice').val().trim();
                const productLink = $('#productLink').val().trim();
                const productCategory = $('#productCategory').val();
                const productImage = $('#productImage').val().trim();
                const productNotes = $('#productNotes').val().trim();

                if (!productName || !productPrice) {
                    showError('Ürün adı ve fiyat gereklidir');
                    return;
                }

                $(this).prop('disabled', true).html('<span class="loading"></span> Ekleniyor...');

                $.ajax({
                    url: 'ajax/add_from_link.php',
                    type: 'POST',
                    data: {
                        product_name: productName,
                        product_price: productPrice,
                        product_link: productLink,
                        product_category: productCategory,
                        product_image: productImage,
                        product_notes: productNotes,
                        csrf_token: '<?= generate_csrf_token() ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            $('#addFromLinkModal').modal('hide');
                            
                            // Formu temizle
                            $('#productName, #productPrice, #productLink, #productImage, #productNotes').val('');
                            $('#productCategory').val('Elektronik');
                            
                            // Sayfayı yenile
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function() {
                        showError('Bir hata oluştu');
                    },
                    complete: function() {
                        $('#addFromLinkBtn').prop('disabled', false).text('Ekle');
                    }
                });
            });

            // Bulk Add
            $('#bulkAddBtn').click(function() {
                const bulkItemsText = $('#bulkItemsText').val().trim();
                if (!bulkItemsText) {
                    showError('Lütfen ürün listesini girin');
                    return;
                }

                $(this).prop('disabled', true).html('<span class="loading"></span> Ekleniyor...');

                $.ajax({
                    url: 'ajax/bulk_add_products.php',
                    type: 'POST',
                    data: {
                        bulk_items_text: bulkItemsText,
                        csrf_token: '<?= generate_csrf_token() ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            $('#bulkAddModal').modal('hide');
                            $('#bulkItemsText').val('');
                            
                            // Sayfayı yenile
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function() {
                        showError('Bir hata oluştu');
                    },
                    complete: function() {
                        $('#bulkAddBtn').prop('disabled', false).text('Toplu Ekle');
                    }
                });
            });

            // Import Notes
            $('#importNotesBtn').click(function() {
                const notesText = $('#notesText').val().trim();
                if (!notesText) {
                    showError('Lütfen notlarınızı girin');
                    return;
                }

                $(this).prop('disabled', true).html('<span class="loading"></span> İçe Aktarılıyor...');

                $.ajax({
                    url: 'ajax/import_notes.php',
                    type: 'POST',
                    data: {
                        notes_text: notesText,
                        notes_category: $('#notesCategory').val(),
                        csrf_token: '<?= generate_csrf_token() ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showSuccess(response.message);
                            $('#importNotesModal').modal('hide');
                            $('#notesText').val('');
                            
                            // Sayfayı yenile
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showError(response.message);
                        }
                    },
                    error: function() {
                        showError('Bir hata oluştu');
                    },
                    complete: function() {
                        $('#importNotesBtn').prop('disabled', false).text('İçe Aktar');
                    }
                });
            });

            // Modal kapandığında formları temizle
            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('input, textarea').val('');
                $(this).find('select').prop('selectedIndex', 0);
                $(this).find('button[type="submit"]').prop('disabled', false).text(function() {
                    return $(this).data('original-text') || $(this).text();
                });
            });

            // Button original text'lerini kaydet
            $('#importFavoritesBtn, #addFromLinkBtn, #bulkAddBtn, #importNotesBtn').each(function() {
                $(this).data('original-text', $(this).text());
            });
        });
    </script>

</body>
</html> 