<?php
require_once __DIR__ . '/partials/head.php';
?>

<link rel="stylesheet" href="/assets/css/dashboard.css">

<body>
    <div class="app-container">
        <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

        <div class="app-main">
            <?php require_once __DIR__ . '/partials/header.php'; ?>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="h3 mb-0 text-gradient">Aylık Finansal Rapor</h1>
                                    <p class="text-muted mb-0">Bu sayfa, seçili dönem için özet finansal raporunuzu sunar.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Borçlar (Şahıslara) -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <span class="me-2">📌</span> Borçlar (Şahıslara)
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kişi / Kurum</th>
                                            <th>IBAN</th>
                                            <th>Tutar (₺)</th>
                                            <th>Açıklama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Umut</td><td>—</td><td>2.000</td><td>Şahsi borç</td></tr>
                                        <tr><td>Şenay Teyze</td><td>—</td><td>1.000</td><td>Aile borcu</td></tr>
                                        <tr><td>Yunus Abi</td><td>—</td><td>500</td><td>Tanıdık borcu</td></tr>
                                        <tr><td>Serdar</td><td>—</td><td>2.000</td><td>Şahsi borç</td></tr>
                                        <tr><td>Yılmaz</td><td>—</td><td>1.250</td><td>Şahsi borç</td></tr>
                                        <tr><td>Teyze</td><td>—</td><td>1.000</td><td>Aile borcu</td></tr>
                                        <tr class="fw-bold table-secondary"><td>Toplam</td><td></td><td>7.750</td><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Ödemeler (Ev Girişi) -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <span class="me-2">💳</span> Ödemeler (Ev Girişi)
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Başlık</th>
                                            <th>Tutar (₺)</th>
                                            <th>Ödeme Yöntemi</th>
                                            <th>IBAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Kira (1 Ay)</td><td>24.000</td><td>Elden / Havale</td><td>—</td></tr>
                                        <tr><td>Emlak Komisyonu</td><td>34.560</td><td>Elden / Havale</td><td>—</td></tr>
                                        <tr><td>Depozito</td><td>24.000</td><td>Elden / Havale</td><td>—</td></tr>
                                        <tr class="fw-bold table-secondary"><td>Toplam</td><td>82.560</td><td></td><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Sabit Giderler -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <span class="me-2">💸</span> Sabit Giderler
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Başlık</th>
                                            <th>Tutar (₺)</th>
                                            <th>Kategori</th>
                                            <th>Açıklama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Kira (1 Ay)</td><td>24.000</td><td>Ev Gideri</td><td>—</td></tr>
                                        <tr><td>Emlak Komisyonu</td><td>34.560</td><td>Ev Gideri</td><td>—</td></tr>
                                        <tr><td>Depozito</td><td>24.000</td><td>Ev Gideri</td><td>—</td></tr>
                                        <tr class="fw-bold table-secondary"><td>Toplam</td><td>82.560</td><td></td><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Harcamalar (Abonelik ve Kişisel İhtiyaçlar) -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <span class="me-2">🧾</span> Harcamalar (Abonelik ve Kişisel İhtiyaçlar)
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Başlık</th>
                                            <th>Tutar (₺)</th>
                                            <th>Kategori</th>
                                            <th>Açıklama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>ChatGPT</td><td>700</td><td>Abonelik</td><td>ChatGPT Plus</td></tr>
                                        <tr><td>Tinder Platinum</td><td>700</td><td>Abonelik</td><td>—</td></tr>
                                        <tr><td>Notion AI</td><td>680</td><td>Abonelik</td><td>20 USD tahmini</td></tr>
                                        <tr><td>YouTube Premium</td><td>150</td><td>Abonelik</td><td>—</td></tr>
                                        <tr><td>Google One</td><td>249</td><td>Abonelik</td><td>—</td></tr>
                                        <tr><td>Tıraş Bıçağı</td><td>100</td><td>İhtiyaç</td><td>—</td></tr>
                                        <tr><td>Tıraş Makinesi Tarağı</td><td>150</td><td>İhtiyaç</td><td>—</td></tr>
                                        <tr><td>Saç Spreyi</td><td>80</td><td>İhtiyaç</td><td>—</td></tr>
                                        <tr><td>Permatik</td><td>50</td><td>İhtiyaç</td><td>—</td></tr>
                                        <tr><td>Signo Uniball Kalem</td><td>60</td><td>Eşya</td><td>Not alma</td></tr>
                                        <tr class="fw-bold table-secondary"><td>Toplam</td><td>2.819</td><td></td><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Alınacaklar (Planlı Harcamalar) -->
                    <div class="card mb-4">
                        <div class="card-header bg-alinacaklar">
                            <span class="me-2">📦</span> Alınacaklar (Planlı Harcamalar)
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Ürün / Hedef</th>
                                            <th>Kategori</th>
                                            <th>Tahmini Tutar (₺)</th>
                                            <th>Öncelik (1-5)</th>
                                            <th>Açıklama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Tıraş Bıçağı</td><td>İhtiyaç</td><td>100</td><td>4</td><td>Kişisel bakım</td></tr>
                                        <tr><td>Tıraş Makinesi Tarağı</td><td>İhtiyaç</td><td>150</td><td>3</td><td>Eksik parça</td></tr>
                                        <tr><td>Saç Spreyi</td><td>İhtiyaç</td><td>80</td><td>5</td><td>Günlük kullanım</td></tr>
                                        <tr><td>Permatik</td><td>İhtiyaç</td><td>50</td><td>2</td><td>Tıraş sonrası</td></tr>
                                        <tr><td>Signo Uniball Kalem</td><td>Eşya</td><td>60</td><td>1</td><td>Not alma</td></tr>
                                        <tr class="fw-bold table-secondary"><td>Toplam</td><td>440</td><td></td><td></td><td></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Alışveriş (Market / Gıda) -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <span class="me-2">🛒</span> Alışveriş (Market / Gıda)
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tarih</th>
                                            <th>Ürün / Harcama</th>
                                            <th>Tutar (₺)</th>
                                            <th>Market / Yer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>—</td><td>—</td><td>—</td><td>—</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Planlama Özeti -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <span class="me-2">📊</span> Planlama Özeti
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><strong>Planlanan Aylık Gelir:</strong></span>
                                    <span class="fw-bold text-success">88.636,51 ₺</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><strong>Planlanan Gider:</strong></span>
                                    <span class="fw-bold text-danger">93.129 ₺</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><strong>Aylık Açık:</strong></span>
                                    <span class="fw-bold text-warning">–4.492,49 ₺</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body> 