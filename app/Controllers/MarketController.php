<?php

namespace App\Controllers;

use App\Models\MarketProduct;
use App\Models\Database; // Database sınıfını dahil et
// use App\Core\DatabaseConnection; // Bu satırı kaldırdık
 
class MarketController
{
    private $marketProductModel;
 
    public function __construct()
    {
        $db = Database::getInstance()->getPdo(); // Database sınıfının getInstance metodunu kullan
        $this->marketProductModel = new MarketProduct($db);
    }

    public function index()
    {
        // Session'dan kullanıcı ID'sini al (örnek olarak 1)
        $userId = $_SESSION['user_id'] ?? 1;
        $products = $this->marketProductModel->getAllByUserId($userId);

        // Verileri view'e aktar
        include_once __DIR__ . '/../../views/market/index.php';
    }
}