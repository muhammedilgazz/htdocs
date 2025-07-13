<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
require_once 'classes/Expense.php';
$security = new SecurityManager();
$security->checkSession();
include 'partials/head.php';
$db = Database::getInstance();
$expense_model = new Expense();
$rows = $expense_model->getAll('Alınacak Ürünler');
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
            'Alınacak Ürünler',
            'Satın alınacak ürünler ve istek listesi.',
            [
                ['link' => 'index.php', 'text' => 'Anasayfa'],
                ['text' => 'Alınacak Ürünler', 'active' => true]
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
                    'bi bi-cart-plus',
                    'Henüz ürün eklenmemiş',
                    'Alınacak ürünlerinizi ekleyerek takip etmeye başlayın.',
                    'İlk Ürünü Ekle',
                    '#harcamaEkleModal'
                );
                ?>
                <?php else: ?>
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Alınacak Ürünler</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#harcamaEkleModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i>Yeni Ürün Ekle
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">Sıra No</th>
                                        <th>Kategori</th>
                                        <th>Ürün/Hizmet</th>
                                        <th>Tutar</th>
                                        <th>Link</th>
                                        <th>Resim</th>
                                        <th>Açıklama</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= $row['sira'] ?> </td>
                                        <td> <?= htmlspecialchars($row['kategori']) ?> </td>
                                        <td> <?= htmlspecialchars($row['urun']) ?> </td>
                                        <td> ₺<?= number_format($row['tutar'], 0, ',', '.') ?> </td>
                                        <td>
                                            <?php if (!empty($row['link'])): ?>
                                                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            $image_link = '';
                                            if (!empty($row['aciklama']) && strpos($row['aciklama'], '; Resim: ') !== false) {
                                                $parts = explode('; Resim: ', $row['aciklama']);
                                                if (count($parts) > 1) {
                                                    $image_link = trim($parts[1]);
                                                }
                                            }
                                            ?>
                                            <?php if (!empty($image_link)): ?>
                                                <a href="<?= htmlspecialchars($image_link) ?>" target="_blank" class="btn btn-outline-info btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;" title="Resmi Görüntüle">
                                                    <i class="bi bi-image"></i>
                                                </a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td> 
                                            <?php 
                                            $description = $row['aciklama'] ?? '';
                                            if (!empty($description) && strpos($description, '; Resim: ') !== false) {
                                                $description = explode('; Resim: ', $description)[0];
                                            }
                                            echo htmlspecialchars($description ?: '-'); 
                                            ?> 
                                        </td>
                                        <td>
                                            <div class="position-relative" style="display:inline-block; width:120px;">
                                                <select class="form-select form-select-sm status-dropdown" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 2rem 0.3rem 0.5rem; min-width:100px; border:1px solid #e5e9f2; appearance:none;">
                                                    <option value="Beklemede" <?= $row['durum'] == 'Beklemede' ? 'selected' : '' ?>>Beklemede</option>
                                                    <option value="Devam Ediyor" <?= $row['durum'] == 'Devam Ediyor' ? 'selected' : '' ?>>Devam Ediyor</option>
                                                    <option value="Tamamlandı" <?= $row['durum'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                                    <option value="İptal Edildi" <?= $row['durum'] == 'İptal Edildi' ? 'selected' : '' ?>>İptal Edildi</option>
                                                </select>
                                                <i class="bi bi-caret-down-fill" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); pointer-events:none; color:#b0b8c9; font-size:1rem;"></i>
                                            </div>
                                        </td>
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
                
                <?php
                require_once 'classes/UIHelper.php';

                $add_modal_body = '';
                $add_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                $add_modal_body .= '<input type="hidden" name="kategori_tipi" value="Alınacak Ürünler">';
                $add_modal_body .= UIHelper::render_input('Kategori', 'kategori');
                $add_modal_body .= UIHelper::render_input('Ürün/Hizmet', 'urun');
                $add_modal_body .= UIHelper::render_input('Tutar (₺)', 'tutar', 'number', true, '', '', []);
                $add_modal_body .= UIHelper::render_input('Link (Opsiyonel)', 'link', 'url', false);
                $add_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'aciklama', 'textarea', false);
                $add_modal_body .= UIHelper::render_input('Durum', 'durum', 'select', true, 'Beklemede', '', [
                    ['value' => 'Beklemede', 'text' => 'Beklemede'],
                    ['value' => 'Devam Ediyor', 'text' => 'Devam Ediyor'],
                    ['value' => 'Tamamlandı', 'text' => 'Tamamlandı'],
                    ['value' => 'İptal Edildi', 'text' => 'İptal Edildi'],
                ]);

                $add_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
                $add_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

                echo UIHelper::render_modal('harcamaEkleModal', 'Yeni Ürün Ekle', 'harcamaEkleForm', $add_modal_body, $add_modal_footer);
                ?>
                
                <!-- Düzenle Modalı -->
                <?php
                $edit_modal_body = '';
                $edit_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                $edit_modal_body .= '<input type="hidden" name="id" id="edit_id">';
                $edit_modal_body .= '<input type="hidden" name="kategori_tipi" value="Alınacak Ürünler">';
                $edit_modal_body .= UIHelper::render_input('Kategori', 'edit_kategori');
                $edit_modal_body .= UIHelper::render_input('Ürün/Hizmet', 'edit_urun');
                $edit_modal_body .= UIHelper::render_input('Tutar (₺)', 'edit_tutar', 'number');
                $edit_modal_body .= UIHelper::render_input('Link (Opsiyonel)', 'edit_link', 'url', false);
                $edit_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'edit_aciklama', 'textarea', false);
                $edit_modal_body .= UIHelper::render_input('Durum', 'edit_durum', 'select', true, '', '', [
                    ['value' => 'Beklemede', 'text' => 'Beklemede'],
                    ['value' => 'Devam Ediyor', 'text' => 'Devam Ediyor'],
                    ['value' => 'Tamamlandı', 'text' => 'Tamamlandı'],
                    ['value' => 'İptal Edildi', 'text' => 'İptal Edildi'],
                ]);

                $edit_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
                $edit_modal_footer .= '<button type="submit" class="btn btn-primary">Güncelle</button>';

                echo UIHelper::render_modal('duzenleModal', 'Ürün Düzenle', 'duzenleForm', $edit_modal_body, $edit_modal_footer);
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/script.php'; ?>



</body> 