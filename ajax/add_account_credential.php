<?php
require_once '../bootstrap.php';

use App\Models\AccountCredential;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Geçersiz istek metodu.']);
    exit;
}

if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Geçersiz CSRF token.']);
    exit;
}

if (empty($_POST['platform_name']) || empty($_POST['username']) || empty($_POST['password_hash'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Platform, kullanıcı adı ve şifre alanları zorunludur.']);
    exit;
}

$data = [
    'user_id' => $_SESSION['user_id'] ?? 1,
    'platform_name' => sanitize_input($_POST['platform_name']),
    'username' => sanitize_input($_POST['username']),
    'password_hash' => password_hash(sanitize_input($_POST['password_hash']), PASSWORD_DEFAULT),
    'login_url' => isset($_POST['login_url']) ? filter_var($_POST['login_url'], FILTER_SANITIZE_URL) : null,
    'account_type_id' => isset($_POST['account_type_id']) ? (int)$_POST['account_type_id'] : 6
];

$account_credential_model = new AccountCredential();

if ($account_credential_model->add($data)) {
    echo json_encode(['success' => true, 'message' => 'Hesap bilgisi başarıyla eklendi.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Hesap bilgisi eklenirken bir hata oluştu.']);
}
