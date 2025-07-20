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

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Geçersiz ID.']);
    exit;
}

$account_credential_model = new AccountCredential();
$credential = $account_credential_model->getById($id);

if ($credential) {
    // Güvenlik için şifre hash'ini frontend'e gönderme
    unset($credential['password_hash']);
    echo json_encode(['success' => true, 'data' => $credential]);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Hesap bilgisi bulunamadı.']);
}
