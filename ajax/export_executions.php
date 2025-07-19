<?php
require_once '../bootstrap.php';

use App\Models\ExecutionDebt;
use App\Models\ExcelExporter;

// İcra borçlarını al
$executionDebt = new ExecutionDebt();
$rows = $executionDebt->getAll();

// Dışa aktarılacak verileri hazırla
$data = [];
foreach ($rows as $row) {
    $data[] = [
        'owner' => $row['owner'],
        'creditor' => $row['creditor'],
        'execution_office' => $row['execution_office'],
        'current_debt' => $row['current_debt'],
        'status' => $row['status'],
        'planned_payment' => $row['planned_payment'],
        'this_month_payment' => $row['this_month_payment'],
    ];
}

// Başlıkları tanımla
$headers = ['Sahibi', 'Alacaklı', 'İcra Dairesi', 'Güncel Borç', 'Durum', 'Planlanan Ödeme', 'Bu Ay Ödeme'];

// Excel dosyası olarak indir
try {
    ExcelExporter::export($data, $headers, 'icra_borclari.xlsx');
} catch (Exception $e) {
    // Hata yönetimi
    error_log($e->getMessage());
    // Kullanıcıya bir hata mesajı gösterebilirsiniz
}