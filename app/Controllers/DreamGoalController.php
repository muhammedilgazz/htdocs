<?php

namespace App\Controllers;

use App\Models\DreamGoal;

class DreamGoalController {
    private $dreamGoalModel;

    public function __construct(DreamGoal $dreamGoalModel)
    {
        $this->dreamGoalModel = $dreamGoalModel;
    }

    public function index() {
        $rows = $this->dreamGoalModel->getAll();

        $summary = [
            'personal' => $this->dreamGoalModel->getDreamGoalAmountByOwner('Şahsi'),
            'timdesigners' => $this->dreamGoalModel->getDreamGoalAmountByOwner('Timdesigners'),
            'rentakar' => $this->dreamGoalModel->getDreamGoalAmountByOwner('RentAkar'),
            'total' => $this->dreamGoalModel->getTotalDreamGoalAmount()
        ];

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/dream_goals/index.php';
    }

    /**
     * AJAX: Hayal/Hedef getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $goal = $this->dreamGoalModel->getById($id);
        if ($goal) {
            return ['success' => true, 'data' => $goal];
        } else {
            return ['success' => false, 'message' => 'Hayal/Hedef bulunamadı.'];
        }
    }

    /**
     * AJAX: Hayal/Hedef ekleme
     * POST: goal_name, target_amount, product_link, priority, progress, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'goal_name' => sanitize_input($_POST['goal_name'] ?? ''),
            'target_amount' => (float)($_POST['target_amount'] ?? 0),
            'product_link' => sanitize_input($_POST['product_link'] ?? null),
            'priority' => (int)($_POST['priority'] ?? null),
            'progress' => (int)($_POST['progress'] ?? 0)
        ];
        if ($this->dreamGoalModel->add($data)) {
            return ['success' => true, 'message' => 'Hayal/Hedef başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Hayal/Hedef eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Hayal/Hedef güncelleme
     * POST: id, goal_name, target_amount, product_link, priority, progress, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'goal_name' => sanitize_input($_POST['goal_name'] ?? ''),
            'target_amount' => (float)($_POST['target_amount'] ?? 0),
            'product_link' => sanitize_input($_POST['product_link'] ?? null),
            'priority' => (int)($_POST['priority'] ?? null),
            'progress' => (int)($_POST['progress'] ?? 0)
        ];
        if ($this->dreamGoalModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Hayal/Hedef başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Hayal/Hedef güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Hayal/Hedef silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->dreamGoalModel->delete($id)) {
            return ['success' => true, 'message' => 'Hayal/Hedef başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Hayal/Hedef silinirken bir hata oluştu.'];
        }
    }
}
