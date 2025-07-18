<?php

namespace App\Models;

use App\Models\Database;

class Project {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir proje kaydı ekler.
     *
     * @param array $data Proje verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO expenses (description, amount, category_type, date) VALUES (?, ?, 'proje', ?)";
        $params = [
            $data['description'] ?? null,
            $data['amount'] ?? 0,
            $data['date'] ?? date('Y-m-d')
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir proje kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek proje kaydının ID'si.
     * @param array $data Güncel proje verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE expenses SET description = ?, amount = ?, date = ? WHERE id = ? AND category_type = 'proje'";
        $params = [
            $data['description'] ?? null,
            $data['amount'] ?? 0,
            $data['date'] ?? date('Y-m-d'),
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir proje kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek proje kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM expenses WHERE id = ? AND category_type = 'proje'";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm proje kayıtlarını getirir.
     *
     * @return array Proje kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM expenses WHERE category_type = 'proje' ORDER BY date DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir proje kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek proje kaydının ID'si.
     * @return array|false Proje verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM expenses WHERE id = ? AND category_type = 'proje'";
        return $this->db->fetch($sql, [$id]);
    }
}