<?php

namespace App\Models;

use App\Models\Database;

class PersonalDebt {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir şahıs borcu kaydı ekler.
     *
     * @param array $data Şahıs borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO personal_debts (to_whom, amount, due_date, paid, remaining, planned_payment_date) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['to_whom'] ?? null,
            $data['amount'] ?? 0,
            $data['due_date'] ?? null,
            $data['paid'] ?? 0,
            $data['remaining'] ?? 0,
            $data['planned_payment_date'] ?? null
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir şahıs borcu kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek şahıs borcu kaydının ID'si.
     * @param array $data Güncel şahıs borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE personal_debts SET to_whom = ?, amount = ?, due_date = ?, paid = ?, remaining = ?, planned_payment_date = ? WHERE id = ?";
        $params = [
            $data['to_whom'] ?? null,
            $data['amount'] ?? 0,
            $data['due_date'] ?? null,
            $data['paid'] ?? 0,
            $data['remaining'] ?? 0,
            $data['planned_payment_date'] ?? null,
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    /**
     * Bir şahıs borcu kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek şahıs borcu kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM personal_debts WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm şahıs borcu kayıtlarını getirir.
     *
     * @return array Şahıs borcu kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM personal_debts ORDER BY due_date DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Belirli bir ay ve yıla ait şahıs borçlarını getirir.
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    public function getByMonth(int $year, int $month): array {
        $sql = "SELECT * FROM personal_debts WHERE YEAR(due_date) = ? AND MONTH(due_date) = ? ORDER BY due_date DESC";
        return $this->db->fetchAll($sql, [$year, $month]);
    }

    /**
     * Bir şahıs borcu kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek şahıs borcu kaydının ID'si.
     * @return array|false Şahıs borcu kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM personal_debts WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }
}
