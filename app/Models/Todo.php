<?php

namespace App\Models;

use App\Models\Database;

class Todo {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir To-Do ekler.
     *
     * @param array $data To-Do verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO todos (task, status, due_date) VALUES (?, ?, ?)";
        $params = [
            $data['task'] ?? null,
            $data['status'] ?? 'Beklemede',
            $data['due_date'] ?? null
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir To-Do'yu ID'sine göre günceller.
     *
     * @param int $id Güncellenecek To-Do'nun ID'si.
     * @param array $data Güncel To-Do verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE todos SET task = ?, status = ?, due_date = ? WHERE id = ?";
        $params = [
            $data['task'] ?? null,
            $data['status'] ?? null,
            $data['due_date'] ?? null,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir To-Do'yu ID'sine göre siler.
     *
     * @param int $id Silinecek To-Do'nun ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM todos WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm To-Do'ları getirir.
     *
     * @return array To-Do listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM todos ORDER BY created_at DESC";
        $result = $this->db->fetchAll($sql);
        return is_array($result) ? $result : [];
    }

    /**
     * Bir To-Do'yu ID'sine göre getirir.
     *
     * @param int $id Getirilecek To-Do'nun ID'si.
     * @return array|false To-Do verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM todos WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
