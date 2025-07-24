<?php

namespace App\Controllers;

use App\Models\AccountCredential;
use App\Models\UIHelper;

class AccountPasswordController {
    private $accountCredentialModel;

    public function __construct(AccountCredential $accountCredentialModel)
    {
        $this->accountCredentialModel = $accountCredentialModel;
    }

    public function index() {
        $rows = $this->accountCredentialModel->getAll();
        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/account_passwords/index.php';
    }

    /**
     * AJAX: Hesap şifresi getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            return ['success' => false, 'message' => 'Geçersiz hesap ID'];
        }
        $account_data = $this->accountCredentialModel->getById($id);
        if (!$account_data) {
            return ['success' => false, 'message' => 'Hesap bulunamadı'];
        }
        return ['success' => true, 'data' => $account_data];
    }

    /**
     * AJAX: Hesap şifresi silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->accountCredentialModel->delete($id)) {
            return ['success' => true, 'message' => 'Hesap bilgisi başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Hesap bilgisi silinirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Hesap şifresi güncelleme
     * POST: id, platform_name, username, password_hash, login_url, account_type_id, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'platform_name' => sanitize_input($_POST['platform_name'] ?? ''),
            'username' => sanitize_input($_POST['username'] ?? ''),
            'password_hash' => password_hash(sanitize_input($_POST['password_hash'] ?? ''), PASSWORD_DEFAULT),
            'login_url' => sanitize_input($_POST['login_url'] ?? null),
            'account_type_id' => (int)($_POST['account_type_id'] ?? 6)
        ];
        if ($this->accountCredentialModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Hesap bilgisi başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Hesap bilgisi güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Hesap şifresi ekleme
     * POST: platform_name, username, password_hash, login_url, account_type_id, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'platform_name' => sanitize_input($_POST['platform_name'] ?? ''),
            'username' => sanitize_input($_POST['username'] ?? ''),
            'password_hash' => password_hash(sanitize_input($_POST['password_hash'] ?? ''), PASSWORD_DEFAULT),
            'login_url' => sanitize_input($_POST['login_url'] ?? null),
            'account_type_id' => (int)($_POST['account_type_id'] ?? 6)
        ];
        if ($this->accountCredentialModel->add($data)) {
            return ['success' => true, 'message' => 'Hesap bilgisi başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Hesap bilgisi eklenirken bir hata oluştu.'];
        }
    }
}