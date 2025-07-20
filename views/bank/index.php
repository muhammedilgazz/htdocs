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
                $page_title = 'Banka Borçları';
                $page_description = 'Banka kredileri ve borçları takibi.';
                $breadcrumb_active = 'Banka Borçları';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBankDebtModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Banka Borcu Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-bank"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz banka borcu kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Banka borçlarınızı ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Banka Borçları Listesi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="bankDebtsTable" class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Banka Adı</th>
                                        <th>Kredi Tipi</th>
                                        <th>Anapara</th>
                                        <th>Toplam Borç</th>
                                        <th>Yasal Süreçte Mi?</th>
                                        <th>Varlık Şirketi</th>
                                        <th>Taksitli Mi?</th>
                                        <th>Planlanan Ödeme Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['bank_name']) ?></td>
                                        <td><?= htmlspecialchars($row['loan_type']) ?></td>
                                        <td>₺<?= number_format($row['principal'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['total'], 2, ',', '.') ?></td>
                                        <td><?= $row['is_legal_process'] ? 'Evet' : 'Hayır' ?></td>
                                        <td><?= htmlspecialchars($row['asset_company'] ?? '-') ?></td>
                                        <td><?= $row['is_installment'] ? 'Evet' : 'Hayır' ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['planned_payment_date'])) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editBankDebtModal">
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

<!-- Add Bank Debt Modal -->
<div class="modal fade" id="addBankDebtModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Banka Borcu Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Banka Adı</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="loan_type" class="form-label">Kredi Tipi</label>
                        <input type="text" class="form-control" id="loan_type" name="loan_type">
                    </div>
                    <div class="mb-3">
                        <label for="principal" class="form-label">Anapara</label>
                        <input type="number" class="form-control" id="principal" name="principal" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Toplam Borç</label>
                        <input type="number" class="form-control" id="total" name="total" step="0.01">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_legal_process" name="is_legal_process" value="1">
                        <label class="form-check-label" for="is_legal_process">Yasal Süreçte Mi?</label>
                    </div>
                    <div class="mb-3">
                        <label for="asset_company" class="form-label">Varlık Şirketi</label>
                        <input type="text" class="form-control" id="asset_company" name="asset_company">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_installment" name="is_installment" value="1">
                        <label class="form-check-label" for="is_installment">Taksitli Mi?</label>
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

<!-- Edit Bank Debt Modal -->
<div class="modal fade" id="editBankDebtModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Banka Borcunu Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_bank_name" class="form-label">Banka Adı</label>
                        <input type="text" class="form-control" id="edit_bank_name" name="bank_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_loan_type" class="form-label">Kredi Tipi</label>
                        <input type="text" class="form-control" id="edit_loan_type" name="loan_type">
                    </div>
                    <div class="mb-3">
                        <label for="edit_principal" class="form-label">Anapara</label>
                        <input type="number" class="form-control" id="edit_principal" name="principal" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_total" class="form-label">Toplam Borç</label>
                        <input type="number" class="form-control" id="edit_total" name="total" step="0.01">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_legal_process" name="is_legal_process" value="1">
                        <label class="form-check-label" for="edit_is_legal_process">Yasal Süreçte Mi?</label>
                    </div>
                    <div class="mb-3">
                        <label for="edit_asset_company" class="form-label">Varlık Şirketi</label>
                        <input type="text" class="form-control" id="edit_asset_company" name="asset_company">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_installment" name="is_installment" value="1">
                        <label class="form-check-label" for="edit_is_installment">Taksitli Mi?</label>
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
    $('#bankDebtsTable').DataTable({
        language: {
            "sDecimal": ",", "sEmptyTable": "Tabloda herhangi bir veri mevcut değil", "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor", "sInfoEmpty": "Kayıt yok", "sInfoFiltered": "(_MAX_ kayıt içerisinden bulundu)", "sInfoPostFix": "", "sInfoThousands": ".", "sLengthMenu": "Sayfada _MENU_ kayıt göster", "sLoadingRecords": "Yükleniyor...", "sProcessing": "İşleniyor...", "sSearch": "Ara:", "sZeroRecords": "Eşleşen kayıt bulunamadı", "oPaginate": { "sFirst": "İlk", "sLast": "Son", "sNext": "Sonraki", "sPrevious": "Önceki" }, "oAria": { "sSortAscending": ": artan sütun sıralamasını aktifleştir", "sSortDescending": ": azalan sütun sıralamasını aktifleştir" }
        },
        "order": [[ 7, "asc" ]], // Planlanan Ödeme Tarihine göre sırala
        columnDefs: [ { orderable: false, targets: 8 } ]
    });

    // Add Form
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_bank_debt.php',
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
            url: 'ajax/get_bank_debt.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const debt = response.data;
                    $('#edit_id').val(debt.id);
                    $('#edit_bank_name').val(debt.bank_name);
                    $('#edit_loan_type').val(debt.loan_type);
                    $('#edit_principal').val(debt.principal);
                    $('#edit_total').val(debt.total);
                    $('#edit_is_legal_process').prop('checked', debt.is_legal_process == 1);
                    $('#edit_asset_company').val(debt.asset_company);
                    $('#edit_is_installment').prop('checked', debt.is_installment == 1);
                    $('#edit_planned_payment_date').val(debt.planned_payment_date);
                    $('#editBankDebtModal').modal('show');
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
            url: 'ajax/update_bank_debt.php',
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
        if (!confirm('Bu banka borcunu silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_bank_debt.php',
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
