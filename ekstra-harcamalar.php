<?php
require_once 'config/config.php';
require_once 'classes/Database.php';
require_once 'classes/SecurityManager.php';
$security = new SecurityManager();
$security->checkSession();
include 'partials/head.php';
$db = Database::getInstance();
$rows = $db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id WHERE c.name = 'Ani/Ekstra Harcama' AND c.type = 'expense' ORDER BY ei.id DESC");
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
                    <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;">Ani/Ekstra Harcamalar</h2>
                    <div style="color:#7b8ab8; font-size:1rem;">Plansız ve manuel giriş gerektiren harcamalar.</div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="background:transparent;">
                        <li class="breadcrumb-item"><a href="index.php" style="color:#7b8ab8; text-decoration:none;">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;">Ani/Ekstra Harcamalar</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="app-content harcamalar-kucuk-font">
            <div class="container py-3">
                <!-- Tablo Başlangıcı -->
                <div class="card p-0" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06);">
                    <div class="card-header bg-white" style="border-bottom:1px solid #f0f2f7; padding:0.75rem 1rem;">
                        <h5 class="mb-0" style="font-weight:600; color:#222; font-size:1rem;">Ani/Ekstra Harcamalar</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="min-width:900px; font-size:0.9rem;">
                                <thead style="background:#f5f7fa;">
                                    <tr style="color:#222; font-weight:600; font-size:0.85rem;">
                                        <th style="padding-left:1.5rem;">Kategori</th>
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
                                        <td style="padding-left:1.5rem;"> <?= htmlspecialchars($row['category_name']) ?> </td>
                                        <td> <?= htmlspecialchars($row['item_name']) ?> </td>
                                        <td> ₺<?= number_format($row['amount'], 0, ',', '.') ?> </td>
                                        <td>
                                            <?php if (!empty($row['link'])): ?>
                                                <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" style="font-size:0.8rem; padding:0.3rem 0.6rem;">Link</a>
                                            <?php else: ?>-
                                            <?php endif; ?>
                                        </td>
                                        <td> <?= htmlspecialchars($row['description'] ?? '-') ?> </td>
                                        <td>
                                            <div class="position-relative" style="display:inline-block; width:120px;">
                                                <select class="form-select form-select-sm status-dropdown" data-id="<?= $row['id'] ?>" style="font-size:0.8rem; padding:0.3rem 2rem 0.3rem 0.5rem; min-width:100px; border:1px solid #e5e9f2; appearance:none;">
                                                    <option value="Beklemede" <?= $row['status_name'] == 'Beklemede' ? 'selected' : '' ?>>Beklemede</option>
                                                    <option value="Devam Ediyor" <?= $row['status_name'] == 'Devam Ediyor' ? 'selected' : '' ?>>Devam Ediyor</option>
                                                    <option value="Tamamlandı" <?= $row['status_name'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                                    <option value="İptal Edildi" <?= $row['status_name'] == 'İptal Edildi' ? 'selected' : '' ?>>İptal Edildi</option>
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
                            <div class="modal-header">
                                <h5 class="modal-title" id="harcamaEkleModalLabel">Yeni Ani/Ekstra Harcama Ekle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="harcamaEkleForm">
                                <div class="modal-body">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" value="Ani/Ekstra Harcama" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="item_name" class="form-label">Harcama Adı</label>
                                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Örn: Taksi, Kahve, Sinema" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Tutar (₺)</label>
                                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link (Opsiyonel)</label>
                                        <input type="url" class="form-control" id="link" name="link">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Açıklama (Opsiyonel)</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="status_name" class="form-label">Durum</label>
                                        <select class="form-select" id="status_name" name="status_name" required>
                                            <option value="Beklemede">Beklemede</option>
                                            <option value="Devam Ediyor">Devam Ediyor</option>
                                            <option value="Tamamlandı">Tamamlandı</option>
                                            <option value="İptal Edildi">İptal Edildi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-primary">Ekle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Düzenle Modalı -->
                <div class="modal fade" id="duzenleModal" tabindex="-1" aria-labelledby="duzenleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="duzenleModalLabel">Ani/Ekstra Harcama Düzenle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="duzenleForm">
                                <div class="modal-body">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="id" id="edit_id">
                                    
                                    <div class="mb-3">
                                        <label for="edit_category_name" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="edit_category_name" name="category_name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_item_name" class="form-label">Harcama Adı</label>
                                        <input type="text" class="form-control" id="edit_item_name" name="item_name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_amount" class="form-label">Tutar (₺)</label>
                                        <input type="number" class="form-control" id="edit_amount" name="amount" step="0.01" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_link" class="form-label">Link (Opsiyonel)</label>
                                        <input type="url" class="form-control" id="edit_link" name="link">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_description" class="form-label">Açıklama (Opsiyonel)</label>
                                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edit_status_name" class="form-label">Durum</label>
                                        <select class="form-select" id="edit_status_name" name="status_name" required>
                                            <option value="Beklemede">Beklemede</option>
                                            <option value="Devam Ediyor">Devam Ediyor</option>
                                            <option value="Tamamlandı">Tamamlandı</option>
                                            <option value="İptal Edildi">İptal Edildi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </div>
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