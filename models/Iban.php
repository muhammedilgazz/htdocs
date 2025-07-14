<?php

require_once __DIR__ . '/Database.php';

class Iban {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir IBAN kaydı ekler.
     *
     * @param array $data IBAN verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO iban_details (account_holder, iban_number, easy_address, bank_name, description, account_type) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['account_holder'] ?? null,
            $data['iban_number'] ?? null,
            $data['easy_address'] ?? null,
            $data['bank_name'] ?? null,
            $data['description'] ?? null,
            $data['account_type'] ?? 'other'
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir IBAN kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek IBAN kaydının ID'si.
     * @param array $data Güncel IBAN verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE iban_details SET account_holder = ?, iban_number = ?, easy_address = ?, bank_name = ?, description = ?, account_type = ? WHERE id = ?";
        $params = [
            $data['account_holder'] ?? null,
            $data['iban_number'] ?? null,
            $data['easy_address'] ?? null,
            $data['bank_name'] ?? null,
            $data['description'] ?? null,
            $data['account_type'] ?? 'other',
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir IBAN kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek IBAN kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM iban_details WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm IBAN kayıtlarını getirir.
     *
     * @return array IBAN kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM iban_details ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir IBAN kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek IBAN kaydının ID'si.
     * @return array|false IBAN kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM iban_details WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}