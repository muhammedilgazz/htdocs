<?php
require_once __DIR__ . '/../classes/Payment.php';
require_once __DIR__ . '/../classes/AjaxHelper.php';
require_once __DIR__ . '/../classes/Database.php'; // Bakiye güncellemesi için Database sınıfına ihtiyaç var

handle_ajax_request(function($data) {
    $payment = new Payment();
    $db = Database::getInstance();

    $id = filter_var($data['id'] ?? '', FILTER_VALIDATE_INT);
    $status = $data['status'] ?? '';

    if (!$id || !$status) {
        json_response(['success' => false, 'message' => 'Geçersiz parametreler'], 400);
    }

    try {
        $db->beginTransaction();

        // Ödeme durumunu güncelle
        $payment->updateStatus($id, $status);

        // Eğer durum "Ödendi" ise bakiyeden düş
        if ($status == 'Ödendi') {
            $amount = $db->getDbValue("SELECT amount FROM payments WHERE id = ?", [$id]);
            if ($amount) {
                $db->execute("UPDATE balances SET total_balance = total_balance - ? WHERE id = 1", [$amount]);
            }
        }

        $db->commit();

        // Güncel bakiye ve toplam borç bilgilerini getir
        $balance = $db->getDbValue("SELECT total_balance FROM balances WHERE id = 1");
        $remaining_debt = $db->getDbValue("SELECT SUM(amount) FROM payments WHERE status_id != (SELECT id FROM status_types WHERE name = 'Ödendi')") ?? 0;

        json_response([
            'success' => true,
            'balance' => number_format($balance, 0, ',', '.'),
            'remaining_debt' => number_format($remaining_debt, 0, ',', '.')
        ]);

    } catch (Exception $e) {
        $db->rollback();
        error_log('Update payment error: ' . $e->getMessage());
        json_response(['success' => false, 'message' => 'İşlem sırasında bir hata oluştu.'], 500);
    }
});