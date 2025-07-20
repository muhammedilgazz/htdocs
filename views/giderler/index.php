<?php
require_once ROOT_PATH . '/views/partials/head.php';
?>
<body>
    <div class="app-container">
        <?php require_once ROOT_PATH . '/views/partials/sidebar.php'; ?>
        <div class="app-main">
            <?php require_once ROOT_PATH . '/views/partials/header.php'; ?>
            <div class="app-content">
                <div class="container-fluid">
                    <?php
                    $page_title = isset($_GET['filter']) && $_GET['filter'] == 'all' ? 'Tüm Giderler' : 'Bu Ayın Giderleri';
                    $page_description = 'Giderlerinizi buradan takip edebilirsiniz.';
                    $breadcrumb_active = 'Giderler';
                    include ROOT_PATH . '/views/partials/page_header.php';
                    ?>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Gider Özeti</h5>
                            <div class="d-flex align-items-center">
                                <?php if (!empty($rows)): ?>
                                    <h5 class="mb-0 text-end me-3">Güncel Toplam: <?= number_format(array_sum(array_column($rows, 'amount')), 2) ?> ₺</h5>
                                <?php endif; ?>
                                <button id="export-excel" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($rows)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <h5 class="text-muted">Bu ay için herhangi bir gider bulunamadı.</h5>
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Açıklama</th>
                                            <th>Tür</th>
                                            <th>Tutar</th>
                                            <th>Tarih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['description']) ?></td>
                                            <td>
                                                <?php
                                                $type = $row['type'];
                                                $type_class = match($type) {
                                                    'Harcama' => 'primary',
                                                    'Alınacak' => 'info',
                                                    'Banka Borcu' => 'danger',
                                                    'İcra Borcu' => 'danger',
                                                    'Şahıs Borcu' => 'danger',
                                                    'SGK Borcu' => 'danger',
                                                    'Vergi Borcu' => 'danger',
                                                    default => 'secondary'
                                                };
                                                ?>
                                                <span class="badge bg-<?= $type_class ?>"><?= htmlspecialchars($type) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <?= number_format($row['amount'], 2) ?> ₺
                                                </span>
                                            </td>
                                            <td><?= date('d.m.Y', strtotime($row['created_at'])) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include ROOT_PATH . '/views/partials/script.php'; ?>
    <script>
        document.getElementById('export-excel').addEventListener('click', function() {
            window.location.href = '/ajax/export_giderler.php';
        });
    </script>
</body>
</html>