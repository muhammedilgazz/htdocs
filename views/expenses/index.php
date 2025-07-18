<?php
if (!isset($total_expenses)) $total_expenses = 0;
if (!isset($rows)) $rows = [];
if (!isset($csrf_token)) $csrf_token = '';

// Ensure other stats variables are defined
if (!isset($expense_items_count)) $expense_items_count = 0;
if (!isset($total_debt_payments)) $total_debt_payments = 0;
if (!isset($remaining_debt_count)) $remaining_debt_count = 0;
if (!isset($total_wishlist_price)) $total_wishlist_price = 0;
if (!isset($approved_wishlist_count)) $approved_wishlist_count = 0;
if (!isset($monthly_fixed_expenses)) $monthly_fixed_expenses = 0;
if (!isset($one_time_expenses)) $one_time_expenses = 0;

include __DIR__ . '/../partials/head.php'; ?>

<body>
<div class="app-container">
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>
    <div class="app-main">
        <?php include __DIR__ . '/../partials/header.php'; ?>
        <div class="app-content">
            <div class="container py-3">
                <div class="card mb-3" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); margin-top:1rem;">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">
                        <div class="d-flex align-items-center gap-2">
                            <div style="font-size:1.5rem; color:#ffb300;"><i class="bi bi-credit-card-2-front"></i></div>
                            <div>
                                <h2 class="mb-0" style="font-weight:700; color:#222; font-size:1.2rem;">Harcamalar</h2>
                                <div style="color:#6b7280; font-size:0.85rem;">Tüm harcamalarınızı burada görüntüleyebilirsiniz.</div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal" style="background:#1f2e4e; border:none; font-size:0.9rem; padding:0.5rem 1rem;">
                                <i class="bi bi-plus-circle me-2"></i>Harcama Ekle
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Dashboard Kartları -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="card p-4 h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:0;">
                            <div style="font-size:1.05rem; color:#6b7a99; font-weight:600;">Toplam Giderler</div>
                            <div style="font-size:1.5rem; color:#1a2550; font-weight:700; margin:8px 0;">₺<?= number_format($total_expenses, 0, ',', '.') ?></div>
                            <div class="d-flex justify-content-between align-items-center" style="font-size:1rem; color:#7b8ab8;">
                                <span>Harcama + Borç + Alınacak</span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-4 h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:0;">
                            <div style="font-size:1.05rem; color:#6b7a99; font-weight:600;">Harcama Kalemleri</div>
                            <div style="font-size:1.5rem; color:#1a2550; font-weight:700; margin:8px 0;">₺<?= number_format($total_expenses, 0, ',', '.') ?></div>
                            <div class="d-flex justify-content-between align-items-center" style="font-size:1rem; color:#7b8ab8;">
                                <span>Toplam Kalem</span>
                                <span style="color:#2979ff; font-weight:700;"><?= $expense_items_count ?> Adet</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-4 h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:0;">
                            <div style="font-size:1.05rem; color:#6b7a99; font-weight:600;">Borç Ödemeleri</div>
                            <div style="font-size:1.5rem; color:#1a2550; font-weight:700; margin:8px 0;">₺<?= number_format($total_debt_payments, 0, ',', '.') ?></div>
                            <div class="d-flex justify-content-between align-items-center" style="font-size:1rem; color:#7b8ab8;">
                                <span>Kalan Borç</span>
                                <span style="color:#2979ff; font-weight:700;"><?= $remaining_debt_count ?> Adet</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-4 h-100" style="box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); border-radius:0;">
                            <div style="font-size:1.05rem; color:#6b7a99; font-weight:600;">Alınacaklar</div>
                            <div style="font-size:1.5rem; color:#1a2550; font-weight:700; margin:8px 0;">₺<?= number_format($total_wishlist_price, 0, ',', '.') ?></div>
                            <div class="d-flex justify-content-between align-items-center" style="font-size:1rem; color:#7b8ab8;">
                                <span>Onaylanan</span>
                                <span style="color:#2979ff; font-weight:700;"><?= $approved_wishlist_count ?> Adet</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- İstatistik Kartları -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="stat-card d-flex align-items-center justify-content-center p-3 h-100 w-100" style="background:#fff; box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); min-height:70px; border-radius:0;">
                            <span style="font-size:1rem; color:#ffb300; font-weight:700; display:flex; align-items:center; gap:8px;">
                                <i class="bi bi-calculator" style="font-size:1.3rem;"></i> Toplam Harcama: ₺<?= number_format($total_expenses, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card d-flex align-items-center justify-content-center p-3 h-100 w-100" style="background:#fff; box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); min-height:70px; border-radius:0;">
                            <span style="font-size:1rem; color:#2979ff; font-weight:700; display:flex; align-items:center; gap:8px;">
                                <i class="bi bi-arrow-repeat" style="font-size:1.3rem;"></i> Aylık Sabit Harcamalar: ₺<?= number_format($monthly_fixed_expenses, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card d-flex align-items-center justify-content-center p-3 h-100 w-100" style="background:#fff; box-shadow:0 2px 12px 0 rgba(79,140,255,0.06); min-height:70px; border-radius:0;">
                            <span style="font-size:1rem; color:#12A347; font-weight:700; display:flex; align-items:center; gap:8px;">
                                <i class="bi bi-cart-check" style="font-size:1.3rem;"></i> Tek Seferlik Harcamalar: ₺<?= number_format($one_time_expenses, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Gider Tablosu -->
                <?php if (empty($rows)): ?>
                    <div class="text-center py-5">
                        <p>Henüz gider kaydı yok.</p>
                    </div>
                <?php else: ?>
                    <div class="card p-0">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Gider Listesi</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Açıklama</th>
                                            <th>Kategori</th>
                                            <th>Tutar</th>
                                            <th>Tarih</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['description']) ?></td>
                                            <td><?= htmlspecialchars($row['category_type']) ?></td>
                                            <td>₺<?= number_format($row['amount'], 2, ',', '.') ?></td>
                                            <td><?= date('d.m.Y', strtotime($row['date'])) ?></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editExpenseModal">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-warning btn-sm dropdown-toggle" 
                                                                type="button" 
                                                                data-bs-toggle="dropdown" 
                                                                aria-expanded="false">
                                                            <i class="bi bi-clock"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" style="font-size:0.8rem;">
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, 1)">1 Ay</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, 3)">3 Ay</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, 6)">6 Ay</a></li>
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, 12)">1 Yıl</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#" onclick="postponeExpense(<?= $row['id'] ?>, 'later')">Daha Sonra</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Gider Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Tutar</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_type" class="form-label">Kategori</label>
                        <select class="form-select" id="category_type" name="category_type">
                            <option value="sabit_gider">Sabit Gider</option>
                            <option value="degisken_gider">Değişken Gider</option>
                            <option value="ani_ekstra">Ani/Ekstra</option>
                            <option value="ertelenmis">Ertelenmiş</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Tarih</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= date('Y-m-d') ?>">
                    </div>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Expense Modal -->
<div class="modal fade" id="editExpenseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gideri Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Açıklama</label>
                        <input type="text" class="form-control" id="edit_description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Tutar</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category_type" class="form-label">Kategori</label>
                        <select class="form-select" id="edit_category_type" name="category_type">
                            <option value="sabit_gider">Sabit Gider</option>
                            <option value="degisken_gider">Değişken Gider</option>
                            <option value="ani_ekstra">Ani/Ekstra</option>
                            <option value="ertelenmis">Ertelenmiş</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_date" class="form-label">Tarih</label>
                        <input type="date" class="form-control" id="edit_date" name="date">
                    </div>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/script.php'; ?>

<script>
$(document).ready(function() {
    // Add Form
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_expense.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: response.message || 'Bir hata oluştu.'
                    });
                }
            }
        });
    });

    // Edit Button
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_expense.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const expense = response.data;
                    $('#edit_id').val(expense.id);
                    $('#edit_description').val(expense.description);
                    $('#edit_amount').val(expense.amount);
                    $('#edit_category_type').val(expense.category_type); 
                    $('#edit_date').val(expense.date);
                } else {
                    alert(response.message || 'Veri getirilemedi.');
                }
            }
        });
    });

    // Edit Form
    $('#editForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/update_expense.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: response.message || 'Bir hata oluştu.'
                    });
                }
            }
        });
    });

    // Delete Button
    $('.delete-btn').click(function() {
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu gideri silmek istediğinizden emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(this).data('id');
                $.ajax({
                    url: 'ajax/delete_expense.php',
                    type: 'POST',
                    data: { id: id, csrf_token: '<?= $csrf_token ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Silindi!',
                                'Gider başarıyla silindi.',
                                'success'
                            ).then(() => location.reload());
                        } else {
                            Swal.fire(
                                'Hata!',
                                response.message || 'Bir hata oluştu.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    });

    // Postpone Expense Function
    window.postponeExpense = function(id, months) {
        if (!confirm('Bu harcamayı ertelemek istediğinizden emin misiniz?')) {
            return;
        }
        
        $.ajax({
            url: 'ajax/postpone_expense.php',
            type: 'POST',
            data: {
                id: id,
                months: months,
                csrf_token: '<?= $csrf_token ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: response.message || 'Bir hata oluştu.'
                    });
                }
            },
            error: function() {
                alert('Erteleme işleminde bir hata oluştu!');
            }
        });
    };
});
</script>

</body>
</html>
