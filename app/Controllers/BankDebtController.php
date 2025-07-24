<?php

namespace App\Controllers;

use App\Models\BankDebt;

class BankDebtController {
    private $bankDebtModel;

    public function __construct(BankDebt $bankDebtModel) {
        $this->bankDebtModel = $bankDebtModel;
    }

    /**
     * AJAX: Banka borcu getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $debt = $this->bankDebtModel->getById($id);
        if ($debt) {
            return ['success' => true, 'data' => $debt];
        } else {
            return ['success' => false, 'message' => 'Banka borcu bulunamadı.'];
        }
    }

    /**
     * AJAX: Banka borcu ekleme
     * POST: bank_name, loan_type, principal, total, is_legal_process, asset_company, is_installment, planned_payment_date, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'bank_name' => sanitize_input($_POST['bank_name'] ?? ''),
            'loan_type' => sanitize_input($_POST['loan_type'] ?? null),
            'principal' => (float)($_POST['principal'] ?? 0),
            'total' => (float)($_POST['total'] ?? 0),
            'is_legal_process' => isset($_POST['is_legal_process']) ? 1 : 0,
            'asset_company' => sanitize_input($_POST['asset_company'] ?? null),
            'is_installment' => isset($_POST['is_installment']) ? 1 : 0,
            'planned_payment_date' => sanitize_input($_POST['planned_payment_date'] ?? null)
        ];
        if ($this->bankDebtModel->add($data)) {
            return ['success' => true, 'message' => 'Banka borcu başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Banka borcu eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Banka borcu güncelleme
     * POST: id, bank_name, loan_type, principal, total, is_legal_process, asset_company, is_installment, planned_payment_date, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'bank_name' => sanitize_input($_POST['bank_name'] ?? ''),
            'loan_type' => sanitize_input($_POST['loan_type'] ?? null),
            'principal' => (float)($_POST['principal'] ?? 0),
            'total' => (float)($_POST['total'] ?? 0),
            'is_legal_process' => isset($_POST['is_legal_process']) ? 1 : 0,
            'asset_company' => sanitize_input($_POST['asset_company'] ?? null),
            'is_installment' => isset($_POST['is_installment']) ? 1 : 0,
            'planned_payment_date' => sanitize_input($_POST['planned_payment_date'] ?? null)
        ];
        if ($this->bankDebtModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Banka borcu başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Banka borcu güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Banka borcu silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->bankDebtModel->delete($id)) {
            return ['success' => true, 'message' => 'Banka borcu başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Banka borcu silinirken bir hata oluştu.'];
        }
    }
} 