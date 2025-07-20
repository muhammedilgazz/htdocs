<?php require_once ROOT_PATH . '/views/partials/head.php'; ?>
<body>
<div class="app-container">
    <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
    <div class="app-main">
        <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <?php
                        $page_title = 'Ayarlar';
                        $page_description = 'Hesap ve uygulama ayarlarınızı yönetin.';
                        $breadcrumb_active = 'Ayarlar';
                        include ROOT_PATH . '/views/partials/page_header.php';
                        ?>
                    </div>
                </div>

                <div class="settings-menu-container mb-4">
                     <a href="/settings" class="settings-menu-item active">Hesap</a>
                     <a href="/settings-general" class="settings-menu-item">Genel</a>
                     <a href="/settings-profile" class="settings-menu-item">Profil</a>
                     <a href="/settings-bank" class="settings-menu-item">Banka Ekle</a>
                     <a href="/settings-security" class="settings-menu-item">Güvenlik</a>
                     <a href="/settings-session" class="settings-menu-item">Oturum</a>
                     <a href="/settings-categories" class="settings-menu-item">Kategoriler</a>
                     <a href="/settings-currencies" class="settings-menu-item">Para Birimleri</a>
                     <a href="/settings-api" class="settings-menu-item">API</a>
                     <a href="/support" class="settings-menu-item">Destek</a>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="welcome-profile">
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/avatar/3.jpg" alt="" class="rounded-circle" width="60">
                                        <div class="ms-3">
                                            <h5 class="mb-0">Hoş Geldiniz, Hafsa Humaira!</h5>
                                            <p class="text-muted mb-0">Ekash'ın tüm potansiyelini kullanmak için hesabınızı doğrulayın.</p>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled mt-3 mb-0">
                                        <li><a href="#"><i class="fi fi-bs-check me-2"></i>Hesabı Doğrula</a></li>
                                        <li><a href="#"><i class="fi fi-rs-shield-check me-2"></i>İki Faktörlü Kimlik Doğrulama (2FA)</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Uygulamayı İndir</h5>
                            </div>
                            <div class="card-body">
                                <div class="app-link text-center">
                                    <h6>Mobil Uygulamamızda Doğrulama Yapın</h6>
                                    <p class="text-muted">Kimliğinizi mobil uygulamamızda doğrulamak daha güvenli ve hızlıdır.</p>
                                    <a href="#" class="btn btn-dark"><img src="assets/images/android.svg" alt="Google Play" height="24"></a>
                                    <a href="#" class="btn btn-dark ms-2"><img src="assets/images/apple.svg" alt="App Store" height="24"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">DOĞRULA & YÜKSELT</h5>
                            </div>
                            <div class="card-body">
                                <h6>Hesap Durumu: <span class="text-warning">Beklemede</span></h6>
                                <p class="text-muted">Hesabınız doğrulanmamış. Para yatırma, işlem yapma ve para çekme işlemlerini etkinleştirmek için doğrulama yapın.</p>
                                <a href="#" class="btn btn-primary">Doğrulama Yap</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">%30 Komisyon Kazanın</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Arkadaşlarınızı davet edin ve onların işlem ücretlerinden %30 kazanın.</p>
                                <a href="/affiliate" class="btn btn-primary">Referans Programı</a>
                            </div>
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Genel Ayarlar</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Dil</label>
                                            <select class="form-select">
                                                <option value="tr">Türkçe</option>
                                                <option value="en">English</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Para Birimi</label>
                                            <select class="form-select">
                                                <option value="TRY">Türk Lirası (₺)</option>
                                                <option value="USD">ABD Doları ($)</option>
                                                <option value="EUR">Euro (€)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <h6 class="form-label">Tema</h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="themeSwitch">
                                                <label class="form-check-label" for="themeSwitch">Karanlık Mod</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                             <h6 class="mt-3">Bildirim Ayarları</h6>
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                                 <label class="form-check-label" for="emailNotifications">E-posta Bildirimleri</label>
                                             </div>
                                             <div class="form-check">
                                                 <input class="form-check-input" type="checkbox" id="pushNotifications">
                                                 <label class="form-check-label" for="pushNotifications">Anlık Bildirimler</label>
                                             </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">Ayarları Kaydet</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once ROOT_PATH . '/views/partials/footer.php'; ?>
    </div>
</div>

<?php require_once ROOT_PATH . '/views/partials/script.php'; ?>

</body>
</html>