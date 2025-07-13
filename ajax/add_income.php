<?php
require_once __DIR__ . '/../classes/Income.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';

handle_ajax_request(function($data) {
    $income_model = new Income();

    $kaynak = $data['kaynak'] ?? '';
    $tutar = filter_var($data['tutar'] ?? '', FILTER_VALIDATE_FLOAT);
    $tarih = $data['tarih'] ?? date('Y-m-d');
    $aciklama = $data['aciklama'] ?? '';

    if (empty($kaynak) || $tutar <= 0) {
        json_response(['success' => false, 'message' => 'Kaynak ve tutar zorunludur.'], 400);
    }

    $result = $income_model->add([
        'kaynak' => $kaynak,
        'tutar' => $tutar,
        'tarih' => $tarih,
        'aciklama' => $aciklama
    ]);

    if ($result) {
        json_response(['success' => true, 'message' => 'Gelir başarıyla eklendi']);
    } else {
        json_response(['success' => false, 'message' => 'Gelir eklenirken hata oluştu'], 500);
    }
});
