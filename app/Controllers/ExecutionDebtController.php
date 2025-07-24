<?php

namespace App\Controllers;

use App\Models\ExecutionDebt;

class ExecutionDebtController {
    private $executionDebtModel;

    public function __construct(ExecutionDebt $executionDebtModel) {
        $this->executionDebtModel = $executionDebtModel;
    }

    /**
     * AJAX: İcra borcu getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $debt = $this->executionDebtModel->getById($id);
        if ($debt) {
            return ['success' => true, 'data' => $debt];
        } else {
            return ['success' => false, 'message' => 'İcra borcu bulunamadı.'];
        }
    }

    /**
     * AJAX: İcra borcu ekleme
     * POST: owner, creditor, execution_office, start_date, current_debt, principal_debt, contact_info, status, planned_payment, this_month_payment, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'owner' => sanitize_input($_POST['owner'] ?? ''),
            'creditor' => sanitize_input($_POST['creditor'] ?? null),
            'execution_office' => sanitize_input($_POST['execution_office'] ?? null),
            'start_date' => sanitize_input($_POST['start_date'] ?? null),
            'current_debt' => (float)($_POST['current_debt'] ?? 0),
            'principal_debt' => (float)($_POST['principal_debt'] ?? 0),
            'contact_info' => sanitize_input($_POST['contact_info'] ?? null),
            'status' => sanitize_input($_POST['status'] ?? null),
            'planned_payment' => (float)($_POST['planned_payment'] ?? 0),
            'this_month_payment' => (float)($_POST['this_month_payment'] ?? 0)
        ];
        if ($this->executionDebtModel->add($data)) {
            return ['success' => true, 'message' => 'İcra borcu başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'İcra borcu eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: İcra borcu güncelleme
     * POST: id, owner, creditor, execution_office, start_date, current_debt, principal_debt, contact_info, status, planned_payment, this_month_payment, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'owner' => sanitize_input($_POST['owner'] ?? ''),
            'creditor' => sanitize_input($_POST['creditor'] ?? null),
            'execution_office' => sanitize_input($_POST['execution_office'] ?? null),
            'start_date' => sanitize_input($_POST['start_date'] ?? null),
            'current_debt' => (float)($_POST['current_debt'] ?? 0),
            'principal_debt' => (float)($_POST['principal_debt'] ?? 0),
            'contact_info' => sanitize_input($_POST['contact_info'] ?? null),
            'status' => sanitize_input($_POST['status'] ?? null),
            'planned_payment' => (float)($_POST['planned_payment'] ?? 0),
            'this_month_payment' => (float)($_POST['this_month_payment'] ?? 0)
        ];
        if ($this->executionDebtModel->update($id, $data)) {
            return ['success' => true, 'message' => 'İcra borcu başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'İcra borcu güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: İcra borcu silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->executionDebtModel->delete($id)) {
            return ['success' => true, 'message' => 'İcra borcu başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'İcra borcu silinirken bir hata oluştu.'];
        }
    }
} 