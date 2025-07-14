<?php
require_once 'C:/xampp/htdocs/views/partials/head.php';
?>
<body>
<div class="app-container">
    <?php require_once 'C:/xampp/htdocs/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once 'C:/xampp/htdocs/views/partials/header.php'; ?>
        <!-- Breadcrumb ve Başlık -->
        <div class="container-fluid py-1" style="background:#f7f9fb;">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;">Hayaller ve Hedefler</h2>
                    <div style="color:#7b8ab8; font-size:1rem;">Hayallerinizi ve hedeflerinizi takip edin.</div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background:transparent;">
                        <li class="breadcrumb-item"><a href="/" style="color:#7b8ab8; text-decoration:none;">Anasayfa</a></li>
                        <li class="breadcrumb-item"><a href="#" style="color:#7b8ab8; text-decoration:none;">Tüm Alınacaklar</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;">Hayaller ve Hedefler</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <!-- Boş Durum Kontrolü -->
                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz hayal/hedef kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Hayallerinizi ve hedeflerinizi ekleyerek takip etmeye başlayın.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHayalHedefModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 500;">
                        <i class="bi bi-plus-circle me-2"></i>İlk Hayal/Hedef Ekle
                    </button>
                </div>
                <?php else: ?>
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Hayaller ve Hedefler</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addHayalHedefModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-plus-circle me-1"></i>Yeni Hayal/Hedef Ekle
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">Hayal/Hedef</th>
                                        <th>Maliyet</th>
                                        <th>Link</th>
                                        <th>Açıklama</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= htmlspecialchars($row['goal_name']) ?> </td>
                                        <td> ₺<?= number_format($row['target_amount'], 0, ',', '.') ?> </td>
                                        <td>
                                            <?php if (!empty($row['link'])): ?>
                                                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td> <?= htmlspecialchars($row['description'] ?? '-') ?> </td>
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
                
                <!-- Harcama Ekle Modal -->
                <?php
                require_once 'C:/xampp/htdocs/models/UIHelper.php';

                $add_dream_goal_modal_body = '';
                $add_dream_goal_modal_body .= '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                $add_dream_goal_modal_body .= UIHelper::render_input('Başlık', 'goal_name');
                $add_dream_goal_modal_body .= UIHelper::render_input('Açıklama (Opsiyonel)', 'description', 'textarea', false);
                $add_dream_goal_modal_body .= UIHelper::render_input('Hedef Tutar (₺)', 'target_amount', 'number', true, '', '', [], 0.01);
                $add_dream_goal_modal_body .= UIHelper::render_input('Hedef Tarih (Opsiyonel)', 'target_date', 'date', false);

                $add_dream_goal_modal_footer = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>';
                $add_dream_goal_modal_footer .= '<button type="submit" class="btn btn-primary">Ekle</button>';

                echo UIHelper::render_modal('addHayalHedefModal', 'Yeni Hayal/Hedef Ekle', 'addHayalHedefForm', $add_dream_goal_modal_body, $add_dream_goal_modal_footer);
                ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'C:/xampp/htdocs/views/partials/script.php'; ?>



</body>