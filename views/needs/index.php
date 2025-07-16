<?php
require_once __DIR__ . '/../../helpers/functions.php';
$csrf_token = generate_csrf_token();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İhtiyaçlar - Bütçe Yönetimi</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/custom-colors.css" rel="stylesheet">
    <link href="/assets/css/ekash-minimal.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/header.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><i class="fas fa-shopping-basket me-2"></i>İhtiyaçlar</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus me-1"></i>Yeni İhtiyaç Ekle
                        </button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-bg-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-list-ul fa-2x"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="card-title h5 mb-0">Toplam İhtiyaç</div>
                                        <div class="card-text"><?= count($rows) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="card-title h5 mb-0">Tamamlanan</div>
                                        <div class="card-text">
                                            <?= count(array_filter($rows, function($item) { 
                                                return isset($item['status']) ? $item['status'] === 'purchased' : false; 
                                            })) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="card-title h5 mb-0">Bekleyen</div>
                                        <div class="card-text">
                                            <?= count(array_filter($rows, function($item) { 
                                                return isset($item['status']) ? $item['status'] === 'active' : false; 
                                            })) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-lira-sign fa-2x"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="card-title h5 mb-0">Toplam Tutar</div>
                                        <div class="card-text">
                                            <?= number_format(array_sum(array_column($rows, 'price')), 2) ?> ₺
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İhtiyaçlar Tablosu -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">İhtiyaç Listesi</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($rows)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-basket fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Henüz hiç ihtiyaç eklenmemiş</h5>
                            <p class="text-muted">İlk ihtiyacınızı eklemek için "Yeni İhtiyaç Ekle" butonuna tıklayın.</p>
                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Ürün</th>
                                        <th>Fiyat</th>
                                        <th>Link</th>
                                        <th>Öncelik</th>
                                        <th>İlerleme (%)</th>
                                        <th>Durum</th>
                                        <th>Tarih</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($row['item_name']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?= number_format($row['price'], 2) ?> ₺
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['product_link'])): ?>
                                                <a href="<?= htmlspecialchars($row['product_link']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-external-link-alt"></i> Link
                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['priority'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['progress'] ?? '0') ?></td>
                                        <td>
                                            <?php 
                                            $status = $row['status'] ?? 'active';
                                            $status_class = match($status) {
                                                'purchased' => 'success',
                                                'removed' => 'danger',
                                                default => 'secondary'
                                            };
                                            ?>
                                            <span class="badge bg-<?= $status_class ?>"><?= htmlspecialchars($status) ?></span>
                                        </td>
                                        <td><?= date('d.m.Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary edit-btn" data-id="<?= $row['id'] ?>" title="Düzenle">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger delete-btn" data-id="<?= $row['id'] ?>" title="Sil">
                                                    <i class="fas fa-trash"></i>
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
            </main>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni İhtiyaç Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Ürün Adı</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Fiyat (₺)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="product_link" class="form-label">Link</label>
                            <input type="url" class="form-control" id="product_link" name="product_link">
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Öncelik</label>
                            <input type="number" class="form-control" id="priority" name="priority" min="1" max="10">
                        </div>
                        <div class="mb-3">
                            <label for="progress" class="form-label">İlerleme (%)</label>
                            <input type="number" class="form-control" id="progress" name="progress" min="0" max="100">
                        </div>
                        <input type="hidden" name="wishlist_type" value="ihtiyac">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">İhtiyaç Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_item_name" class="form-label">Ürün Adı</label>
                            <input type="text" class="form-control" id="edit_item_name" name="item_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Fiyat (₺)</label>
                            <input type="number" class="form-control" id="edit_price" name="price" step="0.01" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="edit_product_link" class="form-label">Link</label>
                            <input type="url" class="form-control" id="edit_product_link" name="product_link">
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
                            <select class="form-control" id="edit_status" name="status">
                                <option value="active">Aktif</option>
                                <option value="purchased">Satın Alındı</option>
                                <option value="removed">Kaldırıldı</option>
                            </select>
                        </div>
                        <input type="hidden" id="edit_id" name="id">
                        <input type="hidden" name="wishlist_type" value="ihtiyac">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Add form submission
        $('#addForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '/ajax/add_wishlist_item.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('İhtiyaç başarıyla eklendi!');
                        location.reload();
                    } else {
                        alert('Hata: ' + response.message);
                    }
                },
                error: function() {
                    alert('Bir hata oluştu!');
                }
            });
        });

        // Edit button click
        $('.edit-btn').click(function() {
            const id = $(this).data('id');
            
            $.ajax({
                url: '/ajax/get_wishlist_item.php',
                method: 'POST',
                data: { id: id, csrf_token: '<?= $csrf_token ?>' },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data) {
                        const data = response.data;
                        $('#edit_id').val(data.id);
                        $('#edit_item_name').val(data.item_name);
                        $('#edit_price').val(data.price);
                        $('#edit_product_link').val(data.product_link);
                        $('#edit_priority').val(data.priority);
                        $('#edit_progress').val(data.progress);
                        $('#edit_status').val(data.status);
                        $('#editModal').modal('show');
                    } else {
                        alert('Veri yüklenirken hata oluştu!');
                    }
                },
                error: function() {
                    alert('Veri yüklenirken hata oluştu!');
                }
            });
        });

        // Edit form submission
        $('#editForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '/ajax/update_wishlist_item.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('İhtiyaç başarıyla güncellendi!');
                        location.reload();
                    } else {
                        alert('Hata: ' + response.message);
                    }
                },
                error: function() {
                    alert('Bir hata oluştu!');
                }
            });
        });

        // Delete button click
        $('.delete-btn').click(function() {
            if (!confirm('Bu ihtiyacı silmek istediğinizden emin misiniz?')) {
                return;
            }
            
            const id = $(this).data('id');
            
            $.ajax({
                url: '/ajax/delete_wishlist_item.php',
                method: 'POST',
                data: { id: id, csrf_token: '<?= $csrf_token ?>' },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('İhtiyaç başarıyla silindi!');
                        location.reload();
                    } else {
                        alert('Hata: ' + response.message);
                    }
                },
                error: function() {
                    alert('Bir hata oluştu!');
                }
            });
        });
    });
    </script>
</body>
</html>