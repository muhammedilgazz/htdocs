<?php
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/views/partials/head.php';
require_once ROOT_PATH . '/helpers/currency_helper.php';
?>
<body>
<div class="app-container">
    <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
        <div class="app-content">
            <div class="container-fluid">
                <?php
                $page_title = 'Tüm Gelirler';
                $page_description = 'Tüm gelir kayıtlarınızı görüntüleyin ve yönetin.';
                $breadcrumb_active = 'Tüm Gelirler';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Gelir Ekle
                    </button>
                </div>

                <?php if (empty($incomes)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz gelir kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Gelirlerinizi ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gelir Listesi</h5>
                            <div class="d-flex align-items-center">
                                <?php if (!empty($incomes)): ?>
                                    <h5 class="mb-0 text-end me-3">Toplam: ₺<?= number_format(getTotalInTL($incomes), 2, ',', '.') ?></h5>
                                <?php endif; ?>
                                <button id="export-excel-incomes" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="incomesTable" class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Başlık</th>
                                        <th>Para Birimi</th>
                                        <th>Tutar</th>
                                        <th>Periyot</th>
                                        <th>Alım Tarihi</th>
                                        <th>Borç mu?</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($incomes as $income): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($income['title']) ?></td>
                                        <td><?= htmlspecialchars($income['currency']) ?></td>
                                        <td><?= formatAmountWithCurrency($income['amount'], $income['currency']) ?></td>
                                        <td><?= htmlspecialchars($income['period']) ?></td>
                                        <td><?= date('d.m.Y', strtotime($income['receive_date'])) ?></td>
                                        <td>
                                            <span class="badge <?= $income['is_debt'] ? 'bg-danger' : 'bg-success' ?>">
                                                <?= $income['is_debt'] ? 'Evet' : 'Hayır' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm" onclick="editIncome(<?= $income['id'] ?>)">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm" onclick="deleteIncome(<?= $income['id'] ?>)">
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

<!-- Add Income Modal -->
<div class="modal fade" id="addIncomeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Gelir Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addIncomeForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Gelir Başlığı *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="currency" class="form-label">Para Birimi *</label>
                                <select class="form-select" id="currency" name="currency" required>
                                    <option value="TRY">TRY - Türk Lirası</option>
                                    <option value="USD">USD - Amerikan Doları</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - İngiliz Sterlini</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Tutar *</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="period" class="form-label">Periyot *</label>
                                <select class="form-select" id="period" name="period" required>
                                    <option value="daily">Günlük</option>
                                    <option value="weekly">Haftalık</option>
                                    <option value="monthly" selected>Aylık</option>
                                    <option value="yearly">Yıllık</option>
                                    <option value="one_time">Tek Seferlik</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="receive_date" class="form-label">Alım Tarihi *</label>
                                <input type="date" class="form-control" id="receive_date" name="receive_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_debt" class="form-label">Borç mu? *</label>
                                <select class="form-select" id="is_debt" name="is_debt" required>
                                    <option value="no" selected>Hayır</option>
                                    <option value="yes">Evet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Income Modal -->
<div class="modal fade" id="editIncomeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gelir Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editIncomeForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Gelir Başlığı *</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_currency" class="form-label">Para Birimi *</label>
                                <select class="form-select" id="edit_currency" name="currency" required>
                                    <option value="TRY">TRY - Türk Lirası</option>
                                    <option value="USD">USD - Amerikan Doları</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - İngiliz Sterlini</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_amount" class="form-label">Tutar *</label>
                                <input type="number" class="form-control" id="edit_amount" name="amount" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_period" class="form-label">Periyot *</label>
                                <select class="form-select" id="edit_period" name="period" required>
                                    <option value="daily">Günlük</option>
                                    <option value="weekly">Haftalık</option>
                                    <option value="monthly">Aylık</option>
                                    <option value="yearly">Yıllık</option>
                                    <option value="one_time">Tek Seferlik</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_receive_date" class="form-label">Alım Tarihi *</label>
                                <input type="date" class="form-control" id="edit_receive_date" name="receive_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_is_debt" class="form-label">Borç mu? *</label>
                                <select class="form-select" id="edit_is_debt" name="is_debt" required>
                                    <option value="no">Hayır</option>
                                    <option value="yes">Evet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // DataTable initialization
    $('#incomesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json'
        },
        order: [[4, 'desc']] // Alım tarihine göre sırala
    });

    // Add Income Form submission
    document.getElementById('addIncomeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('csrf_token', '<?= generate_csrf_token() ?>');
        
        fetch('/ajax/add_income.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                $('#addIncomeModal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Bir hata oluştu.');
        });
    });

    // Edit Income Form submission
    document.getElementById('editIncomeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('csrf_token', '<?= generate_csrf_token() ?>');
        
        fetch('/ajax/update_income.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                $('#editIncomeModal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Bir hata oluştu.');
        });
    });
});

function editIncome(id) {
    console.log('Edit income called with ID:', id);
    
    // Gelir verilerini getir
    fetch(`/ajax/get_income.php?id=${id}&csrf_token=<?= generate_csrf_token() ?>`)
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            const income = data.data;
            
            // Modal alanlarını doldur
            document.getElementById('edit_id').value = income.id;
            document.getElementById('edit_title').value = income.title;
            document.getElementById('edit_currency').value = income.currency;
            document.getElementById('edit_amount').value = income.amount;
            document.getElementById('edit_period').value = income.period;
            document.getElementById('edit_receive_date').value = income.receive_date;
            document.getElementById('edit_is_debt').value = income.is_debt;
            document.getElementById('edit_description').value = income.description || '';
            
            // Modal'ı aç
            new bootstrap.Modal(document.getElementById('editIncomeModal')).show();
        } else {
            toastr.error(data.message || 'Gelir bilgileri alınamadı.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('Bir hata oluştu: ' + error.message);
    });
}

function deleteIncome(id) {
    if (confirm('Bu geliri silmek istediğinizden emin misiniz?')) {
        fetch(`/ajax/delete_income.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&csrf_token=<?= generate_csrf_token() ?>`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Bir hata oluştu.');
        });
    }
}
</script>

<?php include ROOT_PATH . '/views/partials/script.php'; ?>
</body>
</html> 