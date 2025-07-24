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
                <nav aria-label="breadcrumb" class="mt-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Görevlerim</li>
                    </ol>
                </nav>
                <h2 class="mb-4">Görevlerim</h2>
                <!-- Yeni Görev Ekleme Barı -->
                <div class="d-flex justify-content-center mt-3" id="addTodoInputWrapper" style="display: flex; align-items: center;">
                  <input type="text" class="form-control w-50" id="newTodoText" placeholder="Yeni görev girin...">
                  <div class="ms-2">
                    <select class="form-select" id="todoDueDateSelect">
                      <option value="today">Bugün</option>
                      <option value="tomorrow">Yarın</option>
                      <option value="next_week">Haftaya</option>
                      <option value="specific_date">Belirli Gün</option>
                      <option value="no_date">Herhangi Bir Zaman</option>
                    </select>
                    <input type="date" class="form-control mt-2" id="specificDueDate" style="display:none;">
                  </div>
                  <button class="btn btn-primary ms-2" id="addTodoBtn">Ekle</button>
                </div>
                <!-- /Yeni Görev Ekleme Barı -->
                </div>
            <div class="tf-container">
                <div class="mt-24">
                    <div class="tab-slide wrapper-tab-task">
                        <ul class="nav nav-tabs task-tab" role="tablist">
                            <li class="item-slide-effect"></li>
                            <li class="nav-item active" role="presentation">   
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#allTask" aria-selected="true" role="tab">All Tasks</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#progress" aria-selected="false" tabindex="-1" role="tab">In Progress</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completed" aria-selected="false" tabindex="-1" role="tab">Completed</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="allTask" role="tabpanel">
                            <div class="accordion wrap-task-accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item mt-28">
                                    <div class="pb-20 header-task accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        <div class="title-task">
                                            <h6 class="text-black-2">Today Tasks</h6>
                                            <span class="num-task type-1">3</span>
                                        </div>
                                        <span class="icon-more text-black-5"></span>
                                    </div>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                        <ul>
                                            <li class="list-task-item">
                                                <input type="checkbox" id="task1" class="radio-check success" checked="">
                                                <label for="task1" class="content-task">
                                                    <div class="font-title-btn text-black-2">Define Problem with Client</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 12:30 PM - 02:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task2" class="radio-check success">
                                                <label for="task2" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Wireframe and User Flow</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 02:30 PM - 04:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task3" class="radio-check success">
                                                <label for="task3" class="content-task">
                                                    <div class="font-title-btn text-black-2">Project set up & Brief</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 04:30 PM - 06:00 PM</p>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="accordion-item mt-28">
                                    <div class="pb-20 accordion-button header-task" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        <div class="title-task">
                                            <h6 class="text-black-2">Next Tasks</h6>
                                            <span class="num-task type-2">9</span>
                                        </div>
                                        <span class="icon-more text-black-5"></span>
                                    </div>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                        <ul>
                                            <li class="list-task-item">
                                                <input type="checkbox" id="task4" class="radio-check success">
                                                <label for="task4" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Visual Low Fidelity</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Monday, 12:00 PM - 02:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task5" class="radio-check success">
                                                <label for="task5" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Visual High Fidelity</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 02:30 PM - 04:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task10" class="radio-check success">
                                                <label for="task10" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Visual High Fidelity</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 02:30 PM - 04:00 PM</p>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="progress" role="tabpanel">
                            <div class="accordion wrap-task-accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item mt-28">
                                    <div class="pb-20 header-task accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                                        <div class="title-task">
                                            <h6 class="text-black-2">Today Tasks</h6>
                                            <span class="num-task type-1">3</span>
                                        </div>
                                        <span class="icon-more text-black-5"></span>
                                    </div>
                                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingThee">
                                        <ul>
                                            <li class="list-task-item">
                                                <input type="checkbox" id="task6" class="radio-check success" checked="">
                                                <label for="task6" class="content-task">
                                                    <div class="font-title-btn text-black-2">Define Problem with Client</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 12:30 PM - 02:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task7" class="radio-check success">
                                                <label for="task7" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Wireframe and User Flow</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 02:30 PM - 04:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task8" class="radio-check success">
                                                <label for="task8" class="content-task">
                                                    <div class="font-title-btn text-black-2">Project set up & Brief</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 04:30 PM - 06:00 PM</p>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="accordion-item mt-28">
                                    <div class="pb-20 accordion-button header-task" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                                        <div class="title-task">
                                            <h6 class="text-black-2">Next Tasks</h6>
                                            <span class="num-task type-2">9</span>
                                        </div>
                                        <span class="icon-more text-black-5"></span>
                                    </div>
                                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFour">
                                        <ul>
                                            <li class="list-task-item">
                                                <input type="checkbox" id="task9" class="radio-check success">
                                                <label for="task9" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Visual Low Fidelity</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Monday, 12:00 PM - 02:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task10" class="radio-check success">
                                                <label for="task10" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Visual High Fidelity</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 02:30 PM - 04:00 PM</p>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="completed" role="tabpanel">
                            <div class="accordion wrap-task-accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item mt-28">
                                    <div class="pb-20 header-task accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true" aria-controls="panelsStayOpen-collapseFive">
                                        <div class="title-task">
                                            <h6 class="text-black-2">Today Tasks</h6>
                                            <span class="num-task type-1">3</span>
                                        </div>
                                        <span class="icon-more text-black-5"></span>
                                    </div>
                                    <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFive">
                                        <ul>
                                            <li class="list-task-item">
                                                <input type="checkbox" id="task11" class="radio-check success" checked="">
                                                <label for="task11" class="content-task">
                                                    <div class="font-title-btn text-black-2">Define Problem with Client</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 12:30 PM - 02:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task12" class="radio-check success">
                                                <label for="task12" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Wireframe and User Flow</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 02:30 PM - 04:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task13" class="radio-check success">
                                                <label for="task13" class="content-task">
                                                    <div class="font-title-btn text-black-2">Project set up & Brief</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 04:30 PM - 06:00 PM</p>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="accordion-item mt-28">
                                    <div class="pb-20 accordion-button header-task" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
                                        <div class="title-task">
                                            <h6 class="text-black-2">Next Tasks</h6>
                                            <span class="num-task type-2">9</span>
                                        </div>
                                        <span class="icon-more text-black-5"></span>
                                    </div>
                                    <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingSix">
                                        <ul>
                                            <li class="list-task-item">
                                                <input type="checkbox" id="task14" class="radio-check success">
                                                <label for="task14" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Visual Low Fidelity</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Monday, 12:00 PM - 02:00 PM</p>
                                                </label>
                                            </li>
                                            <li class="list-task-item mt-12">
                                                <input type="checkbox" id="task15" class="radio-check success">
                                                <label for="task15" class="content-task">
                                                    <div class="font-title-btn text-black-2">Create Visual High Fidelity</div>
                                                    <p class="mt-10 body-4 text-black-5 fw-5">Saturday, 02:30 PM - 04:00 PM</p>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <label for="task" class="form-label">Görev Başlığı</label>
                        <input type="text" class="form-control" id="task" name="task" required>
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
                        <label for="edit_task" class="form-label">Görev Başlığı</label>
                        <input type="text" class="form-control" id="edit_task" name="task" required>
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
    // Summernote'u kaldır (artık textarea yerine input kullanılıyor)
    // $('#task, #edit_task').summernote({});
 
    $('#todoTable').DataTable({
        language: { "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json" },
        "order": [[ 3, "desc" ]], // Oluşturulma Tarihine göre sırala
        columnDefs: [ { orderable: false, targets: 4 } ]
    });
 
    // Add Form with SweetAlert
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'ajax.php?action=todo_add',
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
            url: 'ajax.php?action=todo_get',
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
            url: 'ajax.php?action=todo_update',
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
                    url: 'ajax.php?action=todo_delete',
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
<div class="d-flex justify-content-center mt-3" id="addTodoInputWrapper" style="display:none; align-items: center;">
  <input type="text" class="form-control w-50" id="newTodoText" placeholder="Yeni görev girin...">
  <div class="ms-2">
    <select class="form-select" id="todoDueDateSelect">
      <option value="today">Bugün</option>
      <option value="tomorrow">Yarın</option>
      <option value="next_week">Haftaya</option>
      <option value="specific_date">Belirli Gün</option>
      <option value="no_date">Herhangi Bir Zaman</option>
    </select>
    <input type="date" class="form-control mt-2" id="specificDueDate" style="display:none;">
  </div>
  <button class="btn btn-primary ms-2" id="addTodoBtn">Ekle</button>
</div>
<script>
  document.getElementById('showAddTodoInput').onclick = function() {
    document.getElementById('addTodoInputWrapper').style.display = 'flex';
    document.getElementById('newTodoText').focus();
  };
 
  const todoDueDateSelect = document.getElementById('todoDueDateSelect');
  const specificDueDateInput = document.getElementById('specificDueDate');
 
  todoDueDateSelect.addEventListener('change', function() {
    if (this.value === 'specific_date') {
      specificDueDateInput.style.display = 'block';
    } else {
      specificDueDateInput.style.display = 'none';
    }
  });
 
  document.getElementById('addTodoBtn').onclick = function() {
    var text = document.getElementById('newTodoText').value.trim();
    if (!text) {
      showError('Lütfen bir görev girin!');
      return;
    }
 
    let dueDate = null;
    const selectedOption = todoDueDateSelect.value;
    if (selectedOption === 'today') {
      dueDate = new Date().toISOString().slice(0, 10);
    } else if (selectedOption === 'tomorrow') {
      const tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      dueDate = tomorrow.toISOString().slice(0, 10);
    } else if (selectedOption === 'next_week') {
      const nextWeek = new Date();
      nextWeek.setDate(nextWeek.getDate() + 7);
      dueDate = nextWeek.toISOString().slice(0, 10);
    } else if (selectedOption === 'specific_date') {
      dueDate = specificDueDateInput.value;
      if (!dueDate) {
        showWarning('Lütfen belirli bir tarih seçin veya başka bir zamanlama seçeneği belirleyin.');
        return;
      }
    }
 
    const formData = new URLSearchParams();
    formData.append('task', text);
    if (dueDate) {
      formData.append('due_date', dueDate);
    }
 
    fetch('ajax.php?action=todo_add', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: formData.toString()
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        showSuccess(data.message || 'Görev başarıyla eklendi.');
        location.reload();
      } else {
        showError(data.message || 'Hata oluştu!');
      }
    })
    .catch(error => {
      showError('Bağlantı hatası oluştu!');
      console.error('Error:', error);
    });
  };
</script>
 
</body>
</html>
