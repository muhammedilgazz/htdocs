<?php

namespace App\Models;

use App\Models\Database; // Database sınıfını dahil et
use PDO;
 
class ExecutionDebt {
    private PDO $db;
 
    public function __construct() {
        $this->db = Database::getInstance()->getPdo(); // Database sınıfının getInstance metodunu kullan
    }

    /**
     * Yeni bir icra borcu kaydı ekler.
     *
     * @param array $data İcra borcu verileri.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function add(array $data): bool {
        $sql = "INSERT INTO execution_debts (owner, creditor, execution_office, start_date, current_debt, principal_debt, contact_info, status, planned_payment, this_month_payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
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
        ]);
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
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
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
        ]);
    }

    /**
     * Bir icra borcu kaydını ID'sine göre siler.
     *
     * @param int $id Silinecek icra borcu kaydının ID'si.
     * @return bool İşlem başarılıysa true, değilse false.
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM execution_debts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Tüm icra borcu kayıtlarını getirir.
     *
     * @return array İcra borcu kayıtları listesi.
     */
    public function getAll(): array {
        $sql = "SELECT * FROM execution_debts ORDER BY start_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Bir icra borcu kaydını ID'sine göre getirir.
     *
     * @param int $id Getirilecek icra borcu kaydının ID'si.
     * @return array|false İcra borcu kaydı verileri veya bulunamazsa false.
     */
    public function getById(int $id): ?array {
        $sql = "SELECT * FROM execution_debts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Tüm icra borçlarının güncel borç miktarını döndürür.
     *
     * @return float
     */
    public function getTotalCurrentDebtAmount(): float {
        $sql = "SELECT SUM(current_debt) FROM execution_debts";
        $stmt = $this->db->query($sql);
        return (float)$stmt->fetchColumn();
    }

    /**
     * Toplam icra borcu kaydı sayısını döndürür.
     *
     * @return int
     */
    public function getTotalExecutionFilesCount(): int {
        $sql = "SELECT COUNT(*) FROM execution_debts";
        $stmt = $this->db->query($sql);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Bu ay ödenecek planlanan ödemelerin toplamını döndürür.
     *
     * @return float
     */
    public function getThisMonthTotalPlannedPayment(): float {
        $sql = "SELECT SUM(this_month_payment) FROM execution_debts WHERE MONTH(start_date) = MONTH(CURRENT_DATE()) AND YEAR(start_date) = YEAR(CURRENT_DATE())";
        $stmt = $this->db->query($sql);
        return (float)$stmt->fetchColumn();
    }

    /**
     * Toplam ödenen miktarı döndürür (anapara borcu - güncel borç).
     *
     * @return float
     */
    public function getTotalPaidAmount(): float {
        $sql = "SELECT SUM(principal_debt - current_debt) FROM execution_debts";
        $stmt = $this->db->query($sql);
        return (float)$stmt->fetchColumn();
    }
}