<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Note.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $note_model = new Note();
    
    $id = (int)$_POST['id'];
    $data = [
        'title' => sanitize_input($_POST['title']),
        'content' => sanitize_input($_POST['content']),
        'category' => sanitize_input($_POST['category']) ?? 'Genel',
        'priority' => sanitize_input($_POST['priority']) ?? 'medium',
        'status' => sanitize_input($_POST['status']) ?? 'active'
    ];

    if ($note_model->update($id, $data)) {
        json_response(['success' => true, 'message' => 'Not başarıyla güncellendi.']);
    } else {
        json_response(['success' => false, 'message' => 'Not güncellenirken bir hata oluştu.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}
