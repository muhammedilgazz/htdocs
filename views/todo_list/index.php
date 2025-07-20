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
                $page_title = 'To-Do List';
                $page_description = 'Günlük görevler ve yapılacaklar listesi.';
                $breadcrumb_active = 'To-Do List';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodoModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni To-Do Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-check2-square"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz to-do kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Günlük görevlerinizi ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">To-Do Listesi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="todoTable" class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Görev</th>
                                        <th>Durum</th>
                                        <th>Vade Tarihi</th>
                                        <th>Oluşturulma Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['task']) ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td><?= htmlspecialchars($row['due_date'] ?? '-') ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editTodoModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>">
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Todo Modal -->
<div class="modal fade" id="addTodoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni To-Do Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="task" class="form-label">Görev</label>
                        <textarea class="form-control" id="task" name="task" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Durum</label>
                        <select class="form-select" id="status" name="status">
                            <option value="Beklemede">Beklemede</option>
                            <option value="Tamamlandı">Tamamlandı</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Vade Tarihi</label>
                        <input type="date" class="form-control" id="due_date" name="due_date">
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

<!-- Edit Todo Modal -->
<div class="modal fade" id="editTodoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">To-Do Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_task" class="form-label">Görev</label>
                        <textarea class="form-control" id="edit_task" name="task" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Durum</label>
                        <select class="form-select" id="edit_status" name="status">
                            <option value="Beklemede">Beklemede</option>
                            <option value="Tamamlandı">Tamamlandı</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_due_date" class="form-label">Vade Tarihi</label>
                        <input type="date" class="form-control" id="edit_due_date" name="due_date">
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

<?php include ROOT_PATH . '/views/partials/script.php'; ?>

<script>
$(document).ready(function() {
    $('#task, #edit_task').summernote({
        placeholder: 'Görevinizi buraya yazın...',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    $('#todoTable').DataTable({
        language: { "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json" },
        "order": [[ 3, "desc" ]], // Oluşturulma Tarihine göre sırala
        columnDefs: [ { orderable: false, targets: 4 } ]
    });

    // Add Form with SweetAlert
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_todo.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#addTodoModal').modal('hide');
                    Swal.fire('Başarılı!', 'Görev başarıyla eklendi.', 'success').then(() => location.reload());
                } else {
                    Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                }
            }
        });
    });

    // Edit Button
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_todo.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const todo = response.data;
                    $('#edit_id').val(todo.id);
                    $('#edit_task').summernote('code', todo.task);
                    $('#edit_status').val(todo.status);
                    $('#edit_due_date').val(todo.due_date);
                    $('#editTodoModal').modal('show');
                } else {
                    Swal.fire('Hata!', 'Veri getirilemedi.', 'error');
                }
            }
        });
    });

    // Edit Form with SweetAlert
    $('#editForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/update_todo.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#editTodoModal').modal('hide');
                    Swal.fire('Başarılı!', 'Görev başarıyla güncellendi.', 'success').then(() => location.reload());
                } else {
                    Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                }
            }
        });
    });

    // Delete Button with SweetAlert
    $('.delete-btn').click(function() {
        const button = $(this);
        const id = button.data('id');
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu görevi silmek istediğinizden emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'ajax/delete_todo.php',
                    type: 'POST',
                    data: { id: id, csrf_token: '<?= $csrf_token ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var table = $('#todoTable').DataTable();
                            table.row(button.parents('tr')).remove().draw();
                            Swal.fire('Silindi!', 'Görev başarıyla silindi.', 'success');
                        } else {
                            Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                        }
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>
