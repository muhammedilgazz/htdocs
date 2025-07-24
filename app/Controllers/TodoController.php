<?php

namespace App\Controllers;

use App\Models\Todo;
use Exception;

class TodoController
{
    private $todo_model;

    // Bağımlılığı constructor üzerinden enjekte et
    public function __construct(Todo $todo_model)
    {
        $this->todo_model = $todo_model;
    }

    public function index()
    {
        $todos = $this->todo_model->getAll();
        require ROOT_PATH . '/views/todo_list/index.php';
    }

    /**
     * AJAX isteği ile yeni bir yapılacaklar öğesi ekler.
     * @return array JSON yanıtı
     */
    public function ajax_add()
    {
        // CSRF ve method kontrolü bootstrap.php ve ajax.php'de yapıldığı için burada tekrar gerekmez.
        
        $task = trim($_POST['task'] ?? '');
        $due_date = $_POST['due_date'] ?? null;

        if (empty($task)) {
            http_response_code(400); // Bad Request
            return ['status' => 'error', 'message' => 'Görev boş olamaz!'];
        }

        try {
            $data = [
                'task' => $task,
                'status' => 'Beklemede', // Varsayılan durum
                'due_date' => $due_date
            ];

            if ($this->todo_model->add($data)) {
                return ['status' => 'success', 'message' => 'Görev başarıyla eklendi.'];
            } else {
                http_response_code(500); // Internal Server Error
                return ['status' => 'error', 'message' => 'Görev eklenirken bir hata oluştu.'];
            }
        } catch (Exception $e) {
            error_log("AJAX Add Todo Error: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            return ['status' => 'error', 'message' => 'Sunucu tarafında bir hata oluştu.'];
        }
    }

    /**
     * AJAX: To-Do getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $todo = $this->todo_model->getById($id);
        if ($todo) {
            return ['success' => true, 'data' => $todo];
        } else {
            return ['success' => false, 'message' => 'To-Do bulunamadı.'];
        }
    }

    /**
     * AJAX: To-Do güncelleme
     * POST: id, task, status, due_date, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'task' => sanitize_input($_POST['task'] ?? ''),
            'status' => sanitize_input($_POST['status'] ?? 'Beklemede'),
            'due_date' => sanitize_input($_POST['due_date'] ?? null)
        ];
        if ($this->todo_model->update($id, $data)) {
            return ['success' => true, 'message' => 'To-Do başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'To-Do güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: To-Do silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->todo_model->delete($id)) {
            return ['success' => true, 'message' => 'To-Do başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'To-Do silinirken bir hata oluştu.'];
        }
    }
}