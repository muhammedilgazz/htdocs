<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
$security = new SecurityManager();
$security->checkSession();
include 'partials/head.php';
$db = Database::getInstance();

// Seçili ayı al (dinamik)
$selected_month = getSelectedMonthKey();

// AI isteklerini al
$rows = $db->fetchAll("SELECT * FROM harcama_kalemleri WHERE kategori_tipi='Alınacak Ürünler' AND kategori LIKE '%ai%' AND harcama_donemi = ? ORDER BY id DESC", [$selected_month]);
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
                    <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;">Xtreme AI</h2>
                    <div style="color:#7b8ab8; font-size:1rem;">Yapay zeka destekli özellikler ve araçlar.</div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background:transparent;">
                        <li class="breadcrumb-item"><a href="index.php" style="color:#7b8ab8; text-decoration:none;">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;">Xtreme AI</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <!-- AI Özellikleri Kartları -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:12px; border:none;">
                            <div class="card-body text-center p-4">
                                <div style="font-size:3rem; color:#667eea; margin-bottom:1rem;">
                                    <i class="bi bi-robot"></i>
                                </div>
                                <h5 style="color:#1f2e4e; font-weight:600; margin-bottom:1rem;">AI Asistan</h5>
                                <p style="color:#7b8ab8; font-size:0.9rem; margin-bottom:1.5rem;">Yapay zeka destekli kişisel asistanınız ile sohbet edin ve sorularınızı yanıtlayın.</p>
                                <button class="btn btn-primary" style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); border:none; border-radius:8px;">
                                    <i class="bi bi-chat-dots me-2"></i>Sohbet Başlat
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:12px; border:none;">
                            <div class="card-body text-center p-4">
                                <div style="font-size:3rem; color:#4ecdc4; margin-bottom:1rem;">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                                <h5 style="color:#1f2e4e; font-weight:600; margin-bottom:1rem;">Akıllı Analiz</h5>
                                <p style="color:#7b8ab8; font-size:0.9rem; margin-bottom:1.5rem;">Harcama verilerinizi AI ile analiz edin ve öneriler alın.</p>
                                <button class="btn btn-primary" style="background:linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%); border:none; border-radius:8px;">
                                    <i class="bi bi-bar-chart me-2"></i>Analiz Et
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:12px; border:none;">
                            <div class="card-body text-center p-4">
                                <div style="font-size:3rem; color:#ff6b6b; margin-bottom:1rem;">
                                    <i class="bi bi-lightbulb"></i>
                                </div>
                                <h5 style="color:#1f2e4e; font-weight:600; margin-bottom:1rem;">Akıllı Öneriler</h5>
                                <p style="color:#7b8ab8; font-size:0.9rem; margin-bottom:1.5rem;">AI destekli bütçe önerileri ve tasarruf ipuçları alın.</p>
                                <button class="btn btn-primary" style="background:linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); border:none; border-radius:8px;">
                                    <i class="bi bi-star me-2"></i>Öneriler Al
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI İstekleri Tablosu -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">AI İstekleri</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#harcamaEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i>Yeni AI İsteği
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($rows)): ?>
                        <div class="text-center py-4">
                            <div style="font-size: 3rem; color: #e3e8ef; margin-bottom: 1rem;">
                                <i class="bi bi-robot"></i>
                            </div>
                            <h6 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz AI isteği yok</h6>
                            <p style="color: #a0a8c0; font-size: 0.9rem;">AI ile ilgili isteklerinizi ekleyerek takip edin.</p>
                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">Sıra No</th>
                                        <th>Kategori</th>
                                        <th>Gider Türü</th>
                                        <th>AI İsteği</th>
                                        <th>Öncelik</th>
                                        <th>Link</th>
                                        <th>Açıklama</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= $row['sira'] ?> </td>
                                        <td> <?= htmlspecialchars($row['kategori']) ?> </td>
                                        <td>
                                            <span class="badge" style="background:#667eea; color:#fff; font-weight:600; font-size:0.6rem; padding:0.2rem 0.4rem;">
                                                AI
                                            </span>
                                        </td>
                                        <td> <?= htmlspecialchars($row['urun']) ?> </td>
                                        <td> 
                                            <span class="badge" style="background:<?= $row['tutar'] > 1000 ? '#dc3545' : ($row['tutar'] > 500 ? '#ffc107' : '#28a745'); ?>; color:#fff; font-weight:600; font-size:0.6rem; padding:0.2rem 0.4rem;">
                                                <?= $row['tutar'] > 1000 ? 'Yüksek' : ($row['tutar'] > 500 ? 'Orta' : 'Düşük'); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['link'])): ?>
                                                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td> <?= htmlspecialchars($row['aciklama'] ?? '-') ?> </td>
                                        <td>
                                            <div class="position-relative" style="display:inline-block; width:120px;">
                                                <select class="form-select form-select-sm status-dropdown" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 2rem 0.3rem 0.5rem; min-width:100px; border:1px solid #e5e9f2; appearance:none;">
                                                    <option value="Beklemede" <?= $row['durum'] == 'Beklemede' ? 'selected' : '' ?>>Beklemede</option>
                                                    <option value="Devam Ediyor" <?= $row['durum'] == 'Devam Ediyor' ? 'selected' : '' ?>>Devam Ediyor</option>
                                                    <option value="Tamamlandı" <?= $row['durum'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                                    <option value="İptal Edildi" <?= $row['durum'] == 'İptal Edildi' ? 'selected' : '' ?>>İptal Edildi</option>
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
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Harcama Ekle Modal -->
                <div class="modal fade" id="harcamaEkleModal" tabindex="-1" aria-labelledby="harcamaEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="harcamaEkleModalLabel">Yeni AI İsteği Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="harcamaEkleForm">
                                <div class="modal-body">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="kategori_tipi" value="Alınacak Ürünler">
                                    
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="kategori" name="kategori" value="AI İsteği" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="harcama_donemi" class="form-label">Harcama Dönemi</label>
                                        <select class="form-select" id="harcama_donemi" name="harcama_donemi" required>
                                            <?= generateMonthOptions($selected_month) ?>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="urun" class="form-label">AI İsteği</label>
                                        <input type="text" class="form-control" id="urun" name="urun" placeholder="AI ile ilgili isteğinizi girin" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tutar" class="form-label">Öncelik Seviyesi</label>
                                        <select class="form-select" id="tutar" name="tutar" required>
                                            <option value="100">Düşük Öncelik</option>
                                            <option value="500">Orta Öncelik</option>
                                            <option value="1000">Yüksek Öncelik</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Referans Linki (Opsiyonel)</label>
                                        <input type="url" class="form-control" id="link" name="link">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="aciklama" class="form-label">Açıklama (Opsiyonel)</label>
                                        <textarea class="form-control" id="aciklama" name="aciklama" rows="3"></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="durum" class="form-label">Durum</label>
                                        <select class="form-select" id="durum" name="durum" required>
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

<?php include 'partials/script.php'; ?>

<script>
$(document).ready(function() {
    // Durum değişikliği
    $('.status-dropdown').change(function() {
        var id = $(this).data('id');
        var status = $(this).val();
        
        $.ajax({
            url: 'ajax/update_payment.php',
            type: 'POST',
            data: {
                id: id,
                durum: status,
                csrf_token: '<?= $csrf_token ?>'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Durum güncellendi');
                } else {
                    toastr.error('Hata oluştu');
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
                    toastr.success('AI isteği başarıyla eklendi');
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