<?php require_once 'includes/auth_check.php'; ?>
<?php
    $script='<script src="assets/vendor/chartjs/chartjs.js"></script>
            <script src="assets/js/plugins/chartjs-donut.js"></script>';
?>

<?php include './layouts/layoutTop.php'?>

        <div class="content-body">
        <div class="container py-4">
                    <div class="row mb-4">
                        <div class="col-md-4">
            <div class="stat-card text-center p-4 h-100" style="background:#fff; border-radius:16px; box-shadow:0 2px 16px 0 rgba(79,140,255,0.06);">
                <div class="mb-2" style="font-size:2rem; color:#ffb300;"><i class="bi bi-calculator"></i></div>
                <div style="font-size:1.05rem; color:#222; font-weight:600;">Toplam Harcama</div>
                <div style="font-size:1.5rem; color:#ffb300; font-weight:700;">₺<?= number_format($db->getDbValue('SELECT SUM(amount) FROM expense_items'), 0, ',', '.') ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
            <div class="stat-card text-center p-4 h-100" style="background:#fff; border-radius:16px; box-shadow:0 2px 16px 0 rgba(79,140,255,0.06);">
                <div class="mb-2" style="font-size:2rem; color:#2979ff;"><i class="bi bi-arrow-repeat"></i></div>
                <div style="font-size:1.05rem; color:#222; font-weight:600;">Aylık Sabit Harcamalar</div>
                <div style="font-size:1.5rem; color:#2979ff; font-weight:700;">₺<?= number_format($db->getDbValue("SELECT SUM(amount) FROM expense_items WHERE category_id = (SELECT id FROM categories WHERE name = 'abonelikler' AND type = 'expense')"), 0, ',', '.') ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
            <div class="stat-card text-center p-4 h-100" style="background:#fff; border-radius:16px; box-shadow:0 2px 16px 0 rgba(79,140,255,0.06);">
                <div class="mb-2" style="font-size:2rem; color:#34c759;"><i class="bi bi-cart-check"></i></div>
                <div style="font-size:1.05rem; color:#222; font-weight:600;">Tek Seferlik Harcamalar</div>
                <div style="font-size:1.5rem; color:#34c759; font-weight:700;">₺<?= number_format($db->getDbValue("SELECT SUM(amount) FROM expense_items WHERE category_id != (SELECT id FROM categories WHERE name = 'abonelikler' AND type = 'expense')"), 0, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>
    <div class="card p-0" style="border-radius:16px; box-shadow:0 2px 16px 0 rgba(79,140,255,0.06);">
        <div class="card-header bg-white" style="border-radius:16px 16px 0 0; border-bottom:1.5px solid #f0f2f7;">
            <h5 class="mb-0" style="font-weight:700; color:#222;">Harcama Kalemleri</h5>
                    </div>
        <div class="card-body p-0">
                                        <div class="table-responsive">
                <table class="table align-middle mb-0" style="min-width:900px;">
                    <thead style="background:#f5f7fa;">
                        <tr style="color:#222; font-weight:600;">
                            <th style="padding-left:1.5rem;">Kategori</th>
                            <th>Ürün Hizmet</th>
                            <th>Tutar</th>
                            <th>Link</th>
                            <th>Açıklama</th>
                            <th>Durum</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                        <?php
                        $rows = $db->fetchAll("SELECT ei.*, c.name as category_name, st.name as status_name FROM expense_items ei JOIN categories c ON ei.category_id = c.id JOIN status_types st ON ei.status_id = st.id ORDER BY ei.id DESC");
                        foreach ($rows as $row):
                        ?>
                        <tr>
                            <td style="padding-left:1.5rem;">
                                <span class="badge" style="background:<?= $row['category_name']==='ödeme'?'#ffb300':'#e5e9f2'; ?>; color:<?= $row['category_name']==='ödeme'?'#fff':'#222'; ?>; font-weight:600; font-size:0.97rem;">
                                    <?= ucfirst($row['category_name']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['item_name']) ?></td>
                            <td>
                                <span style="color:#34c759; font-weight:700; font-size:1.1rem;">
                                    ₺<?= number_format($row['amount'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($row['link'])): ?>
                                    <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="btn btn-outline-dark btn-sm">Link</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['description'] ?? '-') ?></td>
                            <td>
                                <span class="badge" style="background:<?= $row['status_name']==='Tamamlandı'?'#34c759':'#e5e9f2'; ?>; color:<?= $row['status_name']==='Tamamlandı'?'#fff':'#222'; ?>; font-weight:600; font-size:0.97rem;">
                                    <?= $row['status_name'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                                                </tbody>
                                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

<?php include './layouts/layoutBottom.php'?>