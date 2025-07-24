<?php

namespace App\Controllers;

use App\Models\Project;

class ProjectController {
    private $projectModel;

    public function __construct(Project $projectModel)
    {
        $this->projectModel = $projectModel;
    }

    public function index() {
        $rows = $this->projectModel->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/projects/index.php';
    }

    /**
     * AJAX: Proje silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->projectModel->delete($id)) {
            return ['success' => true, 'message' => 'Proje başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Proje silinirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Proje getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $project = $this->projectModel->getById($id);
        if ($project) {
            return ['success' => true, 'data' => $project];
        } else {
            return ['success' => false, 'message' => 'Proje bulunamadı.'];
        }
    }

    /**
     * AJAX: Proje güncelleme
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
        if ($this->projectModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Proje başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Proje güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Proje ekleme
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
        if ($this->projectModel->add($data)) {
            return ['success' => true, 'message' => 'Proje başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Proje eklenirken bir hata oluştu.'];
        }
    }
}
