<?php
require_once 'C:/xampp/htdocs/views/partials/head.php';
?>
<body>
<div class="app-container">
    <?php require_once 'C:/xampp/htdocs/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once 'C:/xampp/htdocs/views/partials/header.php'; ?>
        <!-- Breadcrumb ve Başlık -->
        <div class="container-fluid py-1" style="background:#f7f9fb;">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;">Favori Ürünler</h2>
                    <div style="color:#7b8ab8; font-size:1rem;">Favori ürünlerinizi takip edin.</div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background:transparent;">
                        <li class="breadcrumb-item"><a href="/" style="color:#7b8ab8; text-decoration:none;">Anasayfa</a></li>
                        <li class="breadcrumb-item"><a href="#" style="color:#7b8ab8; text-decoration:none;">Tüm Alınacaklar</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;">Favori Ürünler</li>
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
                        <i class="bi bi-heart"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz favori ürün kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Favori ürünlerinizi ekleyerek takip etmeye başlayın.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#harcamaEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 500;">
                        <i class="bi bi-plus-circle me-2"></i>İlk Favori Ekle
                    </button>
                </div>
                <?php else: ?>
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Favori Ürünler</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#harcamaEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i>Yeni Favori Ekle
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">Kategori</th>
                                        <th>Ürün Adı</th>
                                        <th>Fiyat</th>
                                        <th>Link</th>
                                        <th>Resim</th>
                                        <th>Açıklama</th>
                                        <th>Alındı mı?</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= htmlspecialchars($row['category_name']) ?> </td>
                                        <td> <?= htmlspecialchars($row['item_name']) ?> </td>
                                        <td> ₺<?= number_format($row['price'], 0, ',', '.') ?> </td>
                                        <td>
                                            <?php if (!empty($row['link'])): ?>
                                                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['image_path'])): ?>
                                                <a href="<?= htmlspecialchars($row['image_path']) ?>" target="_blank" class="btn btn-outline-info btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;" title="Resmi Görüntüle">
                                                    <i class="bi bi-image"></i>
                                                </a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td> <?= htmlspecialchars($row['description'] ?? '-') ?> </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input will-get-switch" type="checkbox" role="switch" id="willGetSwitch_<?= $row['id'] ?>" data-id="<?= $row['id'] ?>" <?= $row['will_get'] ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="willGetSwitch_<?= $row['id'] ?>"></label>
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
                                <h5 class="modal-title" id="harcamaEkleModalLabel">Yeni Favori Ürün Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="harcamaEkleForm">
                                <div class="modal-body">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" value="Favori" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="item_name" class="form-label">Ürün Adı</label>
                                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Ürün adını girin" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Fiyat (₺)</label>
                                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Ürün Linki (Opsiyonel)</label>
                                        <input type="url" class="form-control" id="link" name="link">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="image_path" class="form-label">Resim Linki (Opsiyonel)</label>
                                        <input type="url" class="form-control" id="image_path" name="image_path">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Açıklama (Opsiyonel)</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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

<?php require_once 'C:/xampp/htdocs/views/partials/script.php'; ?>

<script>
$(document).ready(function() {
    // Durum değişikliği
    $('.status-dropdown').change(function() {
        var id = $(this).data('id');
        var status = $(this).val();
        
        $.ajax({
            url: 'ajax/update_wishlist_status.php',
            type: 'POST',
            data: {
                id: id,
                status: status,
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
            url: 'ajax/add_wishlist_item.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success('Favori ürün başarıyla eklendi');
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