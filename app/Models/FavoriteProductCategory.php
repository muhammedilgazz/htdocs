<?php

namespace App\Models;

use App\Core\DatabaseConnection;
use PDO;

class FavoriteProductCategory
{
    private $db;

    public function __construct()
    {
        $this->db = (new DatabaseConnection())->getConnection();
    }

    public function getAllByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM favorite_product_categories WHERE user_id = :user_id ORDER BY name ASC");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id, $userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM favorite_product_categories WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $description, $userId)
    {
        $stmt = $this->db->prepare("INSERT INTO favorite_product_categories (name, description, user_id) VALUES (:name, :description, :user_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($id, $name, $description, $userId)
    {
        $stmt = $this->db->prepare("UPDATE favorite_product_categories SET name = :name, description = :description WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id, $userId)
    {
        // Önce bu kategoriye ait ürünlerin kategori atamasını kaldır
        $stmt = $this->db->prepare("UPDATE favorite_products SET category_id = NULL WHERE category_id = :category_id AND user_id = :user_id");
        $stmt->bindParam(':category_id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Sonra kategoriyi sil
        $stmt = $this->db->prepare("DELETE FROM favorite_product_categories WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}