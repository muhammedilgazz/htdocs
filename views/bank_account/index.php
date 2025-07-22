<?php 
require_once __DIR__ . '/../../config/config.php';
require_once ROOT_PATH . '/views/partials/head.php'; 
?>
<body>
<div class="app-container">
    <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <?php
                        $page_title = 'Banka Hesapları';
                        $page_description = 'Kayıtlı banka hesaplarınızı yönetin.';
                        $breadcrumb_active = 'Banka Hesapları';
                        include ROOT_PATH . '/views/partials/page_header.php';
                        ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accountModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Hesap Ekle
                    </button>
                </div>

                <!-- Kendi Hesaplarım -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Kendi Hesaplarım</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($own_accounts)): ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Henüz kendinize ait bir banka hesabı eklemediniz.</p>
                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table id="ownAccountsTable" class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Hesap Sahibi</th>
                                        <th>Banka Adı</th>
                                        <th>IBAN</th>
                                        <th>Kolay Adres</th>
                                        <th>Açıklama</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($own_accounts as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['account_holder']) ?></td>
                                        <td><?= htmlspecialchars($row['bank_name']) ?></td>
                                        <td><?= htmlspecialchars($row['iban_number']) ?></td>
                                        <td><?= htmlspecialchars($row['easy_address']) ?></td>
                                        <td><?= htmlspecialchars($row['description']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary edit-btn" data-id="<?= $row['id'] ?>"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $row['id'] ?>"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Diğer Hesaplar -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Diğer Kayıtlı Hesaplar</h5>
                    </div>
                    <div class="card-body">
                         <?php if (empty($other_accounts)): ?>
                        <div class="text-center py-4">
                            <p class="text-muted">Henüz başkasına ait bir banka hesabı eklemediniz.</p>
                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table id="otherAccountsTable" class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Hesap Sahibi</th>
                                        <th>Banka Adı</th>
                                        <th>IBAN</th>
                                        <th>Kolay Adres</th>
                                        <th>Açıklama</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($other_accounts as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['account_holder']) ?></td>
                                        <td><?= htmlspecialchars($row['bank_name']) ?></td>
                                        <td><?= htmlspecialchars($row['iban_number']) ?></td>
                                        <td><?= htmlspecialchars($row['easy_address']) ?></td>
                                        <td><?= htmlspecialchars($row['description']) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary edit-btn" data-id="<?= $row['id'] ?>"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $row['id'] ?>"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="accountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Yeni Hesap Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="accountForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                    <div class="mb-3">
                        <label for="account_holder" class="form-label">Hesap Sahibi</label>
                        <input type="text" class="form-control" id="account_holder" name="account_holder" required>
                    </div>
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Banka Adı</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="iban_number" class="form-label">IBAN</label>
                        <input type="text" class="form-control" id="iban_number" name="iban_number">
                    </div>
                    <div class="mb-3">
                        <label for="easy_address" class="form-label">Kolay Adres</label>
                        <input type="text" class="form-control" id="easy_address" name="easy_address">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                     <div class="mb-3">
                        <label for="account_type" class="form-label">Hesap Türü</label>
                        <select class="form-select" id="account_type" name="account_type">
                            <option value="own">Kendi Hesabım</option>
                            <option value="other">Başkasına Ait</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/views/partials/script.php'; ?>
<script>
$(document).ready(function() {
    // DataTable initialization - global Turkish settings already applied
    $('#ownAccountsTable').DataTable();
    $('#otherAccountsTable').DataTable();

    const modalElement = document.getElementById('accountModal');
    const modal = new bootstrap.Modal(modalElement);
    const modalTitle = document.getElementById('modalTitle');
    const form = document.getElementById('accountForm');
    const idInput = document.getElementById('id');

    // Open modal for adding
    $('[data-bs-target="#accountModal"]').click(function() {
        form.reset();
        idInput.value = '';
        modalTitle.textContent = 'Yeni Hesap Ekle';
        console.log('Opening modal for adding new account');
        
        modal.show();
    });

    // Open modal for editing
    $('.table').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        console.log('Edit button clicked, ID:', id);
        
        if (!id) {
            Swal.fire('Hata!', 'Hesap ID bulunamadı.', 'error');
            return;
        }
        
        $.ajax({
            url: 'ajax/get_bank_account.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= generate_csrf_token() ?>' },
            dataType: 'json',
            beforeSend: function() {
                console.log('AJAX request started for ID:', id);
            },
            success: function(response) {
                console.log('AJAX response received:', response);
                if (response.success) {
                    const data = response.data;
                    form.reset();
                    idInput.value = data.id;
                    $('#account_holder').val(data.account_holder);
                    $('#bank_name').val(data.bank_name);
                    $('#iban_number').val(data.iban_number);
                    $('#easy_address').val(data.easy_address);
                    $('#description').val(data.description);
                    $('#account_type').val(data.account_type);
                    modalTitle.textContent = 'Hesabı Düzenle';
                    console.log('About to show modal');
                    
                    modal.show();
                } else {
                    Swal.fire('Hata!', response.message || 'Hesap bilgileri alınamadı.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                console.error('Response text:', xhr.responseText);
                Swal.fire('Hata!', 'Sunucu hatası: ' + error, 'error');
            }
        });
    });

    // Form submission
    $('#accountForm').submit(function(e) {
        e.preventDefault();
        const id = idInput.value;
        const url = id ? 'ajax/update_bank_account.php' : 'ajax/add_bank_account.php';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    modal.hide();
                    Swal.fire('Başarılı!', response.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                }
            }
        });
    });

    // Delete button
    $('.table').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu hesabı silmek istediğinizden emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'İptal',
            confirmButtonText: 'Evet, sil!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'ajax/delete_bank_account.php',
                    type: 'POST',
                    data: { id: id, csrf_token: '<?= generate_csrf_token() ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Silindi!', response.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                        }
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>