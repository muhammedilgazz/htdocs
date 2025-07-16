<?php
// No direct includes of partials/head.php or partials/script.php here.
// These are handled by the main layout structure.

// Ensure $rows is defined even if empty
if (!isset($rows)) $rows = [];

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aylık Giderler - Bütçe Yönetimi</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/custom-colors.css" rel="stylesheet">
    <link href="/assets/css/ekash-minimal.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <?php require_once __DIR__ . '/../partials/sidebar.php'; ?>
        <div class="app-main">
            <?php require_once __DIR__ . '/../partials/header.php'; ?>
            <div class="app-content">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2"><i class="fas fa-chart-line me-2"></i>Bu Ayın Giderleri</h1>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Gider Özeti</h5>
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
                                            <th>Kategori</th>
                                            <th>Tip</th>
                                            <th>Tutar</th>
                                            <th>Tarih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['description']) ?></td>
                                            <td><?= htmlspecialchars($row['category']) ?></td>
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
    <?php require_once __DIR__ . '/../partials/script.php'; ?>
</body>
</html>