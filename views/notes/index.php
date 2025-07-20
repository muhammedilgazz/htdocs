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
                $page_title = 'Notlar';
                $page_description = 'Notlarınızı yönetin ve takip edin.';
                $breadcrumb_active = 'Notlar';
                include ROOT_PATH . '/views/partials/page_header.php';
                ?>
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="bi bi-plus-circle me-2"></i>Yeni Not Ekle
                    </button>
                </div>

                <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">
                        <i class="bi bi-sticky"></i>
                    </div>
                    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">Henüz not kaydı yok</h4>
                    <p style="color: #a0a8c0; margin-bottom: 2rem;">Notlarınızı ekleyerek takip etmeye başlayın.</p>
                </div>
                <?php else: ?>
                <div class="card p-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Notlar Listesi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Başlık</th>
                                        <th>İçerik</th>
                                        <th>Kategori</th>
                                        <th>Öncelik</th>
                                        <th>Durum</th>
                                        <th>Oluşturulma Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['title']) ?></td>
                                        <td><?= htmlspecialchars($row['content']) ?></td>
                                        <td><?= htmlspecialchars($row['category']) ?></td>
                                        <td><?= htmlspecialchars($row['priority']) ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td><?= date('d.m.Y H:i', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-outline-primary btn-sm edit-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#editNoteModal">
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

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Not Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Başlık</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">İçerik</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" id="category" name="category">
                            <option value="Genel">Genel</option>
                            <option value="Alışveriş">Alışveriş</option>
                            <option value="Fikirler">Fikirler</option>
                            <option value="Hatırlatmalar">Hatırlatmalar</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Öncelik</label>
                        <select class="form-select" id="priority" name="priority">
                            <option value="low">Düşük</option>
                            <option value="medium">Orta</option>
                            <option value="high">Yüksek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Durum</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active">Aktif</option>
                            <option value="archived">Arşivlendi</option>
                            <option value="deleted">Silindi</option>
                        </select>
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

<!-- Edit Note Modal -->
<div class="modal fade" id="editNoteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notu Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Başlık</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_content" class="form-label">İçerik</label>
                        <textarea class="form-control" id="edit_content" name="content" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Kategori</label>
                        <select class="form-select" id="edit_category" name="category">
                            <option value="Genel">Genel</option>
                            <option value="Alışveriş">Alışveriş</option>
                            <option value="Fikirler">Fikirler</option>
                            <option value="Hatırlatmalar">Hatırlatmalar</option>
                            <option value="Diğer">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_priority" class="form-label">Öncelik</label>
                        <select class="form-select" id="edit_priority" name="priority">
                            <option value="low">Düşük</option>
                            <option value="medium">Orta</option>
                            <option value="high">Yüksek</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Durum</label>
                        <select class="form-select" id="edit_status" name="status">
                            <option value="active">Aktif</option>
                            <option value="archived">Arşivlendi</option>
                            <option value="deleted">Silindi</option>
                        </select>
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
    // Add Form
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax/add_note.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Bir hata oluştu.');
                }
            }
        });
    });

    // Edit Button
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/get_note.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const note = response.data;
                    $('#edit_id').val(note.id);
                    $('#edit_title').val(note.title);
                    $('#edit_content').val(note.content);
                    $('#edit_category').val(note.category);
                    $('#edit_priority').val(note.priority);
                    $('#edit_status').val(note.status);
                    $('#editNoteModal').modal('show');
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
            url: 'ajax/update_note.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Bir hata oluştu.');
                }
            }
        });
    });

    // Delete Button
    $('.delete-btn').click(function() {
        if (!confirm('Bu notu silmek istediğinizden emin misiniz?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'ajax/delete_note.php',
            type: 'POST',
            data: { id: id, csrf_token: '<?= $csrf_token ?>' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Bir hata oluştu.');
                }
            }
        });
    });
});
</script>

</body>
</html>
