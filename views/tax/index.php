<?php
require_once ROOT_PATH . '/views/partials/head.php';
?>
<style>
    .row.equal-height > [class^="col-"] > .card {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: stretch;
    }
    .row.equal-height > [class^="col-"] {
        display: flex;
        flex-direction: column;
    }
</style>
<body>
<div class="app-container">
    <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
        <div class="app-content">
            <div class="container-fluid">
                <?php
                $page_title = 'Vergi Borçları';
                $page_description = 'Vergi ödemeleri ve borçları takibi.';
                $breadcrumb_active = 'Vergi Borçları';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="row mb-4 equal-height">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-primary p-3"><i class="bi bi-person-badge fs-4"></i></span>
                                </div>
                                <div>
                                    <div class="text-muted small">Şahsi Vergi (Toplam)</div>
                                    <div class="fs-5 fw-bold">₺<?= number_format($summary['personal'] ?? 0, 2, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-info p-3"><i class="bi bi-briefcase fs-4"></i></span>
                                </div>
                                <div>
                                    <div class="text-muted small">Timdesigners Vergi (Toplam)</div>
                                    <div class="fs-5 fw-bold">₺<?= number_format($summary['timdesigners'] ?? 0, 2, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-warning p-3"><i class="bi bi-building fs-4"></i></span>
                                </div>
                                <div>
                                    <div class="text-muted small">RentAkar Vergi (Toplam)</div>
                                    <div class="fs-5 fw-bold">₺<?= number_format($summary['rentakar'] ?? 0, 2, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-danger p-3"><i class="bi bi-cash-coin fs-4"></i></span>
                                </div>
                                <div>
                                    <div class="text-muted small">Toplam Borç</div>
                                    <div class="fs-5 fw-bold">₺<?= number_format($summary['total'] ?? 0, 2, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaxDebtModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Vergi Borcu Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz vergi borcu kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Vergi borçlarınızı ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Vergi Borçları Listesi</h5>
                            <div class="d-flex align-items-center">
                                <?php if (!empty($rows)): ?>
                                    <h5 class="mb-0 text-end me-3">Toplam: ₺<?= number_format(array_sum(array_column($rows, 'total')), 2, ',', '.') ?></h5>
                                <?php endif; ?>
                                <button id="export-excel-tax" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="taxTable" class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Sahibi</th>
                                        <th>Dönem</th>
                                        <th>Anapara</th>
                                        <th>Faiz</th>
                                        <th>Toplam</th>
                                        <th>Ödeme Vadesi</th>
                                        <th>Planlanan Ödeme</th>
                                        <th>Ödenen</th>
                                        <th>Kalan</th>
                                        <th>Bu Ay Ödeme</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['owner']) ?></td>
                                        <td><?= htmlspecialchars($row['period']) ?></td>
                                        <td>₺<?= number_format($row['principal'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['interest'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['total'], 2, ',', '.') ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['payment_due'])) ?></td>
                                        <td>₺<?= number_format($row['planned_payment'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['paid'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['remaining'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['this_month_payment'], 2, ',', '.') ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editTaxDebtModal">
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

<!-- Add Tax Debt Modal -->
<div class="modal fade" id="addTaxDebtModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Vergi Borcu Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="owner" class="form-label">Sahibi</label>
                        <input type="text" class="form-control" id="owner" name="owner" required>
                    </div>
                    <div class="mb-3">
                        <label for="period" class="form-label">Dönem</label>
                        <input type="text" class="form-control" id="period" name="period">
                    </div>
                    <div class="mb-3">
                        <label for="principal" class="form-label">Anapara</label>
                        <input type="number" class="form-control" id="principal" name="principal" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="interest" class="form-label">Faiz</label>
                        <input type="number" class="form-control" id="interest" name="interest" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Toplam</label>
                        <input type="number" class="form-control" id="total" name="total" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="payment_due" class="form-label">Ödeme Vadesi</label>
                        <input type="date" class="form-control" id="payment_due" name="payment_due">
                    </div>
                    <div class="mb-3">
                        <label for="planned_payment" class="form-label">Planlanan Ödeme</label>
                        <input type="number" class="form-control" id="planned_payment" name="planned_payment" step="0.01">
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

<!-- Edit Tax Debt Modal -->
<div class="modal fade" id="editTaxDebtModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vergi Borcunu Düzenle</h5>
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
                        <label for="edit_period" class="form-label">Dönem</label>
                        <input type="text" class="form-control" id="edit_period" name="period">
                    </div>
                    <div class="mb-3">
                        <label for="edit_principal" class="form-label">Anapara</label>
                        <input type="number" class="form-control" id="edit_principal" name="principal" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_interest" class="form-label">Faiz</label>
                        <input type="number" class="form-control" id="edit_interest" name="interest" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_total" class="form-label">Toplam</label>
                        <input type="number" class="form-control" id="edit_total" name="total" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="edit_payment_due" class="form-label">Ödeme Vadesi</label>
                        <input type="date" class="form-control" id="edit_payment_due" name="payment_due">
                    </div>
                    <div class="mb-3">
                        <label for="edit_planned_payment" class="form-label">Planlanan Ödeme</label>
                        <input type="number" class="form-control" id="edit_planned_payment" name="planned_payment" step="0.01">
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

<?php include ROOT_PATH . '/views/partials/script.php'; ?>

<script>
$(document).ready(function() {
    $('#taxTable').DataTable({
        language: {
            "sDecimal": ",", "sEmptyTable": "Tabloda herhangi bir veri mevcut değil", "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor", "sInfoEmpty": "Kayıt yok", "sInfoFiltered": "(_MAX_ kayıt içerisinden bulundu)", "sInfoPostFix": "", "sInfoThousands": ".", "sLengthMenu": "Sayfada _MENU_ kayıt göster", "sLoadingRecords": "Yükleniyor...", "sProcessing": "İşleniyor...", "sSearch": "Ara:", "sZeroRecords": "Eşleşen kayıt bulunamadı", "oPaginate": { "sFirst": "İlk", "sLast": "Son", "sNext": "Sonraki", "sPrevious": "Önceki" }, "oAria": { "sSortAscending": ": artan sütun sıralamasını aktifleştir", "sSortDescending": ": azalan sütun sıralamasını aktifleştir" }
        },
        "order": [[ 5, "asc" ]], // Ödeme vadesine göre sırala
        columnDefs: [ { orderable: false, targets: 10 } ] // İşlemler sıralanamaz
    });

    $('#export-excel-tax').click(function() {
        window.location.href = 'ajax/export_tax.php';
    });

    // Add Form
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax.php?action=taxdebt_add',
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
            url: 'ajax.php?action=taxdebt_get',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const debt = response.data;
                    $('#edit_id').val(debt.id);
                    $('#edit_owner').val(debt.owner);
                    $('#edit_period').val(debt.period);
                    $('#edit_principal').val(debt.principal);
                    $('#edit_interest').val(debt.interest);
                    $('#edit_total').val(debt.total);
                    $('#edit_payment_due').val(debt.payment_due);
                    $('#edit_planned_payment').val(debt.planned_payment);
                    $('#edit_paid').val(debt.paid);
                    $('#edit_remaining').val(debt.remaining);
                    $('#edit_this_month_payment').val(debt.this_month_payment);
                    $('#editTaxDebtModal').modal('show');
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
            url: 'ajax.php?action=taxdebt_update',
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
        if (!confirm('Bu vergi borcunu silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax.php?action=taxdebt_delete',
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
