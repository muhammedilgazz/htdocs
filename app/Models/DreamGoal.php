<?php

namespace App\Models;

use App\Models\Database;

class DreamGoal {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir hayal/hedef kaydı ekler.
     *
     * @param array $data Hayal/hedef verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO wishlist_items (item_name, wishlist_type, price, product_link, priority, progress) VALUES (?, 'hayal', ?, ?, ?, ?)";
        $params = [
            $data['goal_name'] ?? null,
            $data['target_amount'] ?? 0,
            $data['product_link'] ?? null,
            $data['priority'] ?? null,
            $data['progress'] ?? 0
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir hayal/hedef kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek hayal/hedef kaydının ID'si.
     * @param array $data Güncel hayal/hedef verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE wishlist_items SET item_name = ?, price = ?, product_link = ?, priority = ?, progress = ? WHERE id = ? AND wishlist_type = 'hayal'";
        $params = [
            $data['goal_name'] ?? null,
            $data['target_amount'] ?? 0,
            $data['product_link'] ?? null,
            $data['priority'] ?? null,
            $data['progress'] ?? 0,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir hayal/hedef kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek hayal/hedef kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM wishlist_items WHERE id = ? AND wishlist_type = 'hayal'";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm hayal/hedef kayıtlarını getirir.
     *
     * @return array Hayal/hedef kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT id, item_name as goal_name, price as target_amount, product_link, priority, progress, created_at FROM wishlist_items WHERE wishlist_type = 'hayal' ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir hayal/hedef kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek hayal/hedef kaydının ID'si.
     * @return array|false Hayal/hedef verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT id, item_name as goal_name, price as target_amount, product_link, priority, progress, created_at FROM wishlist_items WHERE id = ? AND wishlist_type = 'hayal'";
        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Belirli bir owner için toplam hayal/hedef tutarını döndürür.
     *
     * @param string $owner
     * @return float
     */
    public function getDreamGoalAmountByOwner(string $owner): float {
        $sql = "SELECT SUM(price) as total FROM wishlist_items WHERE wishlist_type = 'hayal' AND owner = ?";
        $result = $this->db->fetch($sql, [$owner]);
        return isset($result['total']) ? (float)$result['total'] : 0.0;
    }

    /**
     * Tüm hayal/hedeflerin toplam tutarını döndürür.
     *
     * @return float
     */
    public function getTotalDreamGoalAmount(): float {
        $sql = "SELECT SUM(price) as total FROM wishlist_items WHERE wishlist_type = 'hayal'";
        $result = $this->db->fetch($sql);
        return isset($result['total']) ? (float)$result['total'] : 0.0;
    }
}
