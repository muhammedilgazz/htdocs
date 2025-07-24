<?php

namespace App\Models;

use App\Core\DatabaseConnection;
use PDO;

class FavoriteProduct
{
    private $db;

    public function __construct()
    {
        $this->db = (new DatabaseConnection())->getConnection();
    }

    public function getAllByUserId($userId, $categoryId = null)
    {
        $sql = "SELECT fp.*, fpc.name as category_name 
                FROM favorite_products fp
                LEFT JOIN favorite_product_categories fpc ON fp.category_id = fpc.id
                WHERE fp.user_id = :user_id";
        
        if ($categoryId) {
            $sql .= " AND fp.category_id = :category_id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id, $userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM favorite_products WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory($id, $categoryId, $userId)
    {
        $stmt = $this->db->prepare("UPDATE favorite_products SET category_id = :category_id WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id, $userId)
    {
        $stmt = $this->db->prepare("DELETE FROM favorite_products WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getPaginatedProducts($userId, $categoryId = null, $limit, $offset)
    {
        $sql = "SELECT fp.*, fpc.name as category_name
                FROM favorite_products fp
                LEFT JOIN favorite_product_categories fpc ON fp.category_id = fpc.id
                WHERE fp.user_id = :user_id";
        
        if ($categoryId) {
            $sql .= " AND fp.category_id = :category_id";
        }

        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProductsCount($userId, $categoryId = null)
    {
        $sql = "SELECT COUNT(*) FROM favorite_products WHERE user_id = :user_id";
        if ($categoryId) {
            $sql .= " AND category_id = :category_id";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}