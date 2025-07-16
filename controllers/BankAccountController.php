<?php

namespace App\Controllers;

use App\Models\Database;

class BankAccountController {
    public function index() {
        // Banka hesapları yönetimi için placeholder controller
        
        // Örnek veri - gerçek implementasyon için model gerekli
        $rows = [];
        $total_count = 0;
        $csrf_token = generate_csrf_token();
        
        // Şimdilik boş veri ile devam et
        $message = 'Bu sayfa henüz implementasyona hazır değil. Banka hesapları yönetimi için geliştirme devam ediyor.';
        
        require_once 'C:/xampp/htdocs/views/bank_account/index.php';
    }
}