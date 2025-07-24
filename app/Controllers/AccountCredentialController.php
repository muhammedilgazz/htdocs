<?php

namespace App\Controllers;

use App\Models\AccountCredential;

class AccountCredentialController {
    private $accountCredentialModel;

    public function __construct(AccountCredential $accountCredentialModel) {
        $this->accountCredentialModel = $accountCredentialModel;
    }

    /**
     * AJAX: Yeni hesap bilgisi ekleme
     * POST: platform_name, username, password_hash, login_url, account_type_id, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
            return ['success' => false, 'message' => 'Geçersiz istek veya CSRF token.'];
        }
        if (empty($_POST['platform_name']) || empty($_POST['username']) || empty($_POST['password_hash'])) {
            return ['success' => false, 'message' => 'Platform, kullanıcı adı ve şifre alanları zorunludur.'];
        }
        $data = [
            'user_id' => $_SESSION['user_id'] ?? 1,
            'platform_name' => sanitize_input($_POST['platform_name']),
            'username' => sanitize_input($_POST['username']),
            'password_hash' => password_hash(sanitize_input($_POST['password_hash']), PASSWORD_DEFAULT),
            'login_url' => isset($_POST['login_url']) ? filter_var($_POST['login_url'], FILTER_SANITIZE_URL) : null,
            'account_type_id' => isset($_POST['account_type_id']) ? (int)$_POST['account_type_id'] : 6
        ];
        if ($this->accountCredentialModel->add($data)) {
            return ['success' => true, 'message' => 'Hesap bilgisi başarıyla eklendi.'];
        } else {
            return ['success' => false, 'message' => 'Hesap bilgisi eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Hesap bilgisi güncelleme
     * POST: id, platform_name, username, password_hash (opsiyonel), login_url, account_type_id, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
            return ['success' => false, 'message' => 'Geçersiz istek veya CSRF token.'];
        }
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0 || empty($_POST['platform_name']) || empty($_POST['username'])) {
            return ['success' => false, 'message' => 'Eksik veya geçersiz parametreler.'];
        }
        $data = [
            'platform_name' => sanitize_input($_POST['platform_name']),
            'username' => sanitize_input($_POST['username']),
            'login_url' => isset($_POST['login_url']) ? filter_var($_POST['login_url'], FILTER_SANITIZE_URL) : null,
            'account_type_id' => isset($_POST['account_type_id']) ? (int)$_POST['account_type_id'] : 6
        ];
        if (!empty($_POST['password_hash'])) {
            $data['password_hash'] = password_hash(sanitize_input($_POST['password_hash']), PASSWORD_DEFAULT);
        }
        if ($this->accountCredentialModel->update($id, $data)) {
            return ['success' => true, 'message' => 'Hesap bilgisi başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Hesap bilgisi güncellenirken bir hata oluştu.'];
        }
    }
} 