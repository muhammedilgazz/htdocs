<?php
require_once '../bootstrap.php';

use App\Models\SgkDebt;
use App\Models\ExcelExporter;

// SGK borçlarını al
$sgkDebt = new SgkDebt();
$rows = $sgkDebt->getAll();

// Dışa aktarılacak verileri hazırla
$data = [];
foreach ($rows as $row) {
    $data[] = [
        'owner' => $row['owner'],
        'period' => $row['period'],
        'principal' => $row['principal'],
        'interest' => $row['interest'],
        'total' => $row['total'],
        'payment_due' => date('d.m.Y', strtotime($row['payment_due'])),
        'planned_payment' => $row['planned_payment'],
        'paid' => $row['paid'],
        'remaining' => $row['remaining'],
        'this_month_payment' => $row['this_month_payment'],
    ];
}

// Başlıkları tanımla
$headers = ['Sahibi', 'Dönem', 'Anapara', 'Faiz', 'Toplam', 'Ödeme Vadesi', 'Planlanan Ödeme', 'Ödenen', 'Kalan', 'Bu Ay Ödeme'];

// Excel dosyası olarak indir
try {
    ExcelExporter::export($data, $headers, 'sgk_borclari.xlsx');
} catch (Exception $e) {
    // Hata yönetimi
    error_log($e->getMessage());
    // Kullanıcıya bir hata mesajı gösterebilirsiniz
}