<header class="app-header">
    <div class="header-left">
        <!-- Month Selector -->
        <div class="dropdown me-2">
            <button class="btn btn-outline-primary ripple" data-bs-toggle="dropdown" style="min-width: 120px; white-space: nowrap; font-size: 0.875rem;">
                <i class="material-icons-round me-2">calendar_month</i>
                <span id="selectedMonth">Temmuz 2025</span>
                <i class="material-icons-round ms-1">expand_more</i>
            </button>
            <ul class="dropdown-menu">
                <li><h6 class="dropdown-header">Harcama Dönemi Seçin</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item month-selector" href="#" data-month="07.25">
                        Temmuz 2025
                        <span class="badge bg-primary ms-2" style="font-size: 0.7rem;">Mevcut</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item month-selector" href="#" data-month="08.25">
                        Ağustos 2025
                    </a>
                </li>
                <li>
                    <a class="dropdown-item month-selector" href="#" data-month="09.25">
                        Eylül 2025
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Ekle Dropdown -->
        <div class="dropdown me-1">
            <button class="btn btn-text ripple" data-bs-toggle="dropdown" style="font-size: 0.875rem;">
                <i class="material-icons-round">add</i>
                <span class="d-none d-lg-inline ms-1">Ekle</span>
            </button>
            <ul class="dropdown-menu quick-actions-menu">
                <li><h6 class="dropdown-header">Yeni Kayıt Ekle</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addIhtiyacModal">
                        <i class="material-icons-round me-3">list_alt</i>
                        <div>
                            <h6 class="mb-1">İhtiyaç Ekle</h6>
                            <small class="text-muted">Yeni ihtiyaç kaydı ekle</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addIbanModal">
                        <i class="material-icons-round me-3">account_balance</i>
                        <div>
                            <h6 class="mb-1">İban Ekle</h6>
                            <small class="text-muted">Yeni IBAN kaydı ekle</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addHesapModal">
                        <i class="material-icons-round me-3">lock</i>
                        <div>
                            <h6 class="mb-1">Hesap Ekle</h6>
                            <small class="text-muted">Yeni hesap şifresi ekle</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addHayalHedefModal">
                        <i class="material-icons-round me-3">star</i>
                        <div>
                            <h6 class="mb-1">Hayal/Hedef Ekle</h6>
                            <small class="text-muted">Yeni hayal veya hedef ekle</small>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Quick Actions -->
        <div class="dropdown me-1">
            <button class="btn btn-text ripple" data-bs-toggle="dropdown" style="white-space: nowrap; font-size: 0.875rem;">
                <i class="material-icons-round">add_circle</i>
                <span class="d-none d-lg-inline ms-1">Hızlı İşlemler</span>
            </button>
            <ul class="dropdown-menu quick-actions-menu">
                <li><h6 class="dropdown-header">Hızlı İşlemler</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                        <i class="material-icons-round me-3">remove_circle</i>
                        <div>
                            <h6 class="mb-1">Harcama Gir</h6>
                            <small class="text-muted">Yeni harcama kaydı ekle</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="material-icons-round me-3">note_add</i>
                        <div>
                            <h6 class="mb-1">Not Gir</h6>
                            <small class="text-muted">Hızlı not ekle</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addTodoModal">
                        <i class="material-icons-round me-3">check_circle_outline</i>
                        <div>
                            <h6 class="mb-1">To-Do Gir</h6>
                            <small class="text-muted">Yeni görev ekle</small>
                        </div>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
                        <i class="material-icons-round me-3">add_circle</i>
                        <div>
                            <h6 class="mb-1">Gelir Ekle</h6>
                            <small class="text-muted">Yeni gelir kaydı</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                        <i class="material-icons-round me-3">remove_circle</i>
                        <div>
                            <h6 class="mb-1">Gider Ekle</h6>
                            <small class="text-muted">Yeni gider kaydı</small>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Rapor Oluştur Dropdown -->
        <div class="dropdown">
            <button class="btn btn-text ripple" data-bs-toggle="dropdown" style="white-space: nowrap; font-size: 0.875rem;">
                <i class="material-icons-round">description</i>
                <span class="d-none d-lg-inline ms-1">Rapor Oluştur</span>
            </button>
            <ul class="dropdown-menu quick-actions-menu">
                <li><h6 class="dropdown-header">Rapor Oluştur</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="/report">
                        <i class="material-icons-round me-3">calendar_month</i>
                        <div>
                            <h6 class="mb-1">Aylık Ödeme Raporu</h6>
                            <small class="text-muted">Aylık ödemelerin raporu</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#shoppingListReportModal">
                        <i class="material-icons-round me-3">list_alt</i>
                        <div>
                            <h6 class="mb-1">Alınacaklar Listesi</h6>
                            <small class="text-muted">Alınacaklar raporu</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#goalsReportModal">
                        <i class="material-icons-round me-3">flag</i>
                        <div>
                            <h6 class="mb-1">Hedefler Raporu</h6>
                            <small class="text-muted">Hedeflerin raporu</small>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#yearlyReportModal">
                        <i class="material-icons-round me-3">bar_chart</i>
                        <div>
                            <h6 class="mb-1">Yıllık Rapor</h6>
                            <small class="text-muted">Yıllık finansal rapor</small>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="header-right">
        <!-- Döviz Kuru Widget -->
        <div class="exchange-rate-widget me-2" style="display: flex; align-items: center; background: rgba(255,255,255,0.1); padding: 0.4rem 0.6rem; border-radius: 6px; border: 1px solid rgba(255,255,255,0.2); max-width: 80px; min-width:60px;">
            <div style="display: flex; align-items: center; gap: 0.3rem;">
                <span style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px; background: #12A347; border-radius: 50%;"><i class="material-icons-round" style="font-size: 1rem; color: #fff;">attach_money</i></span>
                <div style="text-align: right;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #12A347; line-height: 1;">
                        <span id="usd-rate">32.50</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Xtreme AI Button -->
        <a href="/xtremeai" class="btn btn-text ripple me-1" title="Xtreme AI">
            <i class="material-icons-round" style="color: #6366F1;">smart_toy</i>
            
        </a>
        
        <!-- Notifications -->
        <div class="dropdown">
            <button class="btn btn-text position-relative ripple" data-bs-toggle="dropdown">
                <i class="material-icons-round">notifications</i>
                <span class="notify position-absolute top-0 start-100 translate-middle badge badge-danger">
                    3
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="width: 320px;">
                <li><h6 class="dropdown-header">Bildirimler</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                    <i class="material-icons-round text-warning">warning</i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Bütçe Uyarısı</h6>
                                <p class="mb-1 small">Bu ay harcama limitinizin %80'ine ulaştınız.</p>
                                <small class="text-muted">2 saat önce</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                    <i class="material-icons-round text-success">check_circle</i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Ödeme Tamamlandı</h6>
                                <p class="mb-1 small">Kredi kartı ödemeniz başarıyla gerçekleşti.</p>
                                <small class="text-muted">1 gün önce</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 rounded-circle p-2">
                                    <i class="material-icons-round text-info">info</i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Yeni Özellik</h6>
                                <p class="mb-1 small">Bütçe analiz raporları artık mevcut.</p>
                                <small class="text-muted">3 gün önce</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center" href="/notifications">Tüm Bildirimleri Gör</a></li>
            </ul>
        </div>
        
        <!-- User Menu -->
        <div class="dropdown user-menu">
            <button class="btn btn-text d-flex align-items-center ripple" data-bs-toggle="dropdown" style="white-space: nowrap;">
                <div class="user-avatar me-2">
                    <?= strtoupper(substr($_SESSION['full_name'] ?? 'U', 0, 1)) ?>
                </div>
                <span class="d-none d-lg-block" style="font-size: 0.875rem;"><?= $_SESSION['full_name'] ?? 'Kullanıcı' ?></span>
                <i class="material-icons-round ms-1">expand_more</i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">Hesap</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/profile"><i class="material-icons-round me-2">person</i>Profil</a></li>
                <li><a class="dropdown-item" href="/settings"><i class="material-icons-round me-2">settings</i>Ayarlar</a></li>
                <li><a class="dropdown-item" href="/privacy"><i class="material-icons-round me-2">security</i>Gizlilik</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/support"><i class="material-icons-round me-2">support_agent</i>Destek</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="signin.php?logout=1"><i class="material-icons-round me-2">logout</i>Çıkış Yap</a></li>
            </ul>
        </div>
    </div>
</header>