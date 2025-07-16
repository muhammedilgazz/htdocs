<?php
require_once 'C:/xampp/htdocs/views/partials/head.php';
?>
<body>
<div class="app-container">
    <?php require_once 'C:/xampp/htdocs/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once 'C:/xampp/htdocs/views/partials/header.php'; ?>
        <div class="app-content">
            <div class="container py-3">
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <h2 class="mb-0">Ertelenen Giderler</h2>
                                <div>Gelecek tarihlere ertelenmiş giderler.</div>
                            </div>
                        </div>
                        <div>
                            <!-- Ertelenen giderler doğrudan eklenmez, mevcut giderler ertelenir. -->
                            <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                <i class="bi bi-plus-circle me-2"></i>Yeni Ertelenen Gider Ekle
                            </button> -->
                        </div>
                    </div>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz ertelenmiş gider kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Ertelenmiş giderlerinizi buradan takip edebilirsiniz.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Ertelenen Giderler Listesi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Açıklama</th>
                                        <th>Tutar</th>
                                        <th>Tarih</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['description']) ?></td>
                                        <td>₺<?= number_format($row['amount'], 2, ',', '.') ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['date'])) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editExpenseModal">
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

<!-- Edit Expense Modal (Aynı modal kullanılabilir) -->
<div class="modal fade" id="editExpenseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ertelenen Gideri Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Açıklama</label>
                        <input type="text" class="form-control" id="edit_description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Tutar</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_date" class="form-label">Tarih</label>
                        <input type="date" class="form-control" id="edit_date" name="date">
                    </div>
                    <input type="hidden" name="category_type" value="ertelenmis">
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

<?php include 'C:/xampp/htdocs/views/partials/script.php'; ?>

<script>
$(document).ready(function() {
    // Edit Button
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_expense.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const expense = response.data;
                    $('#edit_id').val(expense.id);
                    $('#edit_description').val(expense.description);
                    $('#edit_amount').val(expense.amount);
                    $('#edit_date').val(expense.date);
                    $('#editExpenseModal').modal('show');
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
            url: 'ajax/update_expense.php',
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
        if (!confirm('Bu gideri silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_expense.php',
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
