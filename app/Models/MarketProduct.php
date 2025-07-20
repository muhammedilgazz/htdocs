<?php

namespace App\Models;

use PDO;

class MarketProduct
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM market_products WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO market_products (user_id, product_name, company_name, link, image_url, quantity, price, min_stock, current_stock)
             VALUES (:user_id, :product_name, :company_name, :link, :image_url, :quantity, :price, :min_stock, :current_stock)"
        );
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'product_name' => $data['product_name'],
            'company_name' => $data['company_name'],
            'link' => $data['link'],
            'image_url' => $data['image_url'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'min_stock' => $data['min_stock'],
            'current_stock' => $data['current_stock']
        ]);
    }

    // Update ve Delete metodları daha sonra eklenebilir.
}