<?php

require_once __DIR__ . '/Database.php';

class Wishlist {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir istek listesi öğesi ekler.
     *
     * @param array $data İstek listesi öğesi verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO wishlist_items (item_name, category_id, price, image_path, link, will_get) VALUES (?, (SELECT id FROM categories WHERE name = ? AND type = 'wishlist'), ?, ?, ?, ?)";
        $params = [
            $data['item_name'] ?? null,
            $data['category_name'] ?? null,
            $data['price'] ?? null,
            $data['image_path'] ?? null,
            $data['link'] ?? null,
            $data['will_get'] ?? false
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir istek listesi öğesini ID'sine göre günceller.
     *
     * @param int $id Güncellenecek istek listesi öğesinin ID'si.
     * @param array $data Güncel istek listesi öğesi verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE wishlist_items SET item_name = ?, category_id = (SELECT id FROM categories WHERE name = ? AND type = 'wishlist'), price = ?, image_path = ?, link = ?, will_get = ? WHERE id = ?";
        $params = [
            $data['item_name'] ?? null,
            $data['category_name'] ?? null,
            $data['price'] ?? null,
            $data['image_path'] ?? null,
            $data['link'] ?? null,
            $data['will_get'] ?? null,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir istek listesi öğesini ID'sine göre siler.
     *
     * @param int $id Silinecek istek listesi öğesinin ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM wishlist_items WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm istek listesi öğelerini getirir.
     *
     * @return array İstek listesi öğeleri listesi.
     */
    public function getAll(): array {
        $sql = "SELECT wi.*, c.name as category_name FROM wishlist_items wi JOIN categories c ON wi.category_id = c.id ORDER BY wi.created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir istek listesi öğesini ID'sine göre getirir.
     *
     * @param int $id Getirilecek istek listesi öğesinin ID'si.
     * @return array|false İstek listesi öğesi verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT wi.*, c.name as category_name FROM wishlist_items wi JOIN categories c ON wi.category_id = c.id WHERE wi.id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}