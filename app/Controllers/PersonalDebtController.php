<?php

namespace App\Controllers;

use App\Models\PersonalDebt;

class PersonalDebtController {
    private $personalDebtModel;

    public function __construct(PersonalDebt $personalDebtModel) {
        $this->personalDebtModel = $personalDebtModel;
    }

    /**
     * AJAX: Şahıs borcu güncelleme
     * POST: id, to_whom, amount, due_date, paid, remaining, planned_payment_date, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'to_whom' => sanitize_input($_POST['to_whom'] ?? ''),
            'amount' => (float)($_POST['amount'] ?? 0),
            'due_date' => sanitize_input($_POST['due_date'] ?? null),
            'paid' => (float)($_POST['paid'] ?? 0),
            'remaining' => (float)($_POST['remaining'] ?? 0),
            'planned_payment_date' => sanitize_input($_POST['planned_payment_date'] ?? null)
        ];
        if ($this->personalDebtModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Şahıs borcu başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Şahıs borcu güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Şahıs borcu bilgisi getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $debt = $this->personalDebtModel->getById($id);
        if ($debt) {
            return ['success' => true, 'data' => $debt];
        } else {
            return ['success' => false, 'message' => 'Şahıs borcu bulunamadı.'];
        }
    }

    /**
     * AJAX: Şahıs borcu ekleme
     * POST: to_whom, amount, due_date, paid, remaining, planned_payment_date, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'to_whom' => sanitize_input($_POST['to_whom'] ?? ''),
            'amount' => (float)($_POST['amount'] ?? 0),
            'due_date' => sanitize_input($_POST['due_date'] ?? null),
            'paid' => (float)($_POST['paid'] ?? 0),
            'remaining' => (float)($_POST['remaining'] ?? 0),
            'planned_payment_date' => sanitize_input($_POST['planned_payment_date'] ?? null)
        ];
        if ($this->personalDebtModel->add($data)) {
            return ['success' => true, 'message' => 'Şahıs borcu başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Şahıs borcu eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Şahıs borcu silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->personalDebtModel->delete($id)) {
            return ['success' => true, 'message' => 'Şahıs borcu başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Şahıs borcu silinirken bir hata oluştu.'];
        }
    }
} 