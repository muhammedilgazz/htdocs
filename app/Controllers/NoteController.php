<?php

namespace App\Controllers;

use App\Models\Note;

class NoteController {
    private $noteModel;

    public function __construct(Note $noteModel)
    {
        $this->noteModel = $noteModel;
    }

    public function index() {
        $rows = $this->noteModel->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/notes/index.php';
    }

    /**
     * AJAX: Not ekleme
     * POST: title, content, category, priority, status, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'title' => sanitize_input($_POST['title'] ?? ''),
            'content' => sanitize_input($_POST['content'] ?? ''),
            'category' => sanitize_input($_POST['category'] ?? 'Genel'),
            'priority' => sanitize_input($_POST['priority'] ?? 'medium'),
            'status' => sanitize_input($_POST['status'] ?? 'active')
        ];
        if ($this->noteModel->add($data)) {
            return ['success' => true, 'message' => 'Not başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Not eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Not güncelleme
     * POST: id, title, content, category, priority, status, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'title' => sanitize_input($_POST['title'] ?? ''),
            'content' => sanitize_input($_POST['content'] ?? ''),
            'category' => sanitize_input($_POST['category'] ?? 'Genel'),
            'priority' => sanitize_input($_POST['priority'] ?? 'medium'),
            'status' => sanitize_input($_POST['status'] ?? 'active')
        ];
        if ($this->noteModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Not başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Not güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Not silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->noteModel->delete($id)) {
            return ['success' => true, 'message' => 'Not başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Not silinirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Not getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $note = $this->noteModel->getById($id);
        if ($note) {
            return ['success' => true, 'data' => $note];
        } else {
            return ['success' => false, 'message' => 'Not bulunamadı.'];
        }
    }
}
