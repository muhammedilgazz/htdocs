<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
require_once 'includes/auth_check.php';
require_once 'classes/UIHelper.php';
require_once 'classes/Expense.php';

$security = new SecurityManager();
$security->checkSession();
include 'partials/head.php';
$db = Database::getInstance();
$expense_model = new Expense();

// Seçili ayı al (varsayılan: Temmuz 2025)
$selected_month = $_SESSION['selected_month'] ?? '07.25';

// Seçili aya göre harcamaları filtrele
$rows = $db->fetchAll("SELECT * FROM harcama_kalemleri WHERE harcama_donemi = ? ORDER BY id DESC", [$selected_month]);

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
            'Harcamalar',
            'Tüm harcamalarınızı burada görüntüleyebilirsiniz.',
            [
                ['link' => 'index.php', 'text' => 'Anasayfa'],
                ['text' => 'Harcamalar', 'active' => true]
            ]
        );
        ?>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <div class="card mb-3" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); margin-top:1rem;">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center gap-2">
                            <div style="font-size:1.5rem; color:#ffb300;"><i class="bi bi-credit-card-2-front"></i></div>
                            <div>
                                <h2 class="mb-0" style="font-weight:700; color:#222; font-size:1.2rem;">Harcamalar</h2>
                                <div style="color:#6b7280; font-size:0.85rem;">Tüm harcamalarınızı burada görüntüleyebilirsiniz.</div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#harcamaEkleModal" style="background:#1f2e4e; border:none; font-size:0.9rem; padding:0.5rem 1rem;">
                                <i class="bi bi-plus-circle me-2"></i>Harcama Ekle
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Dashboard Kartları -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="card p-4 h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:0;">
                            <div style="font-size:1.05rem; color:#6b7a99; font-weight:600;">Toplam Giderler</div>
                            <div style="font-size:1.5rem; color:#1a2550; font-weight:700; margin:8px 0;">₺37.350</div>
                            <div class="d-flex justify-content-between align-items-center" style="font-size:1rem; color:#7b8ab8;">
                                <span>Harcama + Ödeme + Alınacak</span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-4 h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:0;">
                            <div style="font-size:1.05rem; color:#6b7a99; font-weight:600;">Harcama Kalemleri</div>
                            <div style="font-size:1.5rem; color:#1a2550; font-weight:700; margin:8px 0;">₺17.870</div>
                            <div class="d-flex justify-content-between align-items-center" style="font-size:1rem; color:#7b8ab8;">
                                <span>Toplam Kalem</span>
                                <span style="color:#2979ff; font-weight:700;">14 Adet</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-4 h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:0;">
                            <div style="font-size:1.05rem; color:#6b7a99; font-weight:600;">Borç Ödemeleri</div>
                            <div style="font-size:1.5rem; color:#1a2550; font-weight:700; margin:8px 0;">₺100</div>
                            <div class="d-flex justify-content-between align-items-center" style="font-size:1rem; color:#7b8ab8;">
                                <span>Kalan Borç</span>
                                <span style="color:#2979ff; font-weight:700;">3 Kişi</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-4 h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:0;">
                            <div style="font-size:1.05rem; color:#6b7a99; font-weight:600;">Alınacaklar</div>
                            <div style="font-size:1.5rem; color:#1a2550; font-weight:700; margin:8px 0;">₺19.380</div>
                            <div class="d-flex justify-content-between align-items-center" style="font-size:1rem; color:#7b8ab8;">
                                <span>Onaylanan</span>
                                <span style="color:#2979ff; font-weight:700;">6 Adet</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- İstatistik Kartları -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="stat-card d-flex align-items-center justify-content-center p-3 h-100 w-100" style="background:#fff; box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); min-height:70px; border-radius:0;">
                            <span style="font-size:1rem; color:#ffb300; font-weight:700; display:flex; align-items:center; gap:8px;">
                                <i class="bi bi-calculator" style="font-size:1.3rem;"></i> Toplam Harcama: ₺17.870
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card d-flex align-items-center justify-content-center p-3 h-100 w-100" style="background:#fff; box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); min-height:70px; border-radius:0;">
                            <span style="font-size:1rem; color:#2979ff; font-weight:700; display:flex; align-items:center; gap:8px;">
                                <i class="bi bi-arrow-repeat" style="font-size:1.3rem;"></i> Aylık Sabit Harcamalar: ₺0
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card d-flex align-items-center justify-content-center p-3 h-100 w-100" style="background:#fff; box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); min-height:70px; border-radius:0;">
                            <span style="font-size:1rem; color:#12A347; font-weight:700; display:flex; align-items:center; gap:8px;">
                                <i class="bi bi-cart-check" style="font-size:1.3rem;"></i> Tek Seferlik Harcamalar: ₺17.870
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Harcama Tablosu -->
                <?php if (empty($rows)): ?>
                    <?php 
                require_once 'partials/empty_state.php';
                generate_empty_state(
                    'bi bi-emoji-frown',
                    'Henüz harcama kaydı yok.',
                    ''
                );
                ?>
                <?php else: ?>
                    <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                        <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Harcama Kalemleri</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                    <thead style="background:#f5f7fa;">
                                        <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                            <th style="padding-left:1.5rem;">Sıra No</th>
                                            <th>Kategori</th>
                                            <th>Gider Türü</th>
                                            <th>Ürün/Hizmet</th>
                                            <th>Tutar</th>
                                            <th>Link</th>
                                            <th>Açıklama</th>
                                            <th>Durum</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($rows as $row): ?>
                                        <tr style="font-size:0.85rem;">
                                            <td style="padding-left:1.5rem;"><?= $row['sira'] ?></td>
                                            <td>
                                                <span class="badge" style="background:<?= $row['kategori']==='ödeme'?'#ffb300':'#e5e9f2'; ?>; color:<?= $row['kategori']==='ödeme'?'#fff':'#222'; ?>; font-weight:600; font-size:0.8rem; padding:0.4rem 0.6rem;">
                                                    <?= ucfirst($row['kategori']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge" style="background:<?= getKategoriTipiColor($row['kategori_tipi'] ?? 'Ani/Ekstra Harcama'); ?>; color:#fff; font-weight:600; font-size:0.6rem; padding:0.2rem 0.4rem;">
                                                    <?= getKategoriTipiShort($row['kategori_tipi'] ?? 'Ani/Ekstra Harcama') ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($row['urun']) ?></td>
                                            <td>
                                                <span style="color:#34c759; font-weight:700; font-size:0.95rem;">
                                                    ₺<?= number_format($row['tutar'], 0, ',', '.') ?>
                                                </span>
                                                <div style="font-size:0.75rem; color:#888; font-weight:500;">
                                                    <?= $row['tur'] ?? '' ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($row['link'])): ?>
                                                    <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($row['aciklama'] ?? '-') ?></td>
                                            <td>
                                                <div class="position-relative" style="display:inline-block; width:120px;">
                                                    <select class="form-select form-select-sm status-dropdown" 
                                                            data-id="<?= $row['id'] ?>" 
                                                            style="font-size:0.8rem; padding:0.3rem 2rem 0.3rem 0.5rem; min-width:100px; border:1px solid #e5e9f2; appearance:none;">
                                                        <option value="Beklemede" <?= $row['durum'] == 'Beklemede' ? 'selected' : '' ?>>Beklemede</option>
                                                        <option value="Devam Ediyor" <?= $row['durum'] == 'Devam Ediyor' ? 'selected' : '' ?>>Devam Ediyor</option>
                                                        <option value="Tamamlandı" <?= $row['durum'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                                        <option value="İptal Edildi" <?= $row['durum'] == 'İptal Edildi' ? 'selected' : '' ?>>İptal Edildi</option>
                                                        <option value="Ertelendi" <?= $row['durum'] == 'Ertelendi' ? 'selected' : '' ?>>Ertelendi</option>
                                                    </select>
                                                    <i class="bi bi-caret-down-fill" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); pointer-events:none; color:#b0b8c9; font-size:1rem;"></i>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-primary btn-sm" 
                                                            style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" 
                                                            title="Düzenle" type="button">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Sil" type="button" onclick="deleteItem(<?= $row['id'] ?>, 'harcama_kalemleri')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-warning btn-sm dropdown-toggle" 
                                                                style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" 
                                                                title="Ertele" type="button" 
                                                                data-bs-toggle="dropdown" 
                                                                aria-expanded="false">
                                                            <i class="bi bi-clock"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" style="font-size:0.8rem;">
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, '1')">1 Ay</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, '3')">3 Ay</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, '6')">6 Ay</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, '12')">1 Yıl</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, 'later')">Daha Sonra</a></li>
                                                        </ul>
                                                    </div>
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

<!-- Harcama Ekle Modal -->
<?php
$add_harcama_modal_body = '';
$add_harcama_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$add_harcama_modal_body .= UIHelper::render_input('Kategori', 'kategori', 'text', true, '', '', [
    ['value' => 'ödeme', 'text' => 'ödeme'],
    ['value' => 'abonelikler', 'text' => 'abonelikler'],
    ['value' => 'diğer', 'text' => 'diğer'],
]);
$add_harcama_modal_body .= UIHelper::render_input('Kategori Tipi', 'kategori_tipi', 'select', true, 'Sabit Giderler', '', [
    ['value' => 'Sabit Giderler', 'text' => 'Sabit Giderler'],
    ['value' => 'Değişken Giderler', 'text' => 'Değişken Giderler'],
    ['value' => 'Borç Ödemeleri', 'text' => 'Borç Ödemeleri'],
    ['value' => 'Alınacak Ürünler', 'text' => 'Alınacak Ürünler'],
    ['value' => 'Ani/Ekstra Harcama', 'text' => 'Ani/Ekstra Harcama'],
    ['value' => 'Ertelenen Ödemeler', 'text' => 'Ertelenen Ödemeler'],
]);
$add_harcama_modal_body .= UIHelper::render_input('Harcama Dönemi', 'harcama_donemi', 'select', true, $selected_month, '', [
    ['value' => '07.25', 'text' => 'Temmuz 2025'],
    ['value' => '08.25', 'text' => 'Ağustos 2025'],
    ['value' => '09.25', 'text' => 'Eylül 2025'],
]);
$add_harcama_modal_body .= UIHelper::render_input('Aylık / Tek Seferlik', 'tur', 'select', true, 'Aylık', '', [
    ['value' => 'Aylık', 'text' => 'Aylık'],
    ['value' => 'Tek Seferlik', 'text' => 'Tek Seferlik'],
]);
$add_harcama_modal_body .= UIHelper::render_input('Sıra No (Öncelik)', 'sira', 'number', true, '', '', [], 1);
$add_harcama_modal_body .= UIHelper::render_input('Ürün/Hizmet', 'urun');
$add_harcama_modal_body .= UIHelper::render_input('Tutar', 'tutar', 'number');
$add_harcama_modal_body .= UIHelper::render_input('Link', 'link', 'url', false);
$add_harcama_modal_body .= UIHelper::render_input('Açıklama', 'aciklama', 'textarea', false);
$add_harcama_modal_body .= UIHelper::render_input('Durum', 'durum', 'select', true, 'Beklemede', '', [
    ['value' => 'Beklemede', 'text' => 'Beklemede'],
    ['value' => 'Devam Ediyor', 'text' => 'Devam Ediyor'],
    ['value' => 'Tamamlandı', 'text' => 'Tamamlandı'],
    ['value' => 'İptal Edildi', 'text' => 'İptal Edildi'],
]);

$add_harcama_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>';
$add_harcama_modal_footer .= '<button type="submit" class="btn btn-primary">Kaydet</button>';

echo UIHelper::render_modal('harcamaEkleModal', 'Harcama Ekle', 'harcamaEkleForm', $add_harcama_modal_body, $add_harcama_modal_footer);
?>
<!-- Düzenle Modalı -->
<?php
$edit_harcama_modal_body = '';
$edit_harcama_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
$edit_harcama_modal_body .= '<input type="hidden" name="id" id="duzenle-id">';
$edit_harcama_modal_body .= UIHelper::render_input('Kategori', 'duzenle-kategori', 'text', true, '', '', [
    ['value' => 'ödeme', 'text' => 'ödeme'],
    ['value' => 'abonelikler', 'text' => 'abonelikler'],
    ['value' => 'diğer', 'text' => 'diğer'],
]);
$edit_harcama_modal_body .= UIHelper::render_input('Kategori Tipi', 'duzenle-kategori-tipi', 'select', true, '', '', [
    ['value' => 'Sabit Giderler', 'text' => 'Sabit Giderler'],
    ['value' => 'Değişken Giderler', 'text' => 'Değişken Giderler'],
    ['value' => 'Borç Ödemeleri', 'text' => 'Borç Ödemeleri'],
    ['value' => 'Alınacak Ürünler', 'text' => 'Alınacak Ürünler'],
    ['value' => 'Ani/Ekstra Harcama', 'text' => 'Ani/Ekstra Harcama'],
    ['value' => 'Ertelenen Ödemeler', 'text' => 'Ertelenen Ödemeler'],
]);
$edit_harcama_modal_body .= UIHelper::render_input('Harcama Dönemi', 'duzenle-harcama-donemi', 'select', true, '', '', [
    ['value' => '07.25', 'text' => 'Temmuz 2025'],
    ['value' => '08.25', 'text' => 'Ağustos 2025'],
    ['value' => '09.25', 'text' => 'Eylül 2025'],
]);
$edit_harcama_modal_body .= UIHelper::render_input('Aylık / Tek Seferlik', 'duzenle-tur', 'select', true, '', '', [
    ['value' => 'Aylık', 'text' => 'Aylık'],
    ['value' => 'Tek Seferlik', 'text' => 'Tek Seferlik'],
]);
$edit_harcama_modal_body .= UIHelper::render_input('Sıra No (Öncelik)', 'duzenle-sira', 'number', true, '', '', [], 1);
$edit_harcama_modal_body .= UIHelper::render_input('Ürün/Hizmet', 'duzenle-urun');
$edit_harcama_modal_body .= UIHelper::render_input('Tutar', 'duzenle-tutar', 'number');
$edit_harcama_modal_body .= UIHelper::render_input('Link', 'duzenle-link', 'url', false);
$edit_harcama_modal_body .= UIHelper::render_input('Açıklama', 'duzenle-aciklama', 'textarea', false);
$edit_harcama_modal_body .= UIHelper::render_input('Durum', 'duzenle-durum', 'select', true, '', '', [
    ['value' => 'Beklemede', 'text' => 'Beklemede'],
    ['value' => 'Devam Ediyor', 'text' => 'Devam Ediyor'],
    ['value' => 'Tamamlandı', 'text' => 'Tamamlandı'],
    ['value' => 'İptal Edildi', 'text' => 'İptal Edildi'],
]);

$edit_harcama_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>';
$edit_harcama_modal_footer .= '<button type="submit" class="btn btn-primary">Kaydet</button>';

echo UIHelper::render_modal('duzenleModal', 'Harcama Düzenle', 'duzenleForm', $edit_harcama_modal_body, $edit_harcama_modal_footer);
?>
<?php include 'partials/script.php'; ?>

