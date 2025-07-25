<!DOCTYPE html>
<html lang="tr">
<head>
    <?php include_once __DIR__ . '/../partials/head.php'; ?>
    <title>Market & Gıda - <?= APP_NAME ?></title>
</head>
<body>
    <div class="app-container">
        <?php include_once __DIR__ . '/../partials/sidebar.php'; ?>
        <div class="app-main">
            <?php include_once __DIR__ . '/../partials/header.php'; ?>
            <div class="app-content">
                <div class="container-fluid">
                    <?php
                    $page_title = 'Market & Gıda';
                    $page_description = 'Market alışverişlerinizi ve ürün stoklarınızı buradan takip edebilirsiniz.';
                    $breadcrumb_active = 'Market & Gıda';
                    include_once __DIR__ . '/../partials/page_header.php';
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card p-0">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">Ürün Listesi</h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="marketTable" class="table align-middle mb-0 table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Ürün Resmi</th>
                                                    <th>Ürün Adı</th>
                                                    <th>Kategori</th>
                                                    <th>Link</th>
                                                    <th>Adet</th>
                                                    <th>Birim Fiyatı</th>
                                                    <th>Toplam Tutar</th>
                                                    <th>Min. Stok</th>
                                                    <th>Mevcut Stok</th>
                                                    <th>İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($products)): ?>
                                                    <?php foreach ($products as $product): ?>
                                                        <tr>
                                                            <td><img src="<?= htmlspecialchars($product['image_url'] ?? '') ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" width="50" style="height: 50px; object-fit: cover;"></td>
                                                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                                                            <td><?= htmlspecialchars($product['category'] ?? '') ?></td>
                                                            <td><a href="<?= htmlspecialchars($product['link'] ?? '#') ?>" target="_blank">Ürüne Git</a></td>
                                                            <td><?= htmlspecialchars($product['quantity']) ?></td>
                                                            <td><?= htmlspecialchars($product['price']) ?> ₺</td>
                                                            <td><?= htmlspecialchars($product['total_amount']) ?> ₺</td>
                                                            <td><?= htmlspecialchars($product['min_stock']) ?></td>
                                                            <td><?= htmlspecialchars($product['current_stock']) ?></td>
                                                            <td>
                                                                <div class="d-flex gap-1">
                                                                    <button class="btn btn-sm btn-primary" title="Düzenle"><i class="bi bi-pencil"></i></button>
                                                                    <button class="btn btn-sm btn-primary" title="Sil"><i class="bi bi-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="10" class="text-center">Henüz ürün eklenmemiş.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Yeni Ürün Ekle</h5>
                                </div>
                                <div class="card-body">
                                    <form id="add-market-product-form">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="product_name" class="form-label">Ürün Adı</label>
                                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="company_name" class="form-label">Firma Adı</label>
                                                <input type="text" class="form-control" id="company_name" name="company_name">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="category" class="form-label">Kategori</label>
                                                <input type="text" class="form-control" id="category" name="category" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="link" class="form-label">Ürün Linki</label>
                                                <input type="text" class="form-control" id="link" name="link">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="image_url" class="form-label">Ürün Resim URL</label>
                                                <input type="text" class="form-control" id="image_url" name="image_url">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="quantity" class="form-label">Adet</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="price" class="form-label">Birim Fiyatı</label>
                                                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="min_stock" class="form-label">Min. Stok</label>
                                                <input type="number" class="form-control" id="min_stock" name="min_stock" value="0">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="current_stock" class="form-label">Mevcut Stok</label>
                                                <input type="number" class="form-control" id="current_stock" name="current_stock" value="0">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Ürün Ekle</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../partials/script.php'; ?>
    <script>
        $(document).ready(function() {
            $('#marketTable').DataTable({
                language: {
                    "sDecimal": ",", "sEmptyTable": "Tabloda herhangi bir veri mevcut değil", "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor", "sInfoEmpty": "Kayıt yok", "sInfoFiltered": "(_MAX_ kayıt içerisinden bulundu)", "sInfoPostFix": "", "sInfoThousands": ".", "sLengthMenu": "Sayfada _MENU_ kayıt göster", "sLoadingRecords": "Yükleniyor...", "sProcessing": "İşleniyor...", "sSearch": "Ara:", "sZeroRecords": "Eşleşen kayıt bulunamadı", "oPaginate": { "sFirst": "İlk", "sLast": "Son", "sNext": "Sonraki", "sPrevious": "Önceki" }, "oAria": { "sSortAscending": ": artan sütun sıralamasını aktifleştir", "sSortDescending": ": azalan sütun sıralamasını aktifleştir" }
                },
                columnDefs: [ { orderable: false, targets: [0, 3, 9] } ] // Resim, link ve işlemler sütunları sıralanamaz
            });

            document.getElementById('add-market-product-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                formData.append('action', 'market_add_product');
                fetch('/ajax.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('Bir hata oluştu.');
                });
            });
        });
    </script>
</body>
</html>