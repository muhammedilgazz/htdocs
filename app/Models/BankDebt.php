<?php

namespace App\Models;

use App\Models\Database;

class BankDebt {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir banka borcu kaydı ekler.
     *
     * @param array $data Banka borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO bank_debts (bank_name, loan_type, principal, total, is_legal_process, asset_company, is_installment, planned_payment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['bank_name'] ?? null,
            $data['loan_type'] ?? null,
            $data['principal'] ?? 0,
            $data['total'] ?? 0,
            $data['is_legal_process'] ?? 0,
            $data['asset_company'] ?? null,
            $data['is_installment'] ?? 0,
            $data['planned_payment_date'] ?? null
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir banka borcu kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek banka borcu kaydının ID'si.
     * @param array $data Güncel banka borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE bank_debts SET bank_name = ?, loan_type = ?, principal = ?, total = ?, is_legal_process = ?, asset_company = ?, is_installment = ?, planned_payment_date = ? WHERE id = ?";
        $params = [
            $data['bank_name'] ?? null,
            $data['loan_type'] ?? null,
            $data['principal'] ?? 0,
            $data['total'] ?? 0,
            $data['is_legal_process'] ?? 0,
            $data['asset_company'] ?? null,
            $data['is_installment'] ?? 0,
            $data['planned_payment_date'] ?? null,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir banka borcu kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek banka borcu kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM bank_debts WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm banka borcu kayıtlarını getirir.
     *
     * @return array Banka borcu kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM bank_debts ORDER BY planned_payment_date DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir banka borcu kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek banka borcu kaydının ID'si.
     * @return array|false Banka borcu kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM bank_debts WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}