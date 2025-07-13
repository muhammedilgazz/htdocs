<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
require_once 'classes/Account.php';
$security = new SecurityManager();
$security->checkSession();
include 'partials/head.php';
$db = Database::getInstance();
$account_model = new Account();

// Hesaplar ve şifreleri al
$rows = $account_model->getAll();
$csrf_token = generate_csrf_token();
?>
<body>
<div class="app-container">
    <?php include 'partials/sidebar.php'; ?>
    <div class="app-main">
        <?php include 'partials/header.php'; ?>
        <?php 
        require_once 'partials/page_header.php';
        generate_page_header(
            'Hesaplar & Şifreler',
            'Hesap ve şifre yönetimi.',
            [
                ['link' => 'index.php', 'text' => 'Anasayfa'],
                ['text' => 'Hesaplar & Şifreler', 'active' => true]
            ]
        );
        ?>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <!-- Boş Durum Kontrolü -->
                <?php if (empty($rows)): ?>
                <?php 
                require_once 'partials/empty_state.php';
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
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= $row['id'] ?> </td>
                                        <td> <?= htmlspecialchars($row['platform']) ?> </td>
                                        <td> <?= htmlspecialchars($row['kullanici_adi']) ?> </td>
                                        <td>
                                            <div class="input-group" style="max-width: 150px;">
                                                <input type="password" class="form-control form-control-sm" value="<?= htmlspecialchars($row['sifre'] ?? '') ?>" readonly style="font-size: 0.8rem;">
                                                <button class="btn btn-outline-secondary btn-sm toggle-password" type="button" style="font-size: 0.8rem;">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background:#96ceb4; color:#fff; font-weight:600; font-size:0.6rem; padding:0.2rem 0.4rem;">
                                                <?= htmlspecialchars($row['hesap_turu']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['giris_linki'])): ?>
                                                <a href="<?= htmlspecialchars($row['giris_linki']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
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

<?php include 'partials/script.php'; ?>



</body> 