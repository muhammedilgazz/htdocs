<?php
require_once 'C:/xampp/htdocs/views/partials/head.php';
?>
<body>
<div class="app-container">
    <?php require_once 'C:/xampp/htdocs/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once 'C:/xampp/htdocs/views/partials/header.php'; ?>
        <?php 
        require_once 'C:/xampp/htdocs/views/partials/page_header.php';
        generate_page_header(
            'Hesaplar & Şifreler',
            'Hesap ve şifre yönetimi.',
            [
                ['link' => '/', 'text' => 'Anasayfa'],
                ['text' => 'Hesaplar & Şifreler', 'active' => true]
            ]
        );
        ?>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <!-- Boş Durum Kontrolü -->
                <?php if (empty($rows)): ?>
                <?php 
                require_once 'C:/xampp/htdocs/views/partials/empty_state.php';
                generate_empty_state(
                    'bi bi-lock',
                    'Henüz hesap/şifre kaydı yok',
                    'Hesap ve şifrelerinizi ekleyerek güvenli bir şekilde saklayın.',
                    'İlk Hesap Ekle',
                    '#hesapEkleModal'
                );
                ?>
                <?php else: ?>
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Hesap ve Şifreler</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#hesapEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i>Yeni Hesap Ekle
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">ID</th>
                                        <th>Platform</th>
                                        <th>Kullanıcı Adı</th>
                                        <th>Şifre</th>
                                        <th>Hesap Türü</th>
                                        <th>Giriş Linki</th>
                                        <th>Oluşturulma Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= $row['id'] ?> </td>
                                        <td> <?= htmlspecialchars($row['platform']) ?> </td>
                                        <td> <?= htmlspecialchars($row['username']) ?> </td>
                                        <td>
                                            <div class="input-group" style="max-width: 150px;">
                                                <input type="password" class="form-control form-control-sm" value="<?= htmlspecialchars($row['password'] ?? '') ?>" readonly style="font-size: 0.8rem;">
                                                <button class="btn btn-outline-secondary btn-sm toggle-password" type="button" style="font-size: 0.8rem;">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background:#96ceb4; color:#fff; font-weight:600; font-size:0.6rem; padding:0.2rem 0.4rem;">
                                                <?= htmlspecialchars($row['account_type_name']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['login_link'])): ?>
                                                <a href="<?= htmlspecialchars($row['login_link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td> <?= date('d.m.Y H:i', strtotime($row['created_at'])) ?> </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Düzenle" type="button">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Sil" type="button">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <!-- Hesap Ekle Modal -->
                <div class="modal fade" id="hesapEkleModal" tabindex="-1" aria-labelledby="hesapEkleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hesapEkleModalLabel">Yeni Hesap Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="hesapEkleForm">
                                <div class="modal-body">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    
                                    <div class="mb-3">
                                        <label for="platform" class="form-label">Platform</label>
                                        <input type="text" class="form-control" id="platform" name="platform" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Kullanıcı Adı</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Şifre</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="login_link" class="form-label">Giriş Linki (Opsiyonel)</label>
                                        <input type="url" class="form-control" id="login_link" name="login_link">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="account_type" class="form-label">Hesap Türü</label>
                                        <select class="form-select" id="account_type" name="account_type" required>
                                            <option value="İnternet Bankacılığı">İnternet Bankacılığı</option>
                                            <option value="Mail">Mail</option>
                                            <option value="Sosyal Medya">Sosyal Medya</option>
                                            <option value="Bahis Sitesi">Bahis Sitesi</option>
                                            <option value="E-ticaret">E-ticaret</option>
                                            <option value="Eğitim">Eğitim</option>
                                            <option value="İş">İş</option>
                                            <option value="Diğer">Diğer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-primary">Ekle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Düzenle Modalı -->
                <div class="modal fade" id="duzenleModal" tabindex="-1" aria-labelledby="duzenleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="duzenleModalLabel">Hesap Düzenle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="duzenleForm">
                                <div class="modal-body">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="id" id="edit_id">
                                    
                                    <div class="mb-3">
                                        <label for="edit_platform" class="form-label">Platform</label>
                                        <input type="text" class="form-control" id="edit_platform" name="platform" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_username" class="form-label">Kullanıcı Adı</label>
                                        <input type="text" class="form-control" id="edit_username" name="username" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_password" class="form-label">Şifre</label>
                                        <input type="password" class="form-control" id="edit_password" name="password" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_login_link" class="form-label">Giriş Linki (Opsiyonel)</label>
                                        <input type="url" class="form-control" id="edit_login_link" name="login_link">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_account_type" class="form-label">Hesap Türü</label>
                                        <select class="form-select" id="edit_account_type" name="account_type" required>
                                            <option value="İnternet Bankacılığı">İnternet Bankacılığı</option>
                                            <option value="Mail">Mail</option>
                                            <option value="Sosyal Medya">Sosyal Medya</option>
                                            <option value="Bahis Sitesi">Bahis Sitesi</option>
                                            <option value="E-ticaret">E-ticaret</option>
                                            <option value="Eğitim">Eğitim</option>
                                            <option value="İş">İş</option>
                                            <option value="Diğer">Diğer</option>
                                        </select>
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
        </div>
    </div>
</div>

<?php require_once 'C:/xampp/htdocs/views/partials/script.php'; ?>



</body>