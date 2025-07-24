<aside class="sidebar">
    <div class="sidebar-header">
        <i class="material-icons-round" style="font-size: 32px;">account_balance_wallet</i>
        <div>
            <h5><?= APP_NAME ?></h5>
            <small>Finansal Takip</small>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php') ? 'active' : '' ?>">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#giderlerSubmenu" aria-expanded="false" aria-controls="giderlerSubmenu">
                    <div>
                        <i class="bi bi-wallet2"></i>
                        <span>Giderler</span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </a>
                <div class="collapse" id="giderlerSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/giderler?filter=month" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'giderler.php' && (!isset($_GET['filter']) || $_GET['filter'] == 'month')) ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-calendar2-week"></i>
                                <span>Bu Ay</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/giderler?filter=next_month" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'giderler.php' && isset($_GET['filter']) && $_GET['filter'] == 'next_month') ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-calendar-plus"></i>
                                <span>Gelecek Ay</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/giderler?filter=year" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'giderler.php' && isset($_GET['filter']) && $_GET['filter'] == 'year') ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-calendar3"></i>
                                <span>Bu Yıl</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/giderler?filter=all" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'giderler.php' && isset($_GET['filter']) && $_GET['filter'] == 'all') ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-infinity"></i>
                                <span>Tüm Zamanlar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Harcamalar Ana Menü -->
            <li class="nav-item">
                <a href="#" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#harcamalarSubmenu" aria-expanded="false" aria-controls="harcamalarSubmenu">
                    <div>
                        <i class="bi bi-credit-card-2-front"></i>
                        <span>Harcamalar</span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </a>
                <div class="collapse" id="harcamalarSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/expense" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'expense.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-list-ul"></i>
                                <span>Tüm Harcamalar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/fixedexpense" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'fixedexpense.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-calendar2-week"></i>
                                <span>Sabit Giderler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/variableexpense" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'variableexpense.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-bar-chart-line"></i>
                                <span>Değişken Giderler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/extraexpense" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'extraexpense.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-lightning-charge"></i>
                                <span>Ani/Ekstra Harcamalar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/postponedpayment" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'postponedpayment.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-clock-history"></i>
                                <span>Ertelenen Ödemeler</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Alınacaklar Ana Menü -->
            <li class="nav-item">
                <a href="#" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#alinacaklarSubmenu" aria-expanded="false" aria-controls="alinacaklarSubmenu">
                    <div>
                        <i class="bi bi-cart"></i>
                        <span>Alınacaklar</span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </a>
                <div class="collapse" id="alinacaklarSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/wishlist-all.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'wishlist-all.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-list-check"></i>
                                <span>Tüm Alınacaklar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/wishlist-ihtiyac.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'wishlist-ihtiyac.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-box-seam"></i>
                                <span>İhtiyaçlar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/wishlist-istek.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'wishlist-istek.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-heart"></i>
                                <span>İstekler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/wishlist-hayal.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'wishlist-hayal.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-stars"></i>
                                <span>Hayaller</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Favori Ürünler Ana Menü -->
            <li class="nav-item">
                <a href="/favorite-products" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/favorite-products') !== false ? 'active' : '' ?>">
                    <i class="bi bi-bookmark-star"></i>
                    <span>Favori Ürünler</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/market" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'market.php' ? 'active' : '' ?>">
                    <i class="bi bi-shop"></i>
                    <span>Market &amp; Gıda</span>
                </a>
            </li>
            
            <!-- Gelirler Ana Menü -->
            <li class="nav-item">
                <a href="#" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#gelirlerSubmenu" aria-expanded="false" aria-controls="gelirlerSubmenu">
                    <div>
                        <i class="bi bi-cash-stack"></i>
                        <span>Gelirler</span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </a>
                <div class="collapse" id="gelirlerSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/incomes" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/incomes') !== false && !strpos($_SERVER['REQUEST_URI'], '/fixed') && !strpos($_SERVER['REQUEST_URI'], '/extra') ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-list-ul"></i>
                                <span>Tüm Gelirler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/incomes/fixed" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/incomes/fixed') !== false ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-calendar2-week"></i>
                                <span>Sabit Gelirler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/incomes/extra" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/incomes/extra') !== false ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-lightning-charge"></i>
                                <span>Ekstra Gelirler</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Tüm Borçlar Ana Menü -->
            <li class="nav-item">
                <a href="#" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#borclarSubmenu" aria-expanded="false" aria-controls="borclarSubmenu">
                    <div>
                        <i class="bi bi-cash-coin"></i>
                        <span>Tüm Borçlar</span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </a>
                <div class="collapse" id="borclarSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/tax" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'tax.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-receipt"></i>
                                <span>Vergi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/sgk" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'sgk.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-shield-check"></i>
                                <span>SGK</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/bank" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'bank.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-bank"></i>
                                <span>Banka</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/execution" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'execution.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-exclamation-triangle"></i>
                                <span>İcralar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/individualdebt" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'individualdebt.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-people"></i>
                                <span>Şahıslara Borçlar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Yapılacaklar Ana Menü -->
            <li class="nav-item">
                <a href="#" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#yapilacaklarSubmenu" aria-expanded="false" aria-controls="yapilacaklarSubmenu">
                    <div>
                        <i class="bi bi-list-check"></i>
                        <span>Yapılacaklar</span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </a>
                <div class="collapse" id="yapilacaklarSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/project" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'project.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-kanban"></i>
                                <span>Projeler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/task" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'task.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-check-circle"></i>
                                <span>Görevler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/note" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'note.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-journal-text"></i>
                                <span>Notlar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/todolist" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'todolist.php' ? 'active' : '' ?>" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-check2-square"></i>
                                <span>To-Do List</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Kişisel Gelişim Ana Menü -->
            <li class="nav-item">
                <a href="#" class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#gelisimSubmenu" aria-expanded="false" aria-controls="gelisimSubmenu">
                    <div>
                        <i class="bi bi-person-lines-fill"></i>
                        <span>Kişisel Gelişim</span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 12px;"></i>
                </a>
                <div class="collapse" id="gelisimSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/ai-dunyasi" class="nav-link" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-cpu"></i>
                                <span>AI Dünyası</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/youtube" class="nav-link" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-youtube"></i>
                                <span>Youtube</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/egitimler" class="nav-link" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-journal-richtext"></i>
                                <span>Eğitimler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/arastirilacak-konular" class="nav-link" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-search"></i>
                                <span>Araştırılacak Konular</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/hukuk" class="nav-link" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-balance-scale"></i>
                                <span>Hukuk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/universite" class="nav-link" style="font-size: 14px; padding: 8px 16px;">
                                <i class="bi bi-mortarboard"></i>
                                <span>Üniversite</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Güvenlik ve Bilgiler -->
            <li class="nav-item">
                <a href="/accountpassword" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'accountpassword.php' ? 'active' : '' ?>">
                    <i class="bi bi-lock"></i>
                    <span>Hesaplar & Şifreler</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="/bankaccount" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'bankaccount.php' ? 'active' : '' ?>">
                    <i class="bi bi-bank"></i>
                    <span>Banka Hesapları</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="/xtremeai" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'xtremeai.php' ? 'active' : '' ?>">
                    <i class="bi bi-robot"></i>
                    <span>Xtreme AI</span>
                </a>
            </li>

        </ul>
        
        <hr class="my-3" style="border-color: rgba(255, 255, 255, 0.1);">
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/settings" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                    <i class="material-icons-round">settings</i>
                    <span>Ayarlar</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="/profile" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>">
                    <i class="material-icons-round">person</i>
                    <span>Profil</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="/support" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'support.php' ? 'active' : '' ?>">
                    <i class="material-icons-round">support_agent</i>
                    <span>Destek</span>
                </a>
            </li>
            
            
            <li class="nav-item">
                <a href="/signin?logout=1" class="nav-link" style="color: var(--md-error);">
                    <i class="material-icons-round">logout</i>
                    <span>Çıkış Yap</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>