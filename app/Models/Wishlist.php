<?php

namespace App\Models;

require_once __DIR__ . '/Database.php';

class Wishlist {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir istek listesi öğesi ekler.
     *
     * @param array $data İstek listesi verileri.
     * @return bool Başarı durumu.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO wishlist_items (item_name, wishlist_type, image_url, product_link, price, priority, progress) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['item_name'],
            $data['wishlist_type'] ?? 'istek',
            $data['image_url'] ?? null,
            $data['product_link'] ?? null,
            $data['price'] ?? 0,
            $data['priority'] ?? null,
            $data['progress'] ?? 0
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir istek listesi öğesini günceller.
     *
     * @param int $id Güncellenecek öğenin ID'si.
     * @param array $data Yeni veriler.
     * @return bool Başarı durumu.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE wishlist_items SET item_name = ?, wishlist_type = ?, image_url = ?, product_link = ?, price = ?, priority = ?, progress = ? WHERE id = ?";
        $params = [
            $data['item_name'],
            $data['wishlist_type'],
            $data['image_url'],
            $data['product_link'],
            $data['price'],
            $data['priority'],
            $data['progress'],
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir istek listesi öğesini siler.
     *
     * @param int $id Silinecek öğenin ID'si.
     * @return bool Başarı durumu.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM wishlist_items WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Bir öğeyi ID'sine göre getirir.
     *
     * @param int $id Öğenin ID'si.
     * @return array|false
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM wishlist_items WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Tüm istek listesi öğelerini veya belirli bir tipe göre olanları getirir.
     *
     * @param string|null $wishlist_type Filtrelemek için istek listesi tipi.
     * @return array
     */
    public function getAll(?string $wishlist_type = null): array {
        $sql = "SELECT * FROM wishlist_items";
        $params = [];
        if ($wishlist_type) {
            $sql .= " WHERE wishlist_type = ?";
            $params[] = $wishlist_type;
        }
        $sql .= " ORDER BY priority DESC, created_at DESC";
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * 'ihtiyac' tipindeki istek listesi öğelerini getirir.
     *
     * @return array
     */
    public function getNeeds(): array {
        return $this->getAll('ihtiyac');
    }

    /**
     * 'favori' tipindeki istek listesi öğelerini getirir.
     *
     * @return array
     */
    public function getFavorites(): array {
        return $this->getAll('favori');
    }
}
