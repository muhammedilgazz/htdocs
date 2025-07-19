<?php
require_once ROOT_PATH . '/views/partials/head.php';
?>
<body>
<div class="app-container">
    <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
        <!-- Breadcrumb ve Başlık -->
        <?php
        $page_title = 'Destek Merkezi';
        $page_description = 'Sorularınız için destek ekibimizle iletişime geçin.';
        $breadcrumb_active = 'Destek';
        include ROOT_PATH . '/views/partials/page_header.php';
        ?>
        <div class="app-content">
            <div class="container py-3">
                <!-- Destek Kartları -->
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-body text-center">
                                <i class="bi bi-headset" style="font-size:3rem; color:#4f8cff;"></i>
                                <h5 class="card-title mt-3">Canlı Destek</h5>
                                <p class="card-text">Anında yardım için canlı destek ekibimizle görüşün.</p>
                                <a href="#" class="btn btn-primary">Başlat</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-body text-center">
                                <i class="bi bi-ticket-detailed" style="font-size:3rem; color:#4f8cff;"></i>
                                <h5 class="card-title mt-3">Destek Talebi</h5>
                                <p class="card-text">Yeni bir destek talebi oluşturun.</p>
                                <a href="/support-create-ticket" class="btn btn-primary">Oluştur</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-body text-center">
                                <i class="bi bi-question-circle" style="font-size:3rem; color:#4f8cff;"></i>
                                <h5 class="card-title mt-3">SSS</h5>
                                <p class="card-text">Sık sorulan sorular ve yanıtları.</p>
                                <a href="#" class="btn btn-primary">Görüntüle</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mevcut Destek Talepleri -->
                <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Mevcut Destek Talepleriniz</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead style="background:#f5f7fa;">
                                    <tr>
                                        <th>Talep No</th>
                                        <th>Konu</th>
                                        <th>Durum</th>
                                        <th>Tarih</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-inbox" style="font-size:3rem; color:#ccc;"></i>
                                            <p class="mt-2 text-muted">Henüz destek talebiniz bulunmuyor.</p>
                                            <a href="/support-create-ticket" class="btn btn-primary btn-sm">İlk Talebinizi Oluşturun</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- İletişim Bilgileri -->
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                                <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">İletişim Bilgileri</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-envelope me-3" style="color:#4f8cff;"></i>
                                    <div>
                                        <strong>E-posta:</strong><br>
                                        <a href="mailto:support@example.com">support@example.com</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-telephone me-3" style="color:#4f8cff;"></i>
                                    <div>
                                        <strong>Telefon:</strong><br>
                                        <a href="tel:+901234567890">+90 123 456 7890</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock me-3" style="color:#4f8cff;"></i>
                                    <div>
                                        <strong>Çalışma Saatleri:</strong><br>
                                        Pazartesi - Cuma: 09:00 - 18:00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                                <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Hızlı Yardım</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <i class="bi bi-question-circle me-3" style="color:#4f8cff;"></i>
                                        Hesap nasıl oluşturulur?
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <i class="bi bi-question-circle me-3" style="color:#4f8cff;"></i>
                                        Şifremi unuttum, ne yapmalıyım?
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <i class="bi bi-question-circle me-3" style="color:#4f8cff;"></i>
                                        Harcama nasıl eklenir?
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <i class="bi bi-question-circle me-3" style="color:#4f8cff;"></i>
                                        Raporlar nasıl görüntülenir?
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/views/partials/script.php'; ?>

</body>