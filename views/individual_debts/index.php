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
                $page_title = 'Şahıslara Borçlar';
                $page_description = 'Şahıslara olan borçlarınızı buradan yönetebilirsiniz.';
                $breadcrumb_active = 'Şahıslara Borçlar';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPersonalDebtModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Borç Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz şahıs borcu kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Şahıslara olan borçlarınızı ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Şahıs Borçları Listesi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="individualDebtsTable" class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Kime</th>
                                        <th>Tutar</th>
                                        <th>Vade Tarihi</th>
                                        <th>Ödenen</th>
                                        <th>Kalan</th>
                                        <th>Planlanan Ödeme Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['to_whom']) ?></td>
                                        <td>₺<?= number_format($row['amount'], 2, ',', '.') ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['due_date'])) ?></td>
                                        <td>₺<?= number_format($row['paid'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['remaining'], 2, ',', '.') ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['planned_payment_date'])) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editPersonalDebtModal">
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

<!-- Add Personal Debt Modal -->
<div class="modal fade" id="addPersonalDebtModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Şahıs Borcu Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="to_whom" class="form-label">Kime</label>
                        <input type="text" class="form-control" id="to_whom" name="to_whom" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Tutar</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Vade Tarihi</label>
                        <input type="date" class="form-control" id="due_date" name="due_date">
                    </div>
                    <div class="mb-3">
                        <label for="paid" class="form-label">Ödenen</label>
                        <input type="number" class="form-control" id="paid" name="paid" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="remaining" class="form-label">Kalan</label>
                        <input type="number" class="form-control" id="remaining" name="remaining" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="planned_payment_date" class="form-label">Planlanan Ödeme Tarihi</label>
                        <input type="date" class="form-control" id="planned_payment_date" name="planned_payment_date">
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

<!-- Edit Personal Debt Modal -->
<div class="modal fade" id="editPersonalDebtModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Şahıs Borcunu Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_to_whom" class="form-label">Kime</label>
                        <input type="text" class="form-control" id="edit_to_whom" name="to_whom" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Tutar</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_due_date" class="form-label">Vade Tarihi</label>
                        <input type="date" class="form-control" id="edit_due_date" name="due_date">
                    </div>
                    <div class="mb-3">
                        <label for="edit_paid" class="form-label">Ödenen</label>
                        <input type="number" class="form-control" id="edit_paid" name="paid" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_remaining" class="form-label">Kalan</label>
                        <input type="number" class="form-control" id="edit_remaining" name="remaining" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_planned_payment_date" class="form-label">Planlanan Ödeme Tarihi</label>
                        <input type="date" class="form-control" id="edit_planned_payment_date" name="planned_payment_date">
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
    $('#individualDebtsTable').DataTable({
        language: {
            "sDecimal": ",", "sEmptyTable": "Tabloda herhangi bir veri mevcut değil", "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor", "sInfoEmpty": "Kayıt yok", "sInfoFiltered": "(_MAX_ kayıt içerisinden bulundu)", "sInfoPostFix": "", "sInfoThousands": ".", "sLengthMenu": "Sayfada _MENU_ kayıt göster", "sLoadingRecords": "Yükleniyor...", "sProcessing": "İşleniyor...", "sSearch": "Ara:", "sZeroRecords": "Eşleşen kayıt bulunamadı", "oPaginate": { "sFirst": "İlk", "sLast": "Son", "sNext": "Sonraki", "sPrevious": "Önceki" }, "oAria": { "sSortAscending": ": artan sütun sıralamasını aktifleştir", "sSortDescending": ": azalan sütun sıralamasını aktifleştir" }
        },
        "order": [[ 2, "asc" ]], // Vade Tarihine göre sırala
        columnDefs: [ { orderable: false, targets: 6 } ]
    });

    // Add Form
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_personal_debt.php',
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
            url: 'ajax/get_personal_debt.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const debt = response.data;
                    $('#edit_id').val(debt.id);
                    $('#edit_to_whom').val(debt.to_whom);
                    $('#edit_amount').val(debt.amount);
                    $('#edit_due_date').val(debt.due_date);
                    $('#edit_paid').val(debt.paid);
                    $('#edit_remaining').val(debt.remaining);
                    $('#edit_planned_payment_date').val(debt.planned_payment_date);
                    $('#editPersonalDebtModal').modal('show');
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
            url: 'ajax/update_personal_debt.php',
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
        if (!confirm('Bu şahıs borcunu silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_personal_debt.php',
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
