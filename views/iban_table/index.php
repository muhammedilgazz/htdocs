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
            'IBAN Tablosu',
            'IBAN bilgilerini güvenli bir şekilde saklayın.',
            [
                ['link' => '/', 'text' => 'Anasayfa'],
                ['text' => 'IBAN Tablosu', 'active' => true]
            ]
        );
        ?>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addIbanModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                        <i class="bi bi-plus-circle me-1"></i>Yeni IBAN Ekle
                    </button>
                </div>

                <!-- Kendi Hesaplarım Tablosu -->
                <div class="card p-0 mb-4" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Kendi Hesaplarım</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($my_ibans)): ?>
                            <?php 
                            require_once 'C:/xampp/htdocs/views/partials/empty_state.php';
                            generate_empty_state(
                                'bi bi-bank',
                                'Henüz kendi IBAN kaydınız yok',
                                'Kendi IBAN bilgilerinizi ekleyerek takip etmeye başlayın.'
                            );
                            ?>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                    <thead style="background:#f5f7fa;">
                                        <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                            <th style="padding-left:1.5rem;">Banka Adı</th>
                                            <th>IBAN Numarası</th>
                                            <th>Kolay Adres</th>
                                            <th>Hesap Sahibi</th>
                                            <th>Açıklama</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($my_ibans as $iban): ?>
                                        <tr style="font-size:0.85rem;">
                                            <td style="padding-left:1.5rem;"> <?= htmlspecialchars($iban['bank_name']) ?> </td>
                                            <td> <?= htmlspecialchars($iban['iban_number']) ?> </td>
                                            <td> <?= htmlspecialchars($iban['easy_address'] ?? '-') ?> </td>
                                            <td> <?= htmlspecialchars($iban['account_holder']) ?> </td>
                                            <td> <?= htmlspecialchars($iban['description'] ?? '-') ?> </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $iban['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Düzenle" type="button">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $iban['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Sil" type="button" onclick="deleteItem(<?= $iban['id'] ?>, 'iban_details')">
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
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Diğer Hesaplar</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($other_ibans)): ?>
                            <?php 
                            require_once 'C:/xampp/htdocs/views/partials/empty_state.php';
                            generate_empty_state(
                                'bi bi-bank',
                                'Henüz diğer IBAN kaydınız yok',
                                'Diğer IBAN bilgilerini ekleyerek takip etmeye başlayın.'
                            );
                            ?>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                    <thead style="background:#f5f7fa;">
                                        <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                            <th style="padding-left:1.5rem;">Banka Adı</th>
                                            <th>IBAN Numarası</th>
                                            <th>Kolay Adres</th>
                                            <th>Hesap Sahibi</th>
                                            <th>Açıklama</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($other_ibans as $iban): ?>
                                        <tr style="font-size:0.85rem;">
                                            <td style="padding-left:1.5rem;"> <?= htmlspecialchars($iban['bank_name']) ?> </td>
                                            <td> <?= htmlspecialchars($iban['iban_number']) ?> </td>
                                            <td> <?= htmlspecialchars($iban['easy_address'] ?? '-') ?> </td>
                                            <td> <?= htmlspecialchars($iban['account_holder']) ?> </td>
                                            <td> <?= htmlspecialchars($iban['description'] ?? '-') ?> </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $iban['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Düzenle" type="button">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $iban['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Sil" type="button" onclick="deleteItem(<?= $iban['id'] ?>, 'iban_details')">
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

<?php require_once 'C:/xampp/htdocs/views/partials/script.php'; ?>



</body>