<?php
require_once '../bootstrap.php';

use App\Models\MarketProduct;
use App\Core\DatabaseConnection;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $db = DatabaseConnection::getPDO();
    $marketProductModel = new MarketProduct($db);

    if ($marketProductModel->create($data)) {
        echo json_encode(['success' => true, 'message' => 'Ürün başarıyla eklendi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ürün eklenirken bir hata oluştu.']);
    }
}