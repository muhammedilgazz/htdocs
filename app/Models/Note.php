<?php

namespace App\Models;

use App\Models\Database;

class Note {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir not ekler.
     *
     * @param array $data Not verileri.
     * @return int|false Eklenen notun ID'si veya hata durumunda false.
     */
    public function add(array $data) {
        $sql = "INSERT INTO notes (user_id, title, content, category, priority, status) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['user_id'] ?? 1, // Varsayılan kullanıcı ID'si
            $data['title'] ?? null,
            $data['content'] ?? null,
            $data['category'] ?? 'Genel',
            $data['priority'] ?? 'medium',
            $data['status'] ?? 'active'
        ];
        if ($this->db->execute($sql, $params)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Bir notu ID'sine göre günceller.
     *
     * @param int $id Güncellenecek notun ID'si.
     * @param array $data Güncel not verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE notes SET title = ?, content = ?, category = ?, priority = ?, status = ? WHERE id = ?";
        $params = [
            $data['title'] ?? null,
            $data['content'] ?? null,
            $data['category'] ?? 'Genel',
            $data['priority'] ?? 'medium',
            $data['status'] ?? 'active',
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir notu ID'sine göre siler.
     *
     * @param int $id Silinecek notun ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM notes WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm notları getirir.
     *
     * @return array Notlar listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM notes ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir notu ID'sine göre getirir.
     *
     * @param int $id Getirilecek notun ID'si.
     * @return array|false Not verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM notes WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
