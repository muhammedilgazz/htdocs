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
        $page_title = 'Referans Programı';
        $page_description = 'Arkadaşlarınızı davet edin ve kazanç elde edin.';
        $breadcrumb_active = 'Referans Programı';
        include ROOT_PATH . '/views/partials/page_header.php';
        ?>
        <div class="app-content">
            <div class="container-fluid">
                <!-- İstatistik Kartları -->
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-body text-center">
                                <i class="bi bi-people" style="font-size:2.5rem; color:#4f8cff;"></i>
                                <h4 class="mt-2 mb-1">0</h4>
                                <p class="text-muted mb-0">Toplam Referans</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-body text-center">
                                <i class="bi bi-currency-dollar" style="font-size:2.5rem; color:#28a745;"></i>
                                <h4 class="mt-2 mb-1">₺0</h4>
                                <p class="text-muted mb-0">Toplam Kazanç</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-body text-center">
                                <i class="bi bi-percent" style="font-size:2.5rem; color:#ffc107;"></i>
                                <h4 class="mt-2 mb-1">%30</h4>
                                <p class="text-muted mb-0">Komisyon Oranı</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-body text-center">
                                <i class="bi bi-gift" style="font-size:2.5rem; color:#dc3545;"></i>
                                <h4 class="mt-2 mb-1">₺0</h4>
                                <p class="text-muted mb-0">Bekleyen Ödeme</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Referans Linki -->
                <div class="card mb-4" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Referans Linkiniz</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?= BASE_URL ?>ref/<?= $user_id ?>" readonly>
                                    <button class="btn btn-primary" type="button" onclick="copyReferralLink()">
                                        <i class="bi bi-clipboard"></i> Kopyala
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <button class="btn btn-success" onclick="shareReferralLink()">
                                    <i class="bi bi-share"></i> Paylaş
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Referans Listesi -->
                <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Referanslarınız</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead style="background:#f5f7fa;">
                                    <tr>
                                        <th>Kullanıcı</th>
                                        <th>Kayıt Tarihi</th>
                                        <th>Durum</th>
                                        <th>Kazanç</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bi bi-people" style="font-size:3rem; color:#ccc;"></i>
                                            <p class="mt-2 text-muted">Henüz referansınız bulunmuyor.</p>
                                            <p class="text-muted">Referans linkinizi paylaşarak arkadaşlarınızı davet edin!</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Program Kuralları -->
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                                <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Program Kuralları</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Her referans için %30 komisyon kazanırsınız
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Minimum ödeme tutarı: ₺50
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Ödemeler aylık olarak yapılır
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        Referanslarınızın aktif olması gerekir
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                                <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Nasıl Çalışır?</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px; height:30px; font-size:14px;">1</div>
                                    <div>
                                        <strong>Referans linkinizi paylaşın</strong><br>
                                        <small class="text-muted">Sosyal medya, e-posta veya mesajlaşma uygulamalarında</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px; height:30px; font-size:14px;">2</div>
                                    <div>
                                        <strong>Arkadaşlarınız kayıt olsun</strong><br>
                                        <small class="text-muted">Linkinizle gelen kullanıcılar sisteme kayıt olur</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px; height:30px; font-size:14px;">3</div>
                                    <div>
                                        <strong>Komisyon kazanın</strong><br>
                                        <small class="text-muted">Referanslarınızın işlemlerinden %30 komisyon alırsınız</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyReferralLink() {
    const linkInput = document.querySelector('input[readonly]');
    linkInput.select();
    document.execCommand('copy');
    
    // Toast mesajı göster
    if (typeof toastr !== 'undefined') {
        toastr.success('Referans linki kopyalandı!');
    } else {
        alert('Referans linki kopyalandı!');
    }
}

function shareReferralLink() {
    const link = document.querySelector('input[readonly]').value;
    
    if (navigator.share) {
        navigator.share({
            title: 'Bütçe Yönetim Sistemi',
            text: 'Bu harika bütçe yönetim sistemini deneyin!',
            url: link
        });
    } else {
        // Fallback: linki kopyala
        copyReferralLink();
    }
}
</script>

<?php require_once ROOT_PATH . '/views/partials/script.php'; ?>

</body>