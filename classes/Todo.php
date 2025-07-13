<?php

require_once __DIR__ . '/Database.php';

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
        $sql = "INSERT INTO todo_list (gorev, durum, son_tarih) VALUES (?, ?, ?)";
        $params = [
            $data['gorev'] ?? null,
            $data['durum'] ?? 'Beklemede',
            $data['son_tarih'] ?? null
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
        $sql = "UPDATE todo_list SET gorev = ?, durum = ?, son_tarih = ? WHERE id = ?";
        $params = [
            $data['gorev'] ?? null,
            $data['durum'] ?? null,
            $data['son_tarih'] ?? null,
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
        $sql = "DELETE FROM todo_list WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm To-Do'ları getirir.
     *
     * @return array To-Do listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM todo_list ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir To-Do'yu ID'sine göre getirir.
     *
     * @param int $id Getirilecek To-Do'nun ID'si.
     * @return array|false To-Do verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM todo_list WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
