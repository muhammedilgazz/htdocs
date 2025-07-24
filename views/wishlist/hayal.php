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
                <div class="row">
                    <div class="col-12">
                        <div class="page-title mb-4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-xl-4">
                                    <div class="page-title-content">
                                        <h3>Hayaller</h3>
                                        <p class="mb-2">Hayallerinizi takip edin ve birikimlerinizi yönetin.</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="breadcrumbs"><a href="#">Anasayfa </a>
                                        <span><i class="bi bi-chevron-right"></i></span>
                                        <a href="#">Hayaller</a>
                                    </div>
                                </div>
                            </div>
                </div>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-xl-3 mb-4 mb-xl-0">
                        <div class="nav flex-column nav-pills" id="goals-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active goals-nav mb-2" id="goal1-tab" data-bs-toggle="pill" data-bs-target="#goal1" type="button" role="tab" aria-controls="goal1" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="goals-nav-circle me-3">
                                        <div class="progress-circle" style="--value: 40;"></div>
                                        <span>40%</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Araba</h6>
                                        <small class="text-muted">₺20.000 / ₺50.000</small>
                                    </div>
                                </div>
                            </button>
                            <button class="nav-link goals-nav mb-2" id="goal2-tab" data-bs-toggle="pill" data-bs-target="#goal2" type="button" role="tab" aria-controls="goal2" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="goals-nav-circle me-3">
                                        <div class="progress-circle" style="--value: 60;"></div>
                                        <span>60%</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Laptop</h6>
                                        <small class="text-muted">₺9.000 / ₺15.000</small>
                                    </div>
                                </div>
                            </button>
                            <button class="nav-link goals-nav mb-2" id="goal3-tab" data-bs-toggle="pill" data-bs-target="#goal3" type="button" role="tab" aria-controls="goal3" aria-selected="false">
                            <div class="d-flex align-items-center">
                                    <div class="goals-nav-circle me-3">
                                        <div class="progress-circle" style="--value: 25;"></div>
                                        <span>25%</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Tatil</h6>
                                        <small class="text-muted">₺2.500 / ₺10.000</small>
                                    </div>
                                </div>
                            </button>
                            <div class="add-goals-link mt-4">
                                <h6 class="mb-2">Yeni hayal ekle</h6>
                                <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addWishlistItemModal">
                                    <i class="bi bi-plus-circle me-2"></i>Hayal Ekle
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="tab-content" id="goals-tabContent">
                            <div class="tab-pane fade show active" id="goal1" role="tabpanel" aria-labelledby="goal1-tab">
                                <div class="goals-tab-title mb-3">
                                    <h4>Araba</h4>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <div class="card goals-widget text-center">
                                            <div class="card-body">
                                                <p class="mb-1">Geçen Ay</p>
                                                <h5 class="mb-0">₺4.000</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card goals-widget text-center">
                                            <div class="card-body">
                                                <p class="mb-1">Harcamalar</p>
                                                <h5 class="mb-0">₺1.200</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card goals-widget text-center">
                                            <div class="card-body">
                                                <p class="mb-1">Vergiler</p>
                                                <h5 class="mb-0">₺250</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card goals-widget text-center">
                                            <div class="card-body">
                                                <p class="mb-1">Borç</p>
                                                <h5 class="mb-0">₺5.000</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Cüzdanlara Göre Dağılım</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3">
                                                <span class="badge bg-warning"><i class="bi bi-bank"></i></span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <span>City Bank</span>
                                                    <span>₺8.000</span>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" style="width: 40%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3">
                                                <span class="badge bg-success"><i class="bi bi-wallet2"></i></span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <span>Nakit</span>
                                                    <span>₺5.000</span>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" style="width: 25%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <span class="badge bg-info"><i class="bi bi-credit-card"></i></span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <span>Kredi Kartı</span>
                                                    <span>₺7.000</span>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-info" style="width: 35%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Geçmiş Hareketler</h5>
                                    </div>
                                    <div class="card-body">
                        <div class="table-responsive">
                                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                                        <th>Tarih</th>
                                                        <th>Cüzdan</th>
                                                        <th>Açıklama</th>
                                                        <th>Tutar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                    <tr>
                                                        <td>01.07.2024</td>
                                                        <td>City Bank</td>
                                                        <td>Peşinat</td>
                                                        <td class="text-success">+₺2.000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>15.07.2024</td>
                                                        <td>Kredi Kartı</td>
                                                        <td>Ek ödeme</td>
                                                        <td class="text-success">+₺1.000</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20.07.2024</td>
                                                        <td>Nakit</td>
                                                        <td>Biriktirilen</td>
                                                        <td class="text-success">+₺500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                            </div>
                            <!-- Diğer hayal tabları için benzer içerik eklenebilir -->
                        </div>
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
            url: 'ajax.php?action=wishlist_add',
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
            url: 'ajax.php?action=wishlist_get',
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
            url: 'ajax.php?action=wishlist_update',
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
            url: 'ajax.php?action=wishlist_delete',
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