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
                $page_title = 'İstek Listesi - Favoriler';
                $page_description = 'Favori kategorisindeki istek listesi öğelerinin takibi.';
                $breadcrumb_active = 'Favoriler';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWishlistItemModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni İstek Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-cart"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz bu kategoride istek listesi öğesi yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">İstek listesi öğelerinizi ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Favoriler Listesi</h5>
                            <div class="d-flex align-items-center">
                                <?php if (!empty($rows)): ?>
                                    <h5 class="mb-0 text-end me-3">Toplam: <?= count($rows) ?> öğe</h5>
                                <?php endif; ?>
                                <!-- Export button can be added here if needed -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="wishlistTable" class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Resim</th>
                                        <th>Öğe Adı</th>
                                        <th>Tip</th>
                                        <th>Link</th>
                                        <th>Fiyat</th>
                                        <th>Öncelik</th>
                                        <th>İlerleme (%)</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($row['image_url'])): ?>
                                                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Ürün Resmi" width="50">
                                            <?php else: ?>
                                                Resim Yok
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                                        <td><?= htmlspecialchars($row['wishlist_type']) ?></td>
                                        <td>
                                            <?php if (!empty($row['product_link'])): ?>
                                                <a href="<?= htmlspecialchars($row['product_link']) ?>" target="_blank">Ürün Sayfası</a>
                                            <?php else: ?>
                                                Link Yok
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['price']) ?></td>
                                        <td><?= htmlspecialchars($row['priority']) ?></td>
                                        <td><?= htmlspecialchars($row['progress']) ?></td>
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

<!-- Add Wishlist Item Modal -->
<div class="modal fade" id="addWishlistItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni İstek Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Öğe Adı</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="wishlist_type" class="form-label">Tip</label>
                        <select class="form-control" id="wishlist_type" name="wishlist_type" required>
                            <option value="ihtiyac">İhtiyaç</option>
                            <option value="hayal">Hayal</option>
                            <option value="favori">Favori</option>
                            <option value="istek">İstek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Resim URL</label>
                        <input type="url" class="form-control" id="image_url" name="image_url">
                    </div>
                    <div class="mb-3">
                        <label for="product_link" class="form-label">Ürün Linki</label>
                        <input type="url" class="form-control" id="product_link" name="product_link">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Fiyat</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Öncelik</label>
                        <input type="number" class="form-control" id="priority" name="priority" min="1" max="5">
                    </div>
                    <div class="mb-3">
                        <label for="progress" class="form-label">İlerleme (%)</label>
                        <input type="number" class="form-control" id="progress" name="progress" min="0" max="100">
                    </div>
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

<!-- Edit Wishlist Item Modal -->
<div class="modal fade" id="editWishlistItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">İstek Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_item_name" class="form-label">Öğe Adı</label>
                        <input type="text" class="form-control" id="edit_item_name" name="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_wishlist_type" class="form-label">Tip</label>
                        <select class="form-control" id="edit_wishlist_type" name="wishlist_type" required>
                            <option value="ihtiyac">İhtiyaç</option>
                            <option value="hayal">Hayal</option>
                            <option value="favori">Favori</option>
                            <option value="istek">İstek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image_url" class="form-label">Resim URL</label>
                        <input type="url" class="form-control" id="edit_image_url" name="image_url">
                    </div>
                    <div class="mb-3">
                        <label for="edit_product_link" class="form-label">Ürün Linki</label>
                        <input type="url" class="form-control" id="edit_product_link" name="product_link">
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Fiyat</label>
                        <input type="number" class="form-control" id="edit_price" name="price" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_priority" class="form-label">Öncelik</label>
                        <input type="number" class="form-control" id="edit_priority" name="priority" min="1" max="5">
                    </div>
                    <div class="mb-3">
                        <label for="edit_progress" class="form-label">İlerleme (%)</label>
                        <input type="number" class="form-control" id="edit_progress" name="progress" min="0" max="100">
                    </div>
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
    $('#wishlistTable').DataTable({
        language: {
            "sDecimal": ",", "sEmptyTable": "Tabloda herhangi bir veri mevcut değil", "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor", "sInfoEmpty": "Kayıt yok", "sInfoFiltered": "(_MAX_ kayıt içerisinden bulundu)", "sInfoPostFix": "", "sInfoThousands": ".", "sLengthMenu": "Sayfada _MENU_ kayıt göster", "sLoadingRecords": "Yükleniyor...", "sProcessing": "İşleniyor...","sSearch": "Ara:", "sZeroRecords": "Eşleşen kayıt bulunamadı", "oPaginate": { "sFirst": "İlk", "sLast": "Son", "sNext": "Sonraki", "sPrevious": "Önceki" }, "oAria": { "sSortAscending": ": artan sütun sıralamasını aktifleştir", "sSortDescending": ": azalan sütun sıralamasını aktifleştir" }
        },
        "order": [[ 5, "asc" ]], // Önceliğe göre sırala
        columnDefs: [ { orderable: false, targets: 7 } ] // İşlemler sıralanamaz
    });

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
                    $('#edit_wishlist_type').val(item.wishlist_type);
                    $('#edit_image_url').val(item.image_url);
                    $('#edit_product_link').val(item.product_link);
                    $('#edit_price').val(item.price);
                    $('#edit_priority').val(item.priority);
                    $('#edit_progress').val(item.progress);
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
        if (!confirm('Bu istek listesi öğesini silmek istediğinizden emin misiniz?')) return;
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