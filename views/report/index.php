<?php
require_once __DIR__ . '/../partials/head.php';
$month_names = [1=>'Ocak',2=>'Şubat',3=>'Mart',4=>'Nisan',5=>'Mayıs',6=>'Haziran',7=>'Temmuz',8=>'Ağustos',9=>'Eylül',10=>'Ekim',11=>'Kasım',12=>'Aralık'];
$report_month_name = $report_month ? $month_names[$report_month] : '';
$report_period_text = ($report_month_name ? $report_month_name : '') . ' ' . ($report_year ?? '');
?>

<link rel="stylesheet" href="/assets/css/dashboard.css">
<style>
.report-hero {
    background: #18122B url('https://t4.ftcdn.net/jpg/04/35/31/47/360_F_435314769_TXsKQ6aQfoHMZJfGcXtaXhyoY7iHK3ld.jpg') right bottom no-repeat;
    background-size: auto 100%;
    color: #fff;
    border-radius: 18px;
    padding: 2.5rem 2rem 2rem 2rem;
    margin-bottom: 2.5rem;
    display: flex;
    align-items: stretch;
    justify-content: flex-start;
    gap: 2rem;
    box-shadow: 0 4px 24px 0 rgba(24,18,43,0.08);
    position: relative;
    overflow: hidden;
}
.report-hero::before {
    content: '';
    position: absolute;
    left: 0; top: 0; right: 0; bottom: 0;
    border-radius: 18px;
    background: linear-gradient(90deg, rgba(24,18,43,0.92) 55%, rgba(24,18,43,0.5) 85%, rgba(24,18,43,0.0) 100%);
    z-index: 1;
    pointer-events: none;
}
.report-hero-left {
    min-width: 260px;
    max-width: 320px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.report-hero-income-label {
    font-size: 1.1rem;
    letter-spacing: 1px;
    color: #bdbdbd;
    margin-bottom: 0.5rem;
}
.report-hero-income-amount {
    font-size: 2.8rem;
    font-weight: 800;
    color: #2ecc71;
    margin-bottom: 1.2rem;
    letter-spacing: -2px;
}
.report-hero-btn {
    background: #c2185b;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 0.7rem 2.2rem;
    font-size: 1rem;
    font-weight: 600;
    margin-top: 0.5rem;
    transition: background 0.2s;
}
.report-hero-btn:hover {
    background: #ad1457;
}
.report-hero-center {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    z-index: 2;
    width: 100%;
    pointer-events: none;
}
.report-hero-center > * { pointer-events: auto; }
.report-hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    color: #fff;
    text-align: center;
}
.report-hero-desc {
    font-size: 1.15rem;
    color: #e0e0e0;
    margin-bottom: 2rem;
    text-align: center;
}
.report-hero-search {
    max-width: 420px;
    margin: 0 auto;
    width: 100%;
    position: relative;
    display: flex;
    align-items: center;
}
.report-hero-search input {
    border-radius: 32px;
    padding: 0.8rem 2.8rem 0.8rem 1.2rem;
    font-size: 1.1rem;
    border: 1.5px solid #2e2e4d;
    background: rgba(255,255,255,0.08);
    color: #fff;
    width: 100%;
    box-shadow: 0 2px 12px 0 rgba(24,18,43,0.08);
    transition: border-color 0.2s, box-shadow 0.2s;
}
.report-hero-search input:focus {
    outline: none;
    border-color: #c2185b;
    box-shadow: 0 4px 16px 0 rgba(194,24,91,0.10);
    background: rgba(255,255,255,0.13);
}
.report-hero-search input::placeholder {
    color: #fff;
    opacity: 1;
}
.report-hero-search .search-icon {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #c2185b;
    font-size: 1.4rem;
    pointer-events: none;
    opacity: 0.85;
}
.card.mb-4 {
    border-radius: 0 !important;
}
.dashboard-summary-row {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-bottom: 2.5rem;
}
.summary-card {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease-in-out;
}
.summary-card:hover {
    transform: translateY(-5px);
}
.summary-card span {
    font-size: 0.9rem;
    color: #6c757d;
    display: block;
    margin-bottom: 0.5rem;
}
.summary-card h2 {
    font-size: 2.2rem;
    font-weight: 700;
    color: #343a40;
    margin-bottom: 0.5rem;
}
.summary-card .summary-icon {
    font-size: 2.5rem;
    color: #007bff; /* Default icon color */
    margin-top: 1rem;
}
.summary-card.expense .summary-icon {
    color: #dc3545; /* Red for expense */
}
.summary-card.payment .summary-icon {
    color: #17a2b8; /* Blue for payment */
}
.summary-card.expense.receivable .summary-icon {
    color: #28a745; /* Green for receivable */
}
.summary-card.receivable .summary-icon {
    color: #6f42c1; /* Purple for receivable */
}
 
@media (max-width: 900px) {
    .report-hero { flex-direction: column; text-align: center; gap: 1.5rem; background-position: center bottom; background-size: cover; }
    .report-hero-left, .report-hero-center { max-width: 100%; min-width: 0; }
    .report-hero-center { position: static; transform: none; width: 100%; min-height: 0; }
}
.table-report th, .table-report td {
    width: 1%;
    white-space: nowrap;
}
</style>

<body>
    <div class="app-container">
        <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

        <div class="app-main">
            <?php require_once __DIR__ . '/../partials/header.php'; ?>

            <div class="app-content">
                <div class="container-fluid">
                    <!-- HERO SECTION -->
                    <div class="report-hero">
                        <div class="report-hero-left">
                            <div class="report-hero-income-label">BU AY PLANLANAN GELİR</div>
                            <div class="report-hero-income-amount">₺ <?= number_format($total_income_tl ?? 0, 2, ',', '.') ?></div>
                            <button class="report-hero-btn" onclick="window.print()">RAPORU YAZDIR</button>
                        </div>
                        <div class="report-hero-center">
                            <div class="report-hero-title">Aylık Rapor</div>
                            <div class="report-hero-desc">Gelir, gider, borç ve ödemeler: Hepsi tek raporda, hepsi kontrol altında!</div>
                            <div class="report-hero-search">
                                <div style="width:100%;text-align:center;font-size:1.15rem;font-weight:600;color:#fff;background:rgba(255,255,255,0.08);border-radius:32px;padding:0.8rem 1.2rem;letter-spacing:1px;">
                                    Raporun ait olduğu ay: <?= htmlspecialchars($report_period_text) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /HERO SECTION -->

                    <!-- SUMMARY CARDS -->
                    <?php
                    // Kişilere Borçlar toplamı
                    $total_debt = 0;
                    foreach (($debts ?? []) as $debt) {
                        $total_debt += (float)($debt['amount'] ?? 0);
                    }
                    // Sabit Giderler toplamı
                    $total_fixed = 0;
                    foreach (($fixed_expenses ?? []) as $row) {
                        $total_fixed += (float)($row['amount'] ?? 0);
                    }
                    // Diğer Harcamalar toplamı
                    $total_other = 0;
                    foreach (($other_expenses ?? []) as $row) {
                        $total_other += (float)($row['amount'] ?? 0);
                    }
                    // Alınacaklar toplamı (dinamik)
                    $total_receivable = 0;
                    if (is_array($alinacaklar)) {
                        foreach ($alinacaklar as $item) {
                            $total_receivable += (float)($item['price'] ?? 0);
                        }
                    }
                    ?>
                    <div class="dashboard-summary-row mb-4">
                        <div class="summary-card expense position-relative">
                            <span>Kişilere Borçlar</span>
                            <h2>₺<?= number_format($total_debt ?? 0, 2, ',', '.') ?></h2>
                            <i class="bi bi-people summary-icon"></i>
                        </div>
                        <div class="summary-card payment position-relative">
                            <span>Sabit Giderler</span>
                            <h2>₺<?= number_format($total_fixed ?? 0, 2, ',', '.') ?></h2>
                            <i class="bi bi-credit-card summary-icon"></i>
                        </div>
                        <div class="summary-card expense position-relative">
                            <span>Diğer Harcamalar</span>
                            <h2>₺<?= number_format($total_other ?? 0, 2, ',', '.') ?></h2>
                            <i class="bi bi-wallet2 summary-icon"></i>
                        </div>
                        <div class="summary-card receivable position-relative">
                            <span>Alınacaklar</span>
                            <h2>₺<?= number_format($total_receivable ?? 0, 2, ',', '.') ?></h2>
                            <i class="bi bi-cart summary-icon"></i>
                        </div>
                    </div>
                    <!-- /SUMMARY CARDS -->

                    <!-- Borçlar (Şahıslara) -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <span class="me-2">📌</span> Kişilere Borçlar
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 table-report">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kişi / Kurum</th>
                                            <th>IBAN</th>
                                            <th>Tutar (₺)</th>
                                            <th>Açıklama</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php foreach (($debts ?? []) as $debt): ?>
<tr>
    <td><?= htmlspecialchars($debt['to_whom'] ?? '-') ?></td>
    <td><?= !empty($debt['ibans']) ? implode('<br>', array_map('htmlspecialchars', $debt['ibans'])) : '—' ?></td>
    <td><?= number_format($debt['amount'] ?? 0, 2, ',', '.') ?></td>
    <td><?= htmlspecialchars($debt['description'] ?? '-') ?></td>
    <td>
        <button class="btn btn-outline-primary btn-sm btn-report-action me-1" title="Ödendi"><i class="bi bi-check-circle"></i> Ödendi</button>
        <button class="btn btn-primary btn-sm btn-report-action me-1" title="Ertele"><i class="bi bi-clock-history"></i> Ertele</button>
    </td>
</tr>
<?php endforeach; ?>
<tr class="fw-bold table-secondary">
    <td>Toplam</td>
    <td></td>
    <td><?= number_format($total_debt, 2, ',', '.') ?></td>
    <td></td>
    <td></td>
</tr>
</tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Sabit Giderler -->
                    <div class="card mb-4">
                        <div class="card-header bg-sabit-giderler">
                            <span class="me-2">💳</span> Sabit Giderler
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 table-report">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Açıklama</th>
                                            <th>Tutar (₺)</th>
                                            <th>Tarih</th>
                                            <th>Ödeme Yeri</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach (($fixed_expenses ?? []) as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['description'] ?? '-') ?></td>
                                            <td><?= number_format($row['amount'] ?? 0, 2, ',', '.') ?></td>
                                            <td><?= htmlspecialchars($row['date'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['payment_place'] ?? '-') ?></td>
                                            <td>
                                                <button class="btn btn-outline-primary btn-sm btn-report-action me-1" title="Ödendi"><i class="bi bi-check-circle"></i> Ödendi</button>
                                                <button class="btn btn-primary btn-sm btn-report-action me-1" title="Ertele"><i class="bi bi-clock-history"></i> Ertele</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="fw-bold table-secondary">
                                        <td>Toplam</td>
                                        <td><?= number_format($total_fixed, 2, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Diğer Harcamalar -->
                    <div class="card mb-4">
                        <div class="card-header bg-diger-harcamalar">
                            <span class="me-2">🧾</span> Diğer Harcamalar
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 table-report">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Açıklama</th>
                                            <th>Tutar (₺)</th>
                                            <th>Kategori</th>
                                            <th>Tarih</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach (($other_expenses ?? []) as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['description'] ?? '-') ?></td>
                                            <td><?= number_format($row['amount'] ?? 0, 2, ',', '.') ?></td>
                                            <td>
                                                <?php
                                                if (($row['category_type'] ?? '') === 'ani_harcama') {
                                                    echo 'Ani Harcama';
                                                } elseif (($row['category_type'] ?? '') === 'degisken_gider') {
                                                    echo 'Değişken Gider';
                                                } elseif (($row['category_type'] ?? '') === 'ani_ekstra') {
                                                    echo 'Ekstra Gider';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                            <td><?= htmlspecialchars($row['date'] ?? '-') ?></td>
                                            <td>
                                                <button class="btn btn-outline-primary btn-sm btn-report-action me-1" title="Ödendi"><i class="bi bi-check-circle"></i> Ödendi</button>
                                                <button class="btn btn-primary btn-sm btn-report-action me-1" title="Ertele"><i class="bi bi-clock-history"></i> Ertele</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="fw-bold table-secondary">
                                        <td>Toplam</td>
                                        <td><?= number_format($total_other, 2, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Alınacaklar (Planlı Harcamalar) -->
                    <div class="card mb-4">
                        <div class="card-header bg-alinacaklar">
                            <span class="me-2">📦</span> Alınacaklar
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 table-report">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Ürün / Hedef</th>
                                            <th>Kategori</th>
                                            <th>Tahmini Tutar (₺)</th>
                                            <th>Öncelik (1-5)</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php foreach (($alinacaklar ?? []) as $item): ?>
<tr>
  <td><?= htmlspecialchars($item['item_name']) ?></td>
  <td><?= htmlspecialchars($item['wishlist_type']) ?></td>
  <td><?= number_format($item['price'], 2, ',', '.') ?></td>
  <td><?= htmlspecialchars($item['priority']) ?></td>
  <td>
    <button class="btn btn-outline-primary btn-sm btn-report-action me-1" title="Ödendi"><i class="bi bi-check-circle"></i> Ödendi</button>
    <button class="btn btn-primary btn-sm btn-report-action me-1" title="Ertele"><i class="bi bi-clock-history"></i> Ertele</button>
  </td>
</tr>
<?php endforeach; ?>
<?php if (empty($alinacaklar)): ?>
<tr><td colspan="5" class="text-center">Kayıtlı alınacak yok.</td></tr>
<?php endif; ?>
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
                                    <span class="fw-bold text-success">₺ <?= number_format($total_income_tl ?? 0, 2, ',', '.') ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><strong>Planlanan Gider:</strong></span>
                                    <span class="fw-bold text-danger">₺ <?= number_format($planlanan_gider ?? 0, 2, ',', '.') ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><strong>Fark:</strong></span>
                                    <span class="fw-bold text-warning">₺ <?= number_format($aylik_acik ?? 0, 2, ',', '.') ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../partials/script.php'; ?>
<?php require_once __DIR__ . '/../partials/script-legacy.php'; ?>
</body> 