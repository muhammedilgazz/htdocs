<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
$security = new SecurityManager();
$security->checkSession();
include 'partials/head.php';
$db = Database::getInstance();
$rows = $db->fetchAll("SELECT e.*, c.name as kategori_adi FROM expense_items e LEFT JOIN categories c ON e.category_id = c.id WHERE c.name='Sabit Giderler' ORDER BY e.id DESC");
$csrf_token = generate_csrf_token();
?>
<body>
<div class="app-container">
    <?php include 'partials/sidebar.php'; ?>
    <div class="app-main">
        <?php include 'partials/header.php'; ?>
        <!-- Breadcrumb ve Başlık -->
        <div class="container-fluid py-1" style="background:#f7f9fb;">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;">Sabit Giderler</h2>
                    <div style="color:#7b8ab8; font-size:1rem;">Her ay düzenli olarak yapılan ve tutarı büyük ölçüde değişmeyen harcamalar.</div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background:transparent;">
                        <li class="breadcrumb-item"><a href="index.php" style="color:#7b8ab8; text-decoration:none;">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;">Sabit Giderler</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Sabit Giderler</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">Sıra No</th>
                                        <th>Kategori</th>
                                        <th>Ürün/Hizmet</th>
                                        <th>Tutar</th>
                                        <th>Link</th>
                                        <th>Açıklama</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr style="font-size:0.85rem;">
                                        <td style="padding-left:1.5rem;"> <?= $row['sira'] ?> </td>
                                        <td> <?= htmlspecialchars($row['kategori']) ?> </td>
                                        <td> <?= htmlspecialchars($row['urun']) ?> </td>
                                        <td> ₺<?= number_format($row['tutar'], 0, ',', '.') ?> </td>
                                        <td>
                                            <?php if (!empty($row['link'])): ?>
                                                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td> <?= htmlspecialchars($row['aciklama'] ?? '-') ?> </td>
                                        <td>
                                            <div class="position-relative" style="display:inline-block; width:120px;">
                                                <select class="form-select form-select-sm status-dropdown" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 2rem 0.3rem 0.5rem; min-width:100px; border:1px solid #e5e9f2; appearance:none;">
                                                    <option value="Beklemede" <?= $row['durum'] == 'Beklemede' ? 'selected' : '' ?>>Beklemede</option>
                                                    <option value="Devam Ediyor" <?= $row['durum'] == 'Devam Ediyor' ? 'selected' : '' ?>>Devam Ediyor</option>
                                                    <option value="Tamamlandı" <?= $row['durum'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                                    <option value="İptal Edildi" <?= $row['durum'] == 'İptal Edildi' ? 'selected' : '' ?>>İptal Edildi</option>
                                                </select>
                                                <i class="bi bi-caret-down-fill" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); pointer-events:none; color:#b0b8c9; font-size:1rem;"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Düzenle" type="button">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm" style="font-size:0.8rem; padding:0.3rem 0.5rem; min-width:32px;" title="Sil" type="button">
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
                <!-- Harcama Ekle Modal -->
                <div class="modal fade" id="harcamaEkleModal" tabindex="-1" aria-labelledby="harcamaEkleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form id="harcamaEkleForm">
                        <input type="hidden" name="kategori_tipi" value="Sabit Giderler">
                        <div class="mb-3">
                          <label class="form-label">Kategori Tipi</label>
                          <select class="form-select" name="kategori_tipi" required>
                            <option value="Sabit Giderler">Sabit Giderler</option>
                            <option value="Değişken Giderler">Değişken Giderler</option>
                            <option value="Borç Ödemeleri">Borç Ödemeleri</option>
                            <option value="Ani/Ekstra Harcama">Ani/Ekstra Harcama</option>
                            <option value="Ertelenen Ödemeler">Ertelenen Ödemeler</option>
                          </select>
                        </div>
                        <!-- ... diğer form alanları ... -->
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Düzenle Modalı -->
                <div class="modal fade" id="duzenleModal" tabindex="-1" aria-labelledby="duzenleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form id="duzenleForm">
                        <input type="hidden" name="kategori_tipi" value="Sabit Giderler">
                        <div class="mb-3">
                          <label class="form-label">Kategori Tipi</label>
                          <select class="form-select" name="kategori_tipi" id="duzenle-kategori-tipi" required>
                            <option value="Sabit Giderler">Sabit Giderler</option>
                            <option value="Değişken Giderler">Değişken Giderler</option>
                            <option value="Borç Ödemeleri">Borç Ödemeleri</option>
                            <option value="Ani/Ekstra Harcama">Ani/Ekstra Harcama</option>
                            <option value="Ertelenen Ödemeler">Ertelenen Ödemeler</option>
                          </select>
                        </div>
                        <!-- ... diğer form alanları ... -->
                      </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/script.php'; ?>

</body> 