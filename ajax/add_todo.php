<?php
require_once __DIR__ . '/../classes/Todo.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $todo_model = new Todo();

    $gorev = $data['gorev'] ?? '';
    $durum = $data['durum'] ?? 'Beklemede';
    $son_tarih = $data['son_tarih'] ?? null;

    if (empty($gorev)) {
        json_response(['success' => false, 'message' => 'Görev alanı zorunludur.'], 400);
    }

    $result = $todo_model->add([
        'gorev' => $gorev,
        'durum' => $durum,
        'son_tarih' => $son_tarih
    ]);

    if ($result) {
        json_response(['success' => true, 'message' => 'To-Do başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'To-Do eklenirken hata oluştu'], 500);
    }
});
