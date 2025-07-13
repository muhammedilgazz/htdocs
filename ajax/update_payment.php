<?php
require_once __DIR__ . '/../classes/Payment.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';
require_once __DIR__ . '/../classes/Database.php'; // Bakiye güncellemesi için Database sınıfına ihtiyaç var

handle_ajax_request(function($data) {
    $payment = new Payment();
    $db = Database::getInstance();

    $id = filter_var($data['id'] ?? '', FILTER_VALIDATE_INT);
    $durum = $data['durum'] ?? '';

    if (!$id || !$durum) {
        json_response(['success' => false, 'message' => 'Geçersiz parametreler'], 400);
    }

    $valid_statuses = ['Ödendi', 'Beklemede', 'Planlandı', 'Gecikmiş'];
    if (!in_array($durum, $valid_statuses)) {
        json_response(['success' => false, 'message' => 'Geçersiz durum değeri'], 400);
    }

    try {
        $db->beginTransaction();

        // Ödeme durumunu güncelle
        $payment->updateStatus($id, $durum);

        // Eğer durum "Ödendi" ise bakiyeden düş
        if ($durum == 'Ödendi') {
            $tutar = $db->getDbValue("SELECT tutar FROM odemeler WHERE id = ?", [$id]);
            if ($tutar) {
                $db->execute("UPDATE bakiye SET toplam_bakiye = toplam_bakiye - ? WHERE id = 1", [$tutar]);
            }
        }

        $db->commit();

        // Güncel bakiye ve toplam borç bilgilerini getir
        $bakiye = $db->getDbValue("SELECT toplam_bakiye FROM bakiye WHERE id = 1");
        $kalan_borc = $db->getDbValue("SELECT SUM(tutar) FROM odemeler WHERE durum != 'Ödendi'") ?? 0;

        json_response([
            'success' => true,
            'bakiye' => number_format($bakiye, 0, ',', '.'),
            'kalan_borc' => number_format($kalan_borc, 0, ',', '.')
        ]);

    } catch (Exception $e) {
        $db->rollback();
        error_log('Update payment error: ' . $e->getMessage());
        json_response(['success' => false, 'message' => 'İşlem sırasında bir hata oluştu.'], 500);
    }
});