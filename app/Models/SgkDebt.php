<?php

namespace App\Models;

use App\Models\Database;

class SgkDebt {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir SGK borcu kaydı ekler.
     *
     * @param array $data SGK borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO sgk_debts (owner, period, principal, interest, total, payment_due, planned_payment, paid, remaining, this_month_payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
     * Bir SGK borcu kaydını ID'sine göre günceller.
     *
     * @param int $id Güncellenecek SGK borcu kaydının ID'si.
     * @param array $data Güncel SGK borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE sgk_debts SET owner = ?, period = ?, principal = ?, interest = ?, total = ?, payment_due = ?, planned_payment = ?, paid = ?, remaining = ?, this_month_payment = ? WHERE id = ?";
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
     * Bir SGK borcu kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek SGK borcu kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM sgk_debts WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    /**
     * Tüm SGK borcu kayıtlarını getirir.
     *
     * @return array SGK borcu kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM sgk_debts ORDER BY payment_due DESC";
        return $this->db->fetchAll($sql);
    }

    /**
     * Bir SGK borcu kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek SGK borcu kaydının ID'si.
     * @return array|false SGK borcu kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id) {
        $sql = "SELECT * FROM sgk_debts WHERE id = ?";
        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Belirli bir owner için toplam SGK borcunu döndürür.
     *
     * @param string $owner
     * @return float
     */
    public function getSgkDebtAmountByOwner(string $owner): float {
        $sql = "SELECT SUM(total) as total FROM sgk_debts WHERE owner = ?";
        $result = $this->db->fetch($sql, [$owner]);
        return isset($result['total']) ? (float)$result['total'] : 0.0;
    }

    /**
     * Tüm SGK borçlarının toplamını döndürür.
     *
     * @return float
     */
    public function getTotalSgkDebtAmount(): float {
        $sql = "SELECT SUM(total) as total FROM sgk_debts";
        $result = $this->db->fetch($sql);
        return isset($result['total']) ? (float)$result['total'] : 0.0;
    }
}
