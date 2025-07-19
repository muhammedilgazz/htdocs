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
        $page_title = 'Bildirimler';
        $page_description = 'Sistem bildirimlerinizi takip edin.';
        $breadcrumb_active = 'Bildirimler';
        include ROOT_PATH . '/views/partials/page_header.php';
        ?>
        <div class="app-content">
            <div class="container py-3">
                <!-- Bildirim Filtreleri -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-primary btn-sm">Tümü</button>
                                    <button class="btn btn-outline-primary btn-sm">Önemli</button>
                                    <button class="btn btn-outline-primary btn-sm">Bütçe</button>
                                    <button class="btn btn-outline-primary btn-sm">Ödemeler</button>
                                    <button class="btn btn-outline-primary btn-sm">Sistem</button>
                                    <div class="ms-auto">
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i> Tümünü Temizle
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bildirimler Listesi -->
                <div class="card" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Son Bildirimler</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="notification-list">
                            <!-- Bildirim 1 -->
                            <div class="notification-item p-3 border-bottom" style="background:#fff;">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                            <i class="bi bi-exclamation-triangle text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Bütçe Uyarısı</h6>
                                                <p class="mb-1 text-muted">Bu ay harcama limitinizin %80'ine ulaştınız. Dikkatli olun!</p>
                                                <small class="text-muted">2 saat önce</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-text" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check me-2"></i>Okundu olarak işaretle</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i>Önemli olarak işaretle</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Sil</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bildirim 2 -->
                            <div class="notification-item p-3 border-bottom" style="background:#fff;">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                            <i class="bi bi-check-circle text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Ödeme Tamamlandı</h6>
                                                <p class="mb-1 text-muted">Kredi kartı ödemeniz başarıyla gerçekleşti. Tutar: ₺1,250</p>
                                                <small class="text-muted">1 gün önce</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-text" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check me-2"></i>Okundu olarak işaretle</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i>Önemli olarak işaretle</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Sil</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bildirim 3 -->
                            <div class="notification-item p-3 border-bottom" style="background:#fff;">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-2">
                                            <i class="bi bi-info-circle text-info"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Yeni Özellik</h6>
                                                <p class="mb-1 text-muted">Bütçe analiz raporları artık mevcut. Detaylı analizler için profilinizi ziyaret edin.</p>
                                                <small class="text-muted">3 gün önce</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-text" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check me-2"></i>Okundu olarak işaretle</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i>Önemli olarak işaretle</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Sil</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bildirim 4 -->
                            <div class="notification-item p-3 border-bottom" style="background:#fff;">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                            <i class="bi bi-x-circle text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Ödeme Hatası</h6>
                                                <p class="mb-1 text-muted">Fatura ödemenizde bir hata oluştu. Lütfen tekrar deneyin.</p>
                                                <small class="text-muted">5 gün önce</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-text" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check me-2"></i>Okundu olarak işaretle</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i>Önemli olarak işaretle</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Sil</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bildirim 5 -->
                            <div class="notification-item p-3" style="background:#fff;">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                            <i class="bi bi-bell text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">Hoş Geldiniz!</h6>
                                                <p class="mb-1 text-muted">Bütçe yönetim sistemine hoş geldiniz. İlk harcamanızı ekleyerek başlayın.</p>
                                                <small class="text-muted">1 hafta önce</small>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-text" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-check me-2"></i>Okundu olarak işaretle</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-star me-2"></i>Önemli olarak işaretle</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Sil</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sayfalama -->
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Bildirim sayfaları">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Önceki</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sonraki</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/views/partials/script.php'; ?>

</body>