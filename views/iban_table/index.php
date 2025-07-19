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
                $page_title = 'Banka Hesapları';
                $page_description = 'Banka hesap bilgilerinizi güvenli bir şekilde saklayın.';
                $breadcrumb_active = 'Banka Hesapları';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Hesap Ekle
                    </button>
                </div>

                <!-- Kendi Hesaplarım Tablosu -->
                <div class="card p-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Kendi Hesaplarım</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($my_accounts)): ?>
                            <div class="text-center py-5">
                                <p>Henüz kendi banka hesabınız yok.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Banka Adı</th>
                                            <th>Hesap Sahibi</th>
                                            <th>IBAN Numarası</th>
                                            <th>Kolay Adres</th>
                                            <th>Açıklama</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($my_accounts as $account): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($account['bank_name']) ?></td>
                                            <td><?= htmlspecialchars($account['account_holder']) ?></td>
                                            <td><?= htmlspecialchars($account['iban_number']) ?></td>
                                            <td><?= htmlspecialchars($account['easy_address'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($account['description'] ?? '-') ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $account['id'] ?>" data-bs-toggle="modal" data-bs-target="#editAccountModal">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $account['id'] ?>">
                                                        <i class="bi bi-trash"></i>
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

                <!-- Diğer Hesaplar Tablosu -->
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Diğer Hesaplar</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($other_accounts)): ?>
                            <div class="text-center py-5">
                                <p>Henüz diğer banka hesabı kaydınız yok.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Banka Adı</th>
                                            <th>Hesap Sahibi</th>
                                            <th>IBAN Numarası</th>
                                            <th>Kolay Adres</th>
                                            <th>Açıklama</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($other_accounts as $account): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($account['bank_name']) ?></td>
                                            <td><?= htmlspecialchars($account['account_holder']) ?></td>
                                            <td><?= htmlspecialchars($account['iban_number']) ?></td>
                                            <td><?= htmlspecialchars($account['easy_address'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($account['description'] ?? '-') ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $account['id'] ?>" data-bs-toggle="modal" data-bs-target="#editAccountModal">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $account['id'] ?>">
                                                        <i class="bi bi-trash"></i>
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
            </div>
        </div>
    </div>
</div>

<!-- Add Account Modal -->
<div class="modal fade" id="addAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Banka Hesabı Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="account_holder" class="form-label">Hesap Sahibi</label>
                        <input type="text" class="form-control" id="account_holder" name="account_holder" required>
                    </div>
                    <div class="mb-3">
                        <label for="iban_number" class="form-label">IBAN Numarası</label>
                        <input type="text" class="form-control" id="iban_number" name="iban_number">
                    </div>
                    <div class="mb-3">
                        <label for="easy_address" class="form-label">Kolay Adres</label>
                        <input type="text" class="form-control" id="easy_address" name="easy_address">
                    </div>
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Banka Adı</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="bank_logo" class="form-label">Banka Logo URL</label>
                        <input type="url" class="form-control" id="bank_logo" name="bank_logo">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="account_type" class="form-label">Hesap Tipi</label>
                        <select class="form-select" id="account_type" name="account_type">
                            <option value="own">Kendi Hesabım</option>
                            <option value="other">Diğer Hesap</option>
                        </select>
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

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Banka Hesabını Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_account_holder" class="form-label">Hesap Sahibi</label>
                        <input type="text" class="form-control" id="edit_account_holder" name="account_holder" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_iban_number" class="form-label">IBAN Numarası</label>
                        <input type="text" class="form-control" id="edit_iban_number" name="iban_number">
                    </div>
                    <div class="mb-3">
                        <label for="edit_easy_address" class="form-label">Kolay Adres</label>
                        <input type="text" class="form-control" id="edit_easy_address" name="easy_address">
                    </div>
                    <div class="mb-3">
                        <label for="edit_bank_name" class="form-label">Banka Adı</label>
                        <input type="text" class="form-control" id="edit_bank_name" name="bank_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_bank_logo" class="form-label">Banka Logo URL</label>
                        <input type="url" class="form-control" id="edit_bank_logo" name="bank_logo">
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_account_type" class="form-label">Hesap Tipi</label>
                        <select class="form-select" id="edit_account_type" name="account_type">
                            <option value="own">Kendi Hesabım</option>
                            <option value="other">Diğer Hesap</option>
                        </select>
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
            url: 'ajax/add_bank_account.php',
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
            url: 'ajax/get_bank_account.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const account = response.data;
                    $('#edit_id').val(account.id);
                    $('#edit_account_holder').val(account.account_holder);
                    $('#edit_iban_number').val(account.iban_number);
                    $('#edit_easy_address').val(account.easy_address);
                    $('#edit_bank_name').val(account.bank_name);
                    $('#edit_bank_logo').val(account.bank_logo);
                    $('#edit_description').val(account.description);
                    $('#edit_account_type').val(account.account_type);
                    $('#editAccountModal').modal('show');
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
            url: 'ajax/update_bank_account.php',
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
        if (!confirm('Bu hesabı silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_bank_account.php',
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
