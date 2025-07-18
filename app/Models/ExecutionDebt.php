<?php

namespace App\Models;

use App\Models\Database;

class ExecutionDebt {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir icra borcu kaydı ekler.
     *
     * @param array $data İcra borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO execution_debts (owner, creditor, execution_office, start_date, current_debt, principal_debt, contact_info, status, planned_payment, this_month_payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['owner'] ?? null,
            $data['creditor'] ?? null,
            $data['execution_office'] ?? null,
            $data['start_date'] ?? null,
            $data['current_debt'] ?? 0,
            $data['principal_debt'] ?? 0,
            $data['contact_info'] ?? null,
            $data['status'] ?? null,
            $data['planned_payment'] ?? 0,
            $data['this_month_payment'] ?? 0
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir icra borcu kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek icra borcu kaydının ID'si.
     * @param array $data Güncel icra borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE execution_debts SET owner = ?, creditor = ?, execution_office = ?, start_date = ?, current_debt = ?, principal_debt = ?, contact_info = ?, status = ?, planned_payment = ?, this_month_payment = ? WHERE id = ?";
        $params = [
            $data['owner'] ?? null,
            $data['creditor'] ?? null,
            $data['execution_office'] ?? null,
            $data['start_date'] ?? null,
            $data['current_debt'] ?? 0,
            $data['principal_debt'] ?? 0,
            $data['contact_info'] ?? null,
            $data['status'] ?? null,
            $data['planned_payment'] ?? 0,
            $data['this_month_payment'] ?? 0,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir icra borcu kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek icra borcu kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM execution_debts WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm icra borcu kayıtlarını getirir.
     *
     * @return array İcra borcu kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM execution_debts ORDER BY start_date DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir icra borcu kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek icra borcu kaydının ID'si.
     * @return array|false İcra borcu kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM execution_debts WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}