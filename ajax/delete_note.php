<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Note.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $note_model = new Note();
    $id = (int)$_POST['id'];

    if ($note_model->delete($id)) {
        json_response(['success' => true, 'message' => 'Not başarıyla silindi.']);
    } else {
        json_response(['success' => false, 'message' => 'Not silinirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
