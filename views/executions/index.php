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
                                <h2 class="mb-0">İcra Borçları</h2>
                                <div>İcra takipleri ve borç yönetimi.</div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExecutionDebtModal">
                                <i class="bi bi-plus-circle me-2"></i>Yeni İcra Borcu Ekle
                            </button>
                        </div>
                    </div>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz icra borcu kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">İcra takiplerinizi ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">İcra Borçları Listesi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Sahibi</th>
                                        <th>Alacaklı</th>
                                        <th>İcra Dairesi</th>
                                        <th>Başlangıç Tarihi</th>
                                        <th>Güncel Borç</th>
                                        <th>Anapara Borcu</th>
                                        <th>İletişim Bilgisi</th>
                                        <th>Durum</th>
                                        <th>Planlanan Ödeme</th>
                                        <th>Bu Ay Ödeme</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['owner']) ?></td>
                                        <td><?= htmlspecialchars($row['creditor']) ?></td>
                                        <td><?= htmlspecialchars($row['execution_office']) ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['start_date'])) ?></td>
                                        <td>₺<?= number_format($row['current_debt'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['principal_debt'], 2, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row['contact_info'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td>₺<?= number_format($row['planned_payment'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['this_month_payment'], 2, ',', '.') ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editExecutionDebtModal">
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

<!-- Add Execution Debt Modal -->
<div class="modal fade" id="addExecutionDebtModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni İcra Borcu Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="owner" class="form-label">Sahibi</label>
                        <input type="text" class="form-control" id="owner" name="owner" required>
                    </div>
                    <div class="mb-3">
                        <label for="creditor" class="form-label">Alacaklı</label>
                        <input type="text" class="form-control" id="creditor" name="creditor">
                    </div>
                    <div class="mb-3">
                        <label for="execution_office" class="form-label">İcra Dairesi</label>
                        <input type="text" class="form-control" id="execution_office" name="execution_office">
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="mb-3">
                        <label for="current_debt" class="form-label">Güncel Borç</label>
                        <input type="number" class="form-control" id="current_debt" name="current_debt" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="principal_debt" class="form-label">Anapara Borcu</label>
                        <input type="number" class="form-control" id="principal_debt" name="principal_debt" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="contact_info" class="form-label">İletişim Bilgisi</label>
                        <input type="text" class="form-control" id="contact_info" name="contact_info">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Durum</label>
                        <input type="text" class="form-control" id="status" name="status">
                    </div>
                    <div class="mb-3">
                        <label for="planned_payment" class="form-label">Planlanan Ödeme</label>
                        <input type="number" class="form-control" id="planned_payment" name="planned_payment" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="this_month_payment" class="form-label">Bu Ay Ödeme</label>
                        <input type="number" class="form-control" id="this_month_payment" name="this_month_payment" step="0.01">
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

<!-- Edit Execution Debt Modal -->
<div class="modal fade" id="editExecutionDebtModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">İcra Borcunu Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_owner" class="form-label">Sahibi</label>
                        <input type="text" class="form-control" id="edit_owner" name="owner" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_creditor" class="form-label">Alacaklı</label>
                        <input type="text" class="form-control" id="edit_creditor" name="creditor">
                    </div>
                    <div class="mb-3">
                        <label for="edit_execution_office" class="form-label">İcra Dairesi</label>
                        <input type="text" class="form-control" id="edit_execution_office" name="execution_office">
                    </div>
                    <div class="mb-3">
                        <label for="edit_start_date" class="form-label">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" id="edit_start_date" name="start_date">
                    </div>
                    <div class="mb-3">
                        <label for="edit_current_debt" class="form-label">Güncel Borç</label>
                        <input type="number" class="form-control" id="edit_current_debt" name="current_debt" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_principal_debt" class="form-label">Anapara Borcu</label>
                        <input type="number" class="form-control" id="edit_principal_debt" name="principal_debt" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_contact_info" class="form-label">İletişim Bilgisi</label>
                        <input type="text" class="form-control" id="edit_contact_info" name="contact_info">
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Durum</label>
                        <input type="text" class="form-control" id="edit_status" name="status">
                    </div>
                    <div class="mb-3">
                        <label for="edit_planned_payment" class="form-label">Planlanan Ödeme</label>
                        <input type="number" class="form-control" id="edit_planned_payment" name="planned_payment" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_this_month_payment" class="form-label">Bu Ay Ödeme</label>
                        <input type="number" class="form-control" id="edit_this_month_payment" name="this_month_payment" step="0.01">
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

<?php include 'C:/xampp/htdocs/views/partials/script.php'; ?>

<script>
$(document).ready(function() {
    // Add Form
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_execution_debt.php',
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
            url: 'ajax/get_execution_debt.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const debt = response.data;
                    $('#edit_id').val(debt.id);
                    $('#edit_owner').val(debt.owner);
                    $('#edit_creditor').val(debt.creditor);
                    $('#edit_execution_office').val(debt.execution_office);
                    $('#edit_start_date').val(debt.start_date);
                    $('#edit_current_debt').val(debt.current_debt);
                    $('#edit_principal_debt').val(debt.principal_debt);
                    $('#edit_contact_info').val(debt.contact_info);
                    $('#edit_status').val(debt.status);
                    $('#edit_planned_payment').val(debt.planned_payment);
                    $('#edit_this_month_payment').val(debt.this_month_payment);
                    $('#editExecutionDebtModal').modal('show');
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
            url: 'ajax/update_execution_debt.php',
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
        if (!confirm('Bu icra borcunu silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_execution_debt.php',
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
