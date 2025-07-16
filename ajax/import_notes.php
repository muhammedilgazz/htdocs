<?php
require_once 'C:/xampp/htdocs/config/config.php';
require_once 'C:/xampp/htdocs/models/Note.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && validate_csrf_token($_POST['csrf_token'])) {
    $note_model = new Note();
    $notes_text = $_POST['notesText'] ?? '';
    $category = sanitize_input($_POST['notesCategory']) ?? 'Genel';
    $lines = explode("\n", $notes_text);
    $success_count = 0;
    $error_count = 0;

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        $data = [
            'title' => substr($line, 0, 200), // İlk 200 karakteri başlık yap
            'content' => $line,
            'category' => $category,
            'priority' => 'medium',
            'status' => 'active'
        ];

        if ($note_model->add($data)) {
            $success_count++;
        } else {
            $error_count++;
        }
    }

    if ($success_count > 0) {
        json_response(['success' => true, 'message' => $success_count . ' not başarıyla içe aktarıldı. ' . $error_count . ' notta hata oluştu.']);
    } else {
        json_response(['success' => false, 'message' => 'Hiçbir not içe aktarılamadı.'], 500);
    }
} else {
    json_response(['success' => false, 'message' => 'Geçersiz istek.'], 400);
}