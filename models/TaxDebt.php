<?php

namespace App\Models;

use App\Models\Database;

class TaxDebt {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir vergi borcu kaydı ekler.
     *
     * @param array $data Vergi borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO tax_debts (owner, period, principal, interest, total, payment_due, planned_payment, paid, remaining, this_month_payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['owner'] ?? null,
            $data['period'] ?? null,
            $data['principal'] ?? 0,
            $data['interest'] ?? 0,
            $data['total'] ?? 0,
            $data['payment_due'] ?? null,
            $data['planned_payment'] ?? 0,
            $data['paid'] ?? 0,
            $data['remaining'] ?? 0,
            $data['this_month_payment'] ?? 0
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir vergi borcu kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek vergi borcu kaydının ID'si.
     * @param array $data Güncel vergi borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE tax_debts SET owner = ?, period = ?, principal = ?, interest = ?, total = ?, payment_due = ?, planned_payment = ?, paid = ?, remaining = ?, this_month_payment = ? WHERE id = ?";
        $params = [
            $data['owner'] ?? null,
            $data['period'] ?? null,
            $data['principal'] ?? 0,
            $data['interest'] ?? 0,
            $data['total'] ?? 0,
            $data['payment_due'] ?? null,
            $data['planned_payment'] ?? 0,
            $data['paid'] ?? 0,
            $data['remaining'] ?? 0,
            $data['this_month_payment'] ?? 0,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir vergi borcu kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek vergi borcu kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM tax_debts WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm vergi borcu kayıtlarını getirir.
     *
     * @return array Vergi borcu kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM tax_debts ORDER BY payment_due DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir vergi borcu kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek vergi borcu kaydının ID'si.
     * @return array|false Vergi borcu kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM tax_debts WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
