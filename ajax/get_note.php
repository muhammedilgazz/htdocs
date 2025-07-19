<?php
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/models/Note.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $note_model = new Note();
    $id = (int)$_POST['id'];

    $note = $note_model->getById($id);

    if ($note) {
        json_response(['success' => true, 'data' => $note]);
    } else {
        json_response(['success' => false, 'message' => 'Not bulunamadı.'], 404);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
