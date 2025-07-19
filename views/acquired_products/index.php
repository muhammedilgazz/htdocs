<?php require_once ROOT_PATH . '/views/partials/head.php'; ?>

<body>
<div class="app-container">
    <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
        <?php
        $page_title = 'Alınacak Ürünler';
        $page_description = 'Satın alınacak ürünler ve istek listesi.';
        $breadcrumb_active = 'Alınacak Ürünler';
        include ROOT_PATH . '/views/partials/page_header.php';
        ?>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <!-- Boş Durum Kontrolü -->
                <?php if (empty($rows)): ?>
                <?php 
                require_once ROOT_PATH . '/views/partials/empty_state.php';
                generate_empty_state(
                    'bi bi-cart-plus',
                    'Henüz ürün eklenmemiş',
                    'Alınacak ürünlerinizi ekleyerek takip etmeye başlayın.',
                    'İlk Ürünü Ekle',
                    '#harcamaEkleModal'
                );
                ?>
                <?php else: ?>
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Alınacak Ürünler</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#harcamaEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i>Yeni Ürün Ekle
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
                                        <td> <?= htmlspecialchars($row['description'] ?: '-') ?> </td>
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
                
                
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/views/partials/script.php'; ?>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ürünü Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_item_name" class="form-label">Ürün/Hizmet</label>
                        <input type="text" class="form-control" id="edit_item_name" name="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Tutar</label>
                        <input type="number" class="form-control" id="edit_price" name="price" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_link" class="form-label">Link</label>
                        <input type="url" class="form-control" id="edit_link" name="link">
                    </div>
                     <div class="mb-3">
                        <label for="edit_image_path" class="form-label">Resim Yolu</label>
                        <input type="text" class="form-control" id="edit_image_path" name="image_path">
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_will_get" name="will_get">
                        <label class="form-check-label" for="edit_will_get">Alındı</label>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?? '' ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Edit Button
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_wishlist_item.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?? '' ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const item = response.data;
                    $('#edit_id').val(item.id);
                    $('#edit_item_name').val(item.item_name);
                    $('#edit_price').val(item.price);
                    $('#edit_link').val(item.link);
                    $('#edit_image_path').val(item.image_path);
                    $('#edit_description').val(item.description);
                    $('#edit_will_get').prop('checked', item.will_get == 1);
                    $('#editProductModal').modal('show');
                } else {
                    alert(response.message || 'Veri getirilemedi.');
                }
            }
        });
    });

    // Edit Form Submission
    $('#editForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/update_wishlist_item.php', // Bu URL'nin doğru olduğundan emin olun
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Güncelleme sırasında bir hata oluştu.');
                }
            }
        });
    });

    // Delete Button
    $('.delete-btn').click(function() {
        if (!confirm('Bu ürünü silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_item.php', // Bu URL'nin doğru olduğundan emin olun
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?? '' ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Bir hata oluştu.');
                }
            }
        });
    });
});
</script>

</body>