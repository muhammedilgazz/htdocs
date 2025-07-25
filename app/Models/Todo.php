<?php

namespace App\Models;

use PDO;

class Todo {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Yeni bir To-Do ekler.
     *
     * @param array $data To-Do verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO to_do (task, status, due_date) VALUES (?, ?, ?)";
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
        $sql = "UPDATE to_do SET task = ?, status = ?, due_date = ? WHERE id = ?";
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
        $sql = "DELETE FROM to_do WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm To-Do'ları getirir.
     *
     * @return array To-Do listesi.
     */
    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM to_do ORDER BY id DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Bir To-Do'yu ID'sine göre getirir.
     *
     * @param int $id Getirilecek To-Do'nun ID'si.
     * @return array|false To-Do verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM to_do WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
