<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
$security = new SecurityManager();
$security->checkSession();
include 'partials/head.php';
$db = Database::getInstance();

// Seçili ayı al (varsayılan: Temmuz 2025)
$selected_month = $_SESSION['selected_month'] ?? '07.25';

// Banka borçlarını al
$rows = $db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name LIKE '%banka%' AND c.type = 'expense' ORDER BY ei.id DESC");
$csrf_token = generate_csrf_token();
?>
<body>
<div class="app-container">
    <?php include 'partials/sidebar.php'; ?>
    <div class="app-main">
        <?php include 'partials/header.php'; ?>
        <!-- Breadcrumb ve Başlık -->
        <div class="container-fluid py-1" style="background:#f7f9fb;">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;">Banka Borçları</h2>
                    <div style="color:#7b8ab8; font-size:1rem;">Banka kredileri ve borçları takibi.</div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background:transparent;">
                        <li class="breadcrumb-item"><a href="index.php" style="color:#7b8ab8; text-decoration:none;">Anasayfa</a></li>
                        <li class="breadcrumb-item"><a href="#" style="color:#7b8ab8; text-decoration:none;">Tüm Borçlar</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;">Banka</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <!-- Boş Durum Kontrolü -->
                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-bank"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz banka borcu kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Banka borçlarınızı ekleyerek takip etmeye başlayın.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#harcamaEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 500;">
                        <i class="bi bi-plus-circle me-2"></i>İlk Banka Borcu Ekle
                    </button>
                </div>
                <?php else: ?>
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Banka Borçları</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#harcamaEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i>Yeni Banka Borcu Ekle
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">Kategori</th>
                                        <th>Ürün/Hizmet</th>
                                        <th>Tutar</th>
                                        <th>Link</th>
                                        <th>Açıklama</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= htmlspecialchars($row['category_name']) ?> </td>
                                        <td> <?= htmlspecialchars($row['item_name']) ?> </td>
                                        <td> ₺<?= number_format($row['amount'], 0, ',', '.') ?> </td>
                                        <td>
                                            <?php if (!empty($row['link'])): ?>
                                                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td> <?= htmlspecialchars($row['description'] ?? '-') ?> </td>
                                        <td>
                                            <div class="position-relative" style="display:inline-block; width:120px;">
                                                <select class="form-select form-select-sm status-dropdown" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 2rem 0.3rem 0.5rem; min-width:100px; border:1px solid #e5e9f2; appearance:none;">
                                                    <option value="Beklemede" <?= $row['status_name'] == 'Beklemede' ? 'selected' : '' ?>>Beklemede</option>
                                                    <option value="Devam Ediyor" <?= $row['status_name'] == 'Devam Ediyor' ? 'selected' : '' ?>>Devam Ediyor</option>
                                                    <option value="Tamamlandı" <?= $row['status_name'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                                    <option value="İptal Edildi" <?= $row['status_name'] == 'İptal Edildi' ? 'selected' : '' ?>>İptal Edildi</option>
                                                </select>
                                                <i class="bi bi-caret-down-fill" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); pointer-events:none; color:#b0b8c9; font-size:1rem;"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Düzenle" type="button">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Sil" type="button">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Harcama Ekle Modal -->
                <div class="modal fade" id="harcamaEkleModal" tabindex="-1" aria-labelledby="harcamaEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="harcamaEkleModalLabel">Yeni Banka Borcu Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="harcamaEkleForm">
                                <div class="modal-body">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" value="Banka" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="item_name" class="form-label">Kredi Türü</label>
                                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Örn: Konut Kredisi, İhtiyaç Kredisi, Kredi Kartı" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Tutar (₺)</label>
                                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link (Opsiyonel)</label>
                                        <input type="url" class="form-control" id="link" name="link">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Açıklama (Opsiyonel)</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="status_name" class="form-label">Durum</label>
                                        <select class="form-select" id="status_name" name="status_name" required>
                                            <option value="Beklemede">Beklemede</option>
                                            <option value="Devam Ediyor">Devam Ediyor</option>
                                            <option value="Tamamlandı">Tamamlandı</option>
                                            <option value="İptal Edildi">İptal Edildi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-primary">Ekle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/script.php'; ?>

<script>
$(document).ready(function() {
    // Durum değişikliği
    $('.status-dropdown').change(function() {
        var id = $(this).data('id');
        var status = $(this).val();
        
        $.ajax({
            url: 'ajax/update_expense_status.php',
            type: 'POST',
            data: {
                id: id,
                status_name: status,
                csrf_token: '<?= $csrf_token ?>'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Durum güncellendi');
                } else {
                    toastr.error(response.message || 'Hata oluştu');
                }
            },
            error: function() {
                toastr.error('Bağlantı hatası');
            }
        });
    });
    
    // Yeni harcama ekleme
    $('#harcamaEkleForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'ajax/add_expense.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success('Banka borcu başarıyla eklendi');
                    $('#harcamaEkleModal').modal('hide');
                    location.reload();
                } else {
                    toastr.error(response.message || 'Hata oluştu');
                }
            },
            error: function() {
                toastr.error('Bağlantı hatası');
            }
        });
    });
});
</script>

</body> 