<?php

namespace App\Controllers;

use App\Models\MarketProduct;

class MarketController
{
    private $marketProductModel;

    public function __construct(MarketProduct $marketProductModel)
    {
        $this->marketProductModel = $marketProductModel;
    }

    public function index()
    {
        // Session'dan kullanıcı ID'sini al (örnek olarak 1)
        $userId = $_SESSION['user_id'] ?? 1;
        $products = $this->marketProductModel->getAllByUserId($userId);

        // Verileri view'e aktar
        include_once __DIR__ . '/../../views/market/index.php';
    }

    public function ajax_add_product()
    {
        try {
            $data = [
                'user_id' => $_SESSION['user_id'] ?? 1,
                'product_name' => $_POST['product_name'],
                'company_name' => $_POST['company_name'],
                'link' => $_POST['link'],
                'image_url' => $_POST['image_url'],
                'quantity' => $_POST['quantity'],
                'price' => $_POST['price'],
                'min_stock' => $_POST['min_stock'],
                'current_stock' => $_POST['current_stock']
            ];
            
            if ($this->marketProductModel->create($data)) {
                return ['status' => 'success', 'message' => 'Ürün başarıyla eklendi.'];
            } else {
                return ['status' => 'error', 'message' => 'Ürün eklenirken bir hata oluştu.'];
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return ['status' => 'error', 'message' => 'Sunucu hatası: ' . $e->getMessage()];
        }
    }
}