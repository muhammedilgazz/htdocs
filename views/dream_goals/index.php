<?php
require_once ROOT_PATH . '/views/partials/head.php';
?>
<body>
<div class="app-container">
    <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
        <div class="app-content">
            <div class="container py-3">
                <?php
                $page_title = 'Hayaller ve Hedefler';
                $page_description = 'Hayallerinizi ve hedeflerinizi takip edin.';
                $breadcrumb_active = 'Hayaller ve Hedefler';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDreamGoalModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Hayal/Hedef Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz hayal/hedef kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Hayallerinizi ve hedeflerinizi ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Hayaller ve Hedefler Listesi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Hayal/Hedef</th>
                                        <th>Maliyet</th>
                                        <th>Link</th>
                                        <th>Öncelik</th>
                                        <th>İlerleme (%)</th>
                                        <th>Oluşturulma Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['goal_name']) ?></td>
                                        <td>₺<?= number_format($row['target_amount'], 2, ',', '.') ?></td>
                                        <td>
                                            <?php if (!empty($row['product_link'])): ?>
                                                <a href="<?= htmlspecialchars($row['product_link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['priority'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['progress'] ?? '0') ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editDreamGoalModal">
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

<!-- Add Dream Goal Modal -->
<div class="modal fade" id="addDreamGoalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Hayal/Hedef Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="goal_name" class="form-label">Hayal/Hedef Adı</label>
                        <input type="text" class="form-control" id="goal_name" name="goal_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="target_amount" class="form-label">Maliyet</label>
                        <input type="number" class="form-control" id="target_amount" name="target_amount" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="product_link" class="form-label">Link (Opsiyonel)</label>
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

<!-- Edit Dream Goal Modal -->
<div class="modal fade" id="editDreamGoalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hayal/Hedefi Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_goal_name" class="form-label">Hayal/Hedef Adı</label>
                        <input type="text" class="form-control" id="edit_goal_name" name="goal_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_target_amount" class="form-label">Maliyet</label>
                        <input type="number" class="form-control" id="edit_target_amount" name="target_amount" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_product_link" class="form-label">Link (Opsiyonel)</label>
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
            url: 'ajax/add_hayal_hedef.php',
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
            url: 'ajax/get_hayal_hedef.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const goal = response.data;
                    $('#edit_id').val(goal.id);
                    $('#edit_goal_name').val(goal.goal_name);
                    $('#edit_target_amount').val(goal.target_amount);
                    $('#edit_product_link').val(goal.product_link);
                    $('#edit_priority').val(goal.priority);
                    $('#edit_progress').val(goal.progress);
                    $('#editDreamGoalModal').modal('show');
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
            url: 'ajax/update_hayal_hedef.php',
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
        if (!confirm('Bu hayal/hedefi silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_hayal_hedef.php',
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
