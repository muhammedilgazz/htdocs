<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
$security = new SecurityManager();
$security->checkSession();
include 'partials/head.php';
$db = Database::getInstance();

// Notlar tablosunu oluştur (eğer yoksa)
$db->getPdo()->exec("
CREATE TABLE IF NOT EXISTS notlar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(50) NOT NULL DEFAULT 'Genel',
    icerik TEXT NOT NULL,
    onem_derecesi ENUM('Düşük', 'Orta', 'Yüksek') DEFAULT 'Orta',
    durum ENUM('Aktif', 'Tamamlandı', 'Arşivlendi') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

// Notları al
$rows = $db->fetchAll("SELECT * FROM notlar ORDER BY onem_derecesi DESC, created_at DESC");
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
                    <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;">Notlar</h2>
                    <div style="color:#7b8ab8; font-size:1rem;">Notlarınızı yönetin ve takip edin.</div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background:transparent;">
                        <li class="breadcrumb-item"><a href="index.php" style="color:#7b8ab8; text-decoration:none;">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;">Notlar</li>
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
                        <i class="bi bi-sticky"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz not kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Notlarınızı ekleyerek takip etmeye başlayın.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#notEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 500;">
                        <i class="bi bi-plus-circle me-2"></i>İlk Notu Ekle
                    </button>
                </div>
                <?php else: ?>
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Notlar</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#notEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i>Yeni Not Ekle
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">ID</th>
                                        <th>Kategori</th>
                                        <th>İçerik</th>
                                        <th>Önem</th>
                                        <th>Durum</th>
                                        <th>Tarih</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= $row['id'] ?> </td>
                                        <td>
                                            <span class="badge" style="background:#96ceb4; color:#fff; font-weight:600; font-size:0.6rem; padding:0.2rem 0.4rem;">
                                                <?= htmlspecialchars($row['kategori']) ?>
                                            </span>
                                        </td>
                                        <td> <?= htmlspecialchars($row['icerik']) ?> </td>
                                        <td>
                                            <?php
                                            $importance_color = '';
                                            switch($row['onem_derecesi']) {
                                                case 'Yüksek': $importance_color = 'danger'; break;
                                                case 'Orta': $importance_color = 'warning'; break;
                                                case 'Düşük': $importance_color = 'success'; break;
                                            }
                                            ?>
                                            <span class="badge badge-<?= $importance_color ?>" style="font-size:0.6rem; padding:0.2rem 0.4rem;">
                                                <?= $row['onem_derecesi'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="position-relative" style="display:inline-block; width:120px;">
                                                <select class="form-select form-select-sm status-dropdown" data-id="<?= $row['id'] ?>" data-table="notlar" style="font-size:0.8rem; padding:0.3rem 2rem 0.3rem 0.5rem; min-width:100px; border:1px solid #e5e9f2; appearance:none;">
                                                    <option value="Aktif" <?= $row['durum'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                                    <option value="Tamamlandı" <?= $row['durum'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                                    <option value="Arşivlendi" <?= $row['durum'] == 'Arşivlendi' ? 'selected' : '' ?>>Arşivlendi</option>
                                                </select>
                                                <i class="bi bi-caret-down-fill" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); pointer-events:none; color:#b0b8c9; font-size:1rem;"></i>
                                            </div>
                                        </td>
                                        <td> <?= date('d.m.Y H:i', strtotime($row['created_at'])) ?> </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Düzenle" type="button">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>" data-table="notlar" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Sil" type="button">
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
                
                <!-- Not Ekle Modal -->
                <div class="modal fade" id="notEkleModal" tabindex="-1" aria-labelledby="notEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="notEkleModalLabel">Yeni Not Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="notEkleForm">
                                <div class="modal-body">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-select" id="kategori" name="kategori" required>
                                            <option value="Genel">Genel</option>
                                            <option value="Alışveriş">Alışveriş</option>
                                            <option value="Fikirler">Fikirler</option>
                                            <option value="Hatırlatmalar">Hatırlatmalar</option>
                                            <option value="Diğer">Diğer</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="icerik" class="form-label">Not İçeriği</label>
                                        <textarea class="form-control" id="icerik" name="icerik" rows="4" placeholder="Notunuzu buraya yazın..." required></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="onem_derecesi" class="form-label">Önem Derecesi</label>
                                        <select class="form-select" id="onem_derecesi" name="onem_derecesi" required>
                                            <option value="Düşük">Düşük</option>
                                            <option value="Orta" selected>Orta</option>
                                            <option value="Yüksek">Yüksek</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="durum" class="form-label">Durum</label>
                                        <select class="form-select" id="durum" name="durum" required>
                                            <option value="Aktif" selected>Aktif</option>
                                            <option value="Tamamlandı">Tamamlandı</option>
                                            <option value="Arşivlendi">Arşivlendi</option>
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

<?php include 'partials/script.php'; ?>

<script>
$(document).ready(function() {
    // Not ekleme formu
    $('#notEkleForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: 'ajax/add_note.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showSuccess(response.message);
                    $('#notEkleModal').modal('hide');
                    location.reload();
                } else {
                    showError(response.message);
                }
            },
            error: function() {
                showError('Bir hata oluştu');
            }
        });
    });
});
</script>

</body> 
</html> 