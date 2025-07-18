<?php

namespace App\Models;

use App\Models\Database;

class Income {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir gelir kaydı ekler.
     *
     * @param array $data Gelir verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO incomes (source, amount, date, description) VALUES (?, ?, ?, ?)";
        $params = [
            $data['source'] ?? null,
            $data['amount'] ?? null,
            $data['date'] ?? date('Y-m-d'),
            $data['description'] ?? null
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir gelir kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek gelir kaydının ID'si.
     * @param array $data Güncel gelir verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE incomes SET source = ?, amount = ?, date = ?, description = ? WHERE id = ?";
        $params = [
            $data['source'] ?? null,
            $data['amount'] ?? null,
            $data['date'] ?? null,
            $data['description'] ?? null,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir gelir kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek gelir kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM incomes WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm gelir kayıtlarını getirir.
     *
     * @return array Gelir kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM incomes ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir gelir kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek gelir kaydının ID'si.
     * @return array|false Gelir kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM incomes WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}