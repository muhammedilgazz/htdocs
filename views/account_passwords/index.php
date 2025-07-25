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
                $page_title = 'Hesaplar & Şifreler';
                $page_description = 'Hesap ve şifre yönetimi.';
                $breadcrumb_active = 'Hesaplar & Şifreler';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountCredentialModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Hesap Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-lock"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz hesap/şifre kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Hesap ve şifrelerinizi ekleyerek güvenli bir şekilde saklayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Hesaplar ve Şifreler</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="accountPasswordsTable" class="table align-middle mb-0 table-striped datatable-feature">
                                <thead>
                                    <tr>
                                        <th>Platform</th>
                                        <th>Kullanıcı Adı</th>
                                        <th>Şifre</th>
                                        <th>Hesap Türü</th>
                                        <th>Giriş Linki</th>
                                        <th>Oluşturulma Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['platform_name']) ?></td>
                                        <td><?= htmlspecialchars($row['username']) ?></td>
                                        <td>
                                            <div class="input-group" style="max-width: 150px;">
                                                <input type="password" class="form-control form-control-sm" value="<?= htmlspecialchars($row['password_hash'] ?? '') ?>" readonly>
                                                <button class="btn btn-outline-secondary btn-sm toggle-password" type="button">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($row['account_type_name']) ?></td>
                                        <td>
                                            <?php if (!empty($row['login_url'])): ?>
                                                <a href="<?= htmlspecialchars($row['login_url']) ?>" target="_blank" class="btn btn-outline-dark btn-sm">Link</a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d.m.Y H:i', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editAccountCredentialModal">
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

<!-- Add Account Credential Modal -->
<div class="modal fade" id="addAccountCredentialModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Hesap Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="platform_name" class="form-label">Platform</label>
                        <input type="text" class="form-control" id="platform_name" name="platform_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Kullanıcı Adı</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_hash" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="password_hash" name="password_hash" required>
                    </div>
                    <div class="mb-3">
                        <label for="login_url" class="form-label">Giriş Linki (Opsiyonel)</label>
                        <input type="url" class="form-control" id="login_url" name="login_url">
                    </div>
                    <div class="mb-3">
                        <label for="account_type_id" class="form-label">Hesap Türü</label>
                        <select class="form-select" id="account_type_id" name="account_type_id">
                            <option value="1">İnternet Bankacılığı</option>
                            <option value="2">Mail</option>
                            <option value="3">Sosyal Medya</option>
                            <option value="4">Bahis Sitesi</option>
                            <option value="5">Abonelik Servisi</option>
                            <option value="6">E-Ticaret</option>
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

<!-- Edit Account Credential Modal -->
<div class="modal fade" id="editAccountCredentialModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hesap Bilgisini Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_platform_name" class="form-label">Platform</label>
                        <input type="text" class="form-control" id="edit_platform_name" name="platform_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Kullanıcı Adı</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password_hash" class="form-label">Yeni Şifre (Değiştirmek istemiyorsanız boş bırakın)</label>
                        <input type="password" class="form-control" id="edit_password_hash" name="password_hash">
                    </div>
                    <div class="mb-3">
                        <label for="edit_login_url" class="form-label">Giriş Linki (Opsiyonel)</label>
                        <input type="url" class="form-control" id="edit_login_url" name="login_url">
                    </div>
                    <div class="mb-3">
                        <label for="edit_account_type_id" class="form-label">Hesap Türü</label>
                        <select class="form-select" id="edit_account_type_id" name="account_type_id">
                            <option value="1">İnternet Bankacılığı</option>
                            <option value="2">Mail</option>
                            <option value="3">Sosyal Medya</option>
                            <option value="4">Bahis Sitesi</option>
                            <option value="5">Abonelik Servisi</option>
                            <option value="6">E-Ticaret</option>
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
    $('#accountPasswordsTable').DataTable({
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
        "order": [[ 5, "desc" ]], // Created at sütununa göre tersten sırala
        columnDefs: [ { orderable: false, targets: [2, 4, 6] } ] // Şifre, Link ve İşlemler sıralanamaz
    });

    // Şifre göster/gizle toggle
    $('.toggle-password').click(function() {
        const input = $(this).siblings('input');
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });

    // Add Form with SweetAlert
    $('#addForm').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: 'ajax/add_account_credential.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#addAccountCredentialModal').modal('hide');
                    Swal.fire({
                        title: 'Başarılı!',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                }
            },
            error: function() {
                Swal.fire('Hata!', 'Sunucuyla iletişim kurulamadı.', 'error');
            }
        });
    });

    // Edit Button - Fetch data
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_account_credential.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const credential = response.data;
                    $('#edit_id').val(credential.id);
                    $('#edit_platform_name').val(credential.platform_name);
                    $('#edit_username').val(credential.username);
                    $('#edit_password_hash').val(''); // Şifre alanını boş bırak
                    $('#edit_login_url').val(credential.login_url);
                    $('#edit_account_type_id').val(credential.account_type_id);
                    $('#editAccountCredentialModal').modal('show');
                } else {
                    Swal.fire('Hata!', response.message || 'Veri getirilemedi.', 'error');
                }
            },
            error: function() {
                Swal.fire('Hata!', 'Sunucuyla iletişim kurulamadı.', 'error');
            }
        });
    });

    // Edit Form - Submit data
    $('#editForm').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: 'ajax/update_account_credential.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#editAccountCredentialModal').modal('hide');
                    Swal.fire({
                        title: 'Başarılı!',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                }
            },
            error: function() {
                Swal.fire('Hata!', 'Sunucuyla iletişim kurulamadı.', 'error');
            }
        });
    });

    // Delete Button with SweetAlert
    $('.delete-btn').click(function() {
        const button = $(this);
        const id = button.data('id');

        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu hesap bilgisini silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'ajax/delete_account_credential.php',
                    type: 'POST',
                    data: { id: id, csrf_token: '<?= $csrf_token ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            button.closest('tr').fadeOut(400, function() {
                                $(this).remove();
                            });
                            Swal.fire('Silindi!', response.message, 'success');
                        } else {
                            Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Hata!', 'Sunucuyla iletişim kurulamadı.', 'error');
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>
