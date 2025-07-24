<?php

namespace App\Controllers;

use App\Models\Task;

class TaskController {
    private $taskModel;

    public function __construct(Task $taskModel)
    {
        $this->taskModel = $taskModel;
    }

    public function index() {
        $rows = $this->taskModel->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/tasks/index.php';
    }

    /**
     * AJAX: Görev ekleme
     * POST: description, amount, date, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'description' => sanitize_input($_POST['description'] ?? ''),
            'amount' => (float)($_POST['amount'] ?? 0),
            'date' => sanitize_input($_POST['date'] ?? date('Y-m-d'))
        ];
        if ($this->taskModel->add($data)) {
            return ['success' => true, 'message' => 'Görev başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Görev eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Görev güncelleme
     * POST: id, description, amount, date, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'description' => sanitize_input($_POST['description'] ?? ''),
            'amount' => (float)($_POST['amount'] ?? 0),
            'date' => sanitize_input($_POST['date'] ?? date('Y-m-d'))
        ];
        if ($this->taskModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Görev başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Görev güncellenirken bir hata oluştu.'];
        }
    }
}
