<?php

namespace App\Controllers;

use App\Models\SgkDebt;

class SgkDebtController {
    private $sgkDebtModel;

    public function __construct(SgkDebt $sgkDebtModel) {
        $this->sgkDebtModel = $sgkDebtModel;
    }

    /**
     * AJAX: SGK borcu getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $debt = $this->sgkDebtModel->getById($id);
        if ($debt) {
            return ['success' => true, 'data' => $debt];
        } else {
            return ['success' => false, 'message' => 'SGK borcu bulunamadı.'];
        }
    }

    /**
     * AJAX: SGK borcu ekleme
     * POST: owner, period, principal, interest, total, payment_due, planned_payment, paid, remaining, this_month_payment, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'owner' => sanitize_input($_POST['owner'] ?? ''),
            'period' => sanitize_input($_POST['period'] ?? null),
            'principal' => (float)($_POST['principal'] ?? 0),
            'interest' => (float)($_POST['interest'] ?? 0),
            'total' => (float)($_POST['total'] ?? 0),
            'payment_due' => sanitize_input($_POST['payment_due'] ?? null),
            'planned_payment' => (float)($_POST['planned_payment'] ?? 0),
            'paid' => (float)($_POST['paid'] ?? 0),
            'remaining' => (float)($_POST['remaining'] ?? 0),
            'this_month_payment' => (float)($_POST['this_month_payment'] ?? 0)
        ];
        if ($this->sgkDebtModel->add($data)) {
            return ['success' => true, 'message' => 'SGK borcu başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'SGK borcu eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: SGK borcu güncelleme
     * POST: id, owner, period, principal, interest, total, payment_due, planned_payment, paid, remaining, this_month_payment, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'owner' => sanitize_input($_POST['owner'] ?? ''),
            'period' => sanitize_input($_POST['period'] ?? null),
            'principal' => (float)($_POST['principal'] ?? 0),
            'interest' => (float)($_POST['interest'] ?? 0),
            'total' => (float)($_POST['total'] ?? 0),
            'payment_due' => sanitize_input($_POST['payment_due'] ?? null),
            'planned_payment' => (float)($_POST['planned_payment'] ?? 0),
            'paid' => (float)($_POST['paid'] ?? 0),
            'remaining' => (float)($_POST['remaining'] ?? 0),
            'this_month_payment' => (float)($_POST['this_month_payment'] ?? 0)
        ];
        if ($this->sgkDebtModel->update($id, $data)) {
            return ['success' => true, 'message' => 'SGK borcu başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'SGK borcu güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: SGK borcu silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->sgkDebtModel->delete($id)) {
            return ['success' => true, 'message' => 'SGK borcu başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'SGK borcu silinirken bir hata oluştu.'];
        }
    }
} 