<?php

namespace App\Models;

use App\Models\Database;

class BankAccount {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir banka hesabı kaydı ekler.
     *
     * @param array $data Banka hesabı verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO bank_accounts (account_holder, iban_number, easy_address, bank_id, bank_name, bank_logo, description, account_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['account_holder'] ?? null,
            $data['iban_number'] ?? null,
            $data['easy_address'] ?? null,
            $data['bank_id'] ?? null,
            $data['bank_name'] ?? null,
            $data['bank_logo'] ?? null,
            $data['description'] ?? null,
            $data['account_type'] ?? 'other'
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir banka hesabı kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek banka hesabı kaydının ID'si.
     * @param array $data Güncel banka hesabı verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE bank_accounts SET account_holder = ?, iban_number = ?, easy_address = ?, bank_id = ?, bank_name = ?, bank_logo = ?, description = ?, account_type = ? WHERE id = ?";
        $params = [
            $data['account_holder'] ?? null,
            $data['iban_number'] ?? null,
            $data['easy_address'] ?? null,
            $data['bank_id'] ?? null,
            $data['bank_name'] ?? null,
            $data['bank_logo'] ?? null,
            $data['description'] ?? null,
            $data['account_type'] ?? 'other',
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir banka hesabı kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek banka hesabı kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM bank_accounts WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm banka hesabı kayıtlarını getirir.
     *
     * @return array Banka hesabı kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM bank_accounts ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir banka hesabı kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek banka hesabı kaydının ID'si.
     * @return array|false Banka hesabı kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM bank_accounts WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}