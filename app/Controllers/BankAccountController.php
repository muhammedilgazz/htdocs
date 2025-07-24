<?php

namespace App\Controllers;

use App\Models\BankAccount;

class BankAccountController {
    private $bankAccountModel;

    public function __construct(BankAccount $bankAccountModel)
    {
        $this->bankAccountModel = $bankAccountModel;
    }

    public function index() {
        $all_accounts = $this->bankAccountModel->getAll();
        
        $own_accounts = [];
        $other_accounts = [];

        if (is_array($all_accounts)) {
            foreach ($all_accounts as $account) {
                if ($account['account_type'] === 'own') {
                    $own_accounts[] = $account;
                } else {
                    $other_accounts[] = $account;
                }
            }
        }
        
        $csrf_token = generate_csrf_token();
        
        require_once ROOT_PATH . '/views/bank_account/index.php';
    }

    /**
     * AJAX: Banka hesabı güncelleme
     * POST: id, account_holder, iban_number, easy_address, bank_name, bank_logo, description, account_type, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'account_holder' => sanitize_input($_POST['account_holder'] ?? ''),
            'iban_number' => sanitize_input($_POST['iban_number'] ?? null),
            'easy_address' => sanitize_input($_POST['easy_address'] ?? null),
            'bank_name' => sanitize_input($_POST['bank_name'] ?? ''),
            'bank_logo' => sanitize_input($_POST['bank_logo'] ?? null),
            'description' => sanitize_input($_POST['description'] ?? null),
            'account_type' => sanitize_input($_POST['account_type'] ?? '')
        ];
        if ($this->bankAccountModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Banka hesabı başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Banka hesabı güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Banka hesabı bilgisi getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $account = $this->bankAccountModel->getById($id);
        if ($account) {
            return ['success' => true, 'data' => $account];
        } else {
            return ['success' => false, 'message' => 'Banka hesabı bulunamadı.'];
        }
    }

    /**
     * AJAX: Banka hesabı ekleme
     * POST: account_holder, iban_number, easy_address, bank_name, bank_logo, description, account_type, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'account_holder' => sanitize_input($_POST['account_holder'] ?? ''),
            'iban_number' => sanitize_input($_POST['iban_number'] ?? null),
            'easy_address' => sanitize_input($_POST['easy_address'] ?? null),
            'bank_name' => sanitize_input($_POST['bank_name'] ?? ''),
            'bank_logo' => sanitize_input($_POST['bank_logo'] ?? null),
            'description' => sanitize_input($_POST['description'] ?? null),
            'account_type' => sanitize_input($_POST['account_type'] ?? '')
        ];
        if ($this->bankAccountModel->add($data)) {
            return ['success' => true, 'message' => 'Banka hesabı başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Banka hesabı eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Banka hesabı silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->bankAccountModel->delete($id)) {
            return ['success' => true, 'message' => 'Banka hesabı başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Banka hesabı silinirken bir hata oluştu.'];
        }
    }
}