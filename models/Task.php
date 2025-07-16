<?php

namespace App\Models;

use App\Models\Database;

class Task {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir görev kaydı ekler.
     *
     * @param array $data Görev verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO expenses (description, amount, category_type, date) VALUES (?, ?, 'gorev', ?)";
        $params = [
            $data['description'] ?? null,
            $data['amount'] ?? 0,
            $data['date'] ?? date('Y-m-d')
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir görev kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek görev kaydının ID'si.
     * @param array $data Güncel görev verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE expenses SET description = ?, amount = ?, date = ? WHERE id = ? AND category_type = 'gorev'";
        $params = [
            $data['description'] ?? null,
            $data['amount'] ?? 0,
            $data['date'] ?? date('Y-m-d'),
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir görev kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek görev kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM expenses WHERE id = ? AND category_type = 'gorev'";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm görev kayıtlarını getirir.
     *
     * @return array Görev kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM expenses WHERE category_type = 'gorev' ORDER BY date DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir görev kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek görev kaydının ID'si.
     * @return array|false Görev verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM expenses WHERE id = ? AND category_type = 'gorev'";
        return $this->db->fetch($sql, [$id]);
    }
}