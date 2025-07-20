<?php
require_once ROOT_PATH . '/views/partials/head.php';
?>
<body>
<div class="app-container">
    <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
        <div class="app-content">
            <div class="container-fluid">
                <?php
                $page_title = 'Favori Ürünler';
                $page_description = 'Favori ürünlerinizi takip edin.';
                $breadcrumb_active = 'Favori Ürünler';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWishlistItemModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Favori Ürün Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz favori ürün kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Favori ürünlerinizi ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Favori Ürünler Listesi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Ürün Adı</th>
                                        <th>Fiyat</th>
                                        <th>Link</th>
                                        <th>Resim</th>
                                        <th>Öncelik</th>
                                        <th>İlerleme (%)</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                                        <td>₺<?= number_format($row['price'], 2, ',', '.') ?></td>
                                        <td>
                                            <?php if (!empty($row['product_link'])): ?>
                                                <a href="<?= htmlspecialchars($row['product_link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['image_url'])): ?>
                                                <a href="<?= htmlspecialchars($row['image_url']) ?>" target="_blank" class="btn btn-outline-info btn-sm" title="Resmi Görüntüle">
                                                    <i class="bi bi-image"></i>
                                                </a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['priority'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['progress'] ?? '0') ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editWishlistItemModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>">
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

<!-- Add Wishlist Item Modal (Re-using from wishlist/index.php) -->
<div class="modal fade" id="addWishlistItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Favori Ürün Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Ürün Adı</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Fiyat</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="product_link" class="form-label">Ürün Linki</label>
                        <input type="url" class="form-control" id="product_link" name="product_link">
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Resim URL</label>
                        <input type="url" class="form-control" id="image_url" name="image_url">
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Öncelik</label>
                        <input type="number" class="form-control" id="priority" name="priority" min="1" max="10">
                    </div>
                    <div class="mb-3">
                        <label for="progress" class="form-label">İlerleme (%)</label>
                        <input type="number" class="form-control" id="progress" name="progress" min="0" max="100">
                    </div>
                    <input type="hidden" name="wishlist_type" value="favori">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Wishlist Item Modal (Re-using from wishlist/index.php) -->
<div class="modal fade" id="editWishlistItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Favori Ürünü Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_item_name" class="form-label">Ürün Adı</label>
                        <input type="text" class="form-control" id="edit_item_name" name="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Fiyat</label>
                        <input type="number" class="form-control" id="edit_price" name="price" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_product_link" class="form-label">Ürün Linki</label>
                        <input type="url" class="form-control" id="edit_product_link" name="product_link">
                    </div>
                    <div class="mb-3">
                        <label for="edit_image_url" class="form-label">Resim URL</label>
                        <input type="url" class="form-control" id="edit_image_url" name="image_url">
                    </div>
                    <div class="mb-3">
                        <label for="edit_priority" class="form-label">Öncelik</label>
                        <input type="number" class="form-control" id="edit_priority" name="priority" min="1" max="10">
                    </div>
                    <div class="mb-3">
                        <label for="edit_progress" class="form-label">İlerleme (%)</label>
                        <input type="number" class="form-control" id="edit_progress" name="progress" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Durum</label>
                        <select class="form-select" id="edit_status" name="status">
                            <option value="active">Aktif</option>
                            <option value="purchased">Satın Alındı</option>
                            <option value="removed">Kaldırıldı</option>
                        </select>
                    </div>
                    <input type="hidden" name="wishlist_type" value="favori">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/partials/script.php'; ?>

<script>
$(document).ready(function() {
    // Add Form
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_wishlist_item.php',
            type: 'POST',
            data: $(this).serialize(),
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

    // Edit Button
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_wishlist_item.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const item = response.data;
                    $('#edit_id').val(item.id);
                    $('#edit_item_name').val(item.item_name);
                    $('#edit_price').val(item.price);
                    $('#edit_product_link').val(item.product_link);
                    $('#edit_image_url').val(item.image_url);
                    $('#edit_priority').val(item.priority);
                    $('#edit_progress').val(item.progress);
                    $('#edit_status').val(item.status);
                    $('#editWishlistItemModal').modal('show');
                } else {
                    alert(response.message || 'Veri getirilemedi.');
                }
            }
        });
    });

    // Edit Form
    $('#editForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/update_wishlist_item.php',
            type: 'POST',
            data: $(this).serialize(),
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

    // Delete Button
    $('.delete-btn').click(function() {
        if (!confirm('Bu öğeyi silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_wishlist_item.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
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
</html>
