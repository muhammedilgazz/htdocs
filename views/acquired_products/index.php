<?php require_once 'C:/xampp/htdocs/views/partials/head.php'; ?>

<body>
<div class="app-container">
    <?php require_once 'C:/xampp/htdocs/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once 'C:/xampp/htdocs/views/partials/header.php'; ?>
        <?php 
        require_once 'C:/xampp/htdocs/views/partials/page_header.php';
        generate_page_header(
            'Alınacak Ürünler',
            'Satın alınacak ürünler ve istek listesi.',
            [
                ['link' => '/', 'text' => 'Anasayfa'],
                ['text' => 'Alınacak Ürünler', 'active' => true]
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
                                        <th style="padding-left:1.5rem;">Kategori</th>
                                        <th>Ürün/Hizmet</th>
                                        <th>Tutar</th>
                                        <th>Link</th>
                                        <th>Resim</th>
                                        <th>Açıklama</th>
                                        <th>Alındı mı?</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= htmlspecialchars($row['category_name']) ?> </td>
                                        <td> <?= htmlspecialchars($row['item_name']) ?> </td>
                                        <td> ₺<?= number_format($row['price'], 0, ',', '.') ?> </td>
                                        <td>
                                            <?php if (!empty($row['link'])): ?>
                                                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['image_path'])): ?>
                                                <a href="<?= htmlspecialchars($row['image_path']) ?>" target="_blank" class="btn btn-outline-info btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;" title="Resmi Görüntüle">
                                                    <i class="bi bi-image"></i>
                                                </a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td> <?= htmlspecialchars($row['description'] ?: '-') ?> </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input will-get-switch" type="checkbox" role="switch" id="willGetSwitch_<?= $row['id'] ?>" data-id="<?= $row['id'] ?>" <?= $row['will_get'] ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="willGetSwitch_<?= $row['id'] ?>"></label>
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
                require_once 'C:/xampp/htdocs/models/UIHelper.php';

                $add_modal_body = '';
                $add_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                $add_modal_body .= UIHelper::render_input('Kategori', 'category_name');
                $add_modal_body .= UIHelper::render_input('Ürün/Hizmet', 'item_name');
                $add_modal_body .= UIHelper::render_input('Tutar (₺)', 'price', 'number', true, '', '', []);
                $add_modal_body .= UIHelper::render_input('Link (Opsiyonel)', 'link', 'url', false);
                $add_modal_body .= UIHelper::render_input('Resim Linki (Opsiyonel)', 'image_path', 'url', false);
                $add_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'description', 'textarea', false);

                $add_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
                $add_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

                echo UIHelper::render_modal('harcamaEkleModal', 'Yeni Ürün Ekle', 'harcamaEkleForm', $add_modal_body, $add_modal_footer);
                ?>
                
                <!-- Düzenle Modalı -->
                <?php
                $edit_modal_body = '';
                $edit_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                $edit_modal_body .= '<input type="hidden" name="id" id="edit_id">';
                $edit_modal_body .= UIHelper::render_input('Kategori', 'edit_category_name');
                $edit_modal_body .= UIHelper::render_input('Ürün/Hizmet', 'edit_item_name');
                $edit_modal_body .= UIHelper::render_input('Tutar (₺)', 'edit_price', 'number');
                $edit_modal_body .= UIHelper::render_input('Link (Opsiyonel)', 'edit_link', 'url', false);
                $edit_modal_body .= UIHelper::render_input('Resim Linki (Opsiyonel)', 'edit_image_path', 'url', false);
                $edit_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'edit_description', 'textarea', false);

                $edit_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
                $edit_modal_footer .= '<button type="submit" class="btn btn-primary">Güncelle</button>';

                echo UIHelper::render_modal('duzenleModal', 'Ürün Düzenle', 'duzenleForm', $edit_modal_body, $edit_modal_footer);
                ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'C:/xampp/htdocs/views/partials/script.php'; ?>



</body>