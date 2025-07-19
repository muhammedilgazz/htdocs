<?php
require_once '../bootstrap.php';

use App\Models\Giderler;
use App\Models\ExcelExporter;

// Giderleri al
$giderler = new Giderler();
$rows = $giderler->getConsolidatedMonthlyExpenses('all');

// Dışa aktarılacak verileri hazırla
$data = [];
foreach ($rows as $row) {
    $data[] = [
        'description' => $row['description'],
        'type' => $row['type'],
        'amount' => $row['amount'],
        'created_at' => date('d.m.Y', strtotime($row['created_at'])),
    ];
}

// Başlıkları tanımla
$headers = ['Açıklama', 'Tür', 'Tutar', 'Tarih'];

// Excel dosyası olarak indir
try {
    ExcelExporter::export($data, $headers, 'giderler.xlsx');
} catch (Exception $e) {
    // Hata yönetimi
    error_log($e->getMessage());
    // Kullanıcıya bir hata mesajı gösterebilirsiniz
}