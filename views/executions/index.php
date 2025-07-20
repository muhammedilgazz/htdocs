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
                $page_title = 'İcra Borçları';
                $page_description = 'İcra takipleri ve borç yönetimi.';
                $breadcrumb_active = 'İcra Borçları';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExecutionDebtModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni İcra Borcu Ekle
                    </button>
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
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">İcra Borçları Listesi</h5>
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 me-3">Toplam: ₺<?= number_format($total_debt, 2, ',', '.') ?></h5>
                            <button id="export-excel-execution" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="executionsTable" class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Sahibi</th>
                                        <th>Alacaklı</th>
                                        <th>İcra Dairesi</th>
                                        <th>Güncel Borç</th>
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
                                        <td>₺<?= number_format($row['current_debt'], 2, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td>₺<?= number_format($row['planned_payment'], 2, ',', '.') ?></td>
                                        <td>₺<?= number_format($row['this_month_payment'], 2, ',', '.') ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-info btn-sm detail-btn" data-id="<?= $row['id'] ?>">
                                                    <i class="bi bi-info-circle"></i>
                                                </button>
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
    <div class="modal-dialog modal-dialog-centered">
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
    <div class="modal-dialog modal-dialog-centered">
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

<!-- Detail Execution Debt Modal -->
<div class="modal fade" id="detailExecutionDebtModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">İcra Borcu Detayları</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Sahibi</dt>
                    <dd class="col-sm-8" id="detail_owner"></dd>
                    
                    <dt class="col-sm-4">Alacaklı</dt>
                    <dd class="col-sm-8" id="detail_creditor"></dd>

                    <dt class="col-sm-4">İcra Dairesi</dt>
                    <dd class="col-sm-8" id="detail_execution_office"></dd>

                    <dt class="col-sm-4">Başlangıç Tarihi</dt>
                    <dd class="col-sm-8" id="detail_start_date"></dd>

                    <dt class="col-sm-4">Güncel Borç</dt>
                    <dd class="col-sm-8" id="detail_current_debt"></dd>

                    <dt class="col-sm-4">Anapara Borcu</dt>
                    <dd class="col-sm-8" id="detail_principal_debt"></dd>

                    <dt class="col-sm-4">İletişim Bilgisi</dt>
                    <dd class="col-sm-8" id="detail_contact_info"></dd>

                    <dt class="col-sm-4">Durum</dt>
                    <dd class="col-sm-8" id="detail_status"></dd>

                    <dt class="col-sm-4">Planlanan Ödeme</dt>
                    <dd class="col-sm-8" id="detail_planned_payment"></dd>
                    
                    <dt class="col-sm-4">Bu Ay Ödeme</dt>
                    <dd class="col-sm-8" id="detail_this_month_payment"></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/partials/script.php'; ?>

<script>
$(document).ready(function() {
    $('#executionsTable').DataTable({
        language: {
            "sDecimal": ",",
            "sEmptyTable": "Tabloda herhangi bir veri mevcut değil",
            "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "sInfoEmpty": "Kayıt yok",
            "sInfoFiltered": "(_MAX_ kayıt içerisinden bulundu)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Sayfada _MENU_ kayıt göster",
            "sLoadingRecords": "Yükleniyor...",
            "sProcessing": "İşleniyor...",
            "sSearch": "Ara:",
            "sZeroRecords": "Eşleşen kayıt bulunamadı",
            "oPaginate": {
                "sFirst": "İlk",
                "sLast": "Son",
                "sNext": "Sonraki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending": ": artan sütun sıralamasını aktifleştir",
                "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
            }
        },
        columnDefs: [ { orderable: false, targets: 7 } ] // İşlemler sıralanamaz
    });

    $('#export-excel-execution').click(function() {
        window.location.href = 'ajax/export_executions.php';
    });

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

// Detail Button
    $('.detail-btn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_execution_debt.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const debt = response.data;
                    
                    const currencyFormatter = new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' });
                    const formatDate = (dateString) => {
                        if (!dateString || dateString === '0000-00-00') return '-';
                        const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
                        return new Date(dateString).toLocaleDateString('tr-TR', options);
                    };

                    $('#detail_owner').text(debt.owner || '-');
                    $('#detail_creditor').text(debt.creditor || '-');
                    $('#detail_execution_office').text(debt.execution_office || '-');
                    $('#detail_start_date').text(formatDate(debt.start_date));
                    $('#detail_current_debt').text(currencyFormatter.format(debt.current_debt || 0));
                    $('#detail_principal_debt').text(currencyFormatter.format(debt.principal_debt || 0));
                    $('#detail_contact_info').text(debt.contact_info || '-');
                    $('#detail_status').text(debt.status || '-');
                    $('#detail_planned_payment').text(currencyFormatter.format(debt.planned_payment || 0));
                    $('#detail_this_month_payment').text(currencyFormatter.format(debt.this_month_payment || 0));
                    
                    $('#detailExecutionDebtModal').modal('show');
                } else {
                    alert(response.message || 'Veri getirilemedi.');
                }
            },
            error: function() {
                alert('Sunucu ile iletişim kurulurken bir hata oluştu.');
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
