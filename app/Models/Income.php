<?php

namespace App\Models;

use App\Models\Database;
use PDO;

class Income {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getPdo();
    }
    
    /**
     * Tüm gelirleri getir
     */
    public function getAllIncomes($userId, $filter = 'all') {
        try {
            $sql = "SELECT * FROM incomes WHERE user_id = :user_id";
            
            switch ($filter) {
                case 'fixed':
                    $sql .= " AND period IN ('monthly', 'yearly')";
                    break;
                case 'extra':
                    $sql .= " AND period IN ('daily', 'weekly', 'one_time')";
                    break;
                case 'month':
                    $sql .= " AND MONTH(receive_date) = MONTH(CURRENT_DATE()) AND YEAR(receive_date) = YEAR(CURRENT_DATE())";
                    break;
                case 'next_month':
                    $sql .= " AND MONTH(receive_date) = MONTH(DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH)) AND YEAR(receive_date) = YEAR(DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH))";
                    break;
                case 'year':
                    $sql .= " AND YEAR(receive_date) = YEAR(CURRENT_DATE())";
                    break;
            }
            
            $sql .= " ORDER BY receive_date DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: [];
        } catch (\Exception $e) {
            error_log("Income getAllIncomes error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Gelir ekle
     */
    public function createIncome($data) {
        $sql = "INSERT INTO incomes (user_id, title, currency, amount, period, receive_date, is_debt, description, status) 
                VALUES (:user_id, :title, :currency, :amount, :period, :receive_date, :is_debt, :description, :status)";
        
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'currency' => $data['currency'],
            'amount' => $data['amount'],
            'period' => $data['period'],
            'receive_date' => $data['receive_date'],
            'is_debt' => $data['is_debt'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'active'
        ]);
        
        return $result ? $this->pdo->lastInsertId() : false;
    }
    
    /**
     * Gelir güncelle
     */
    public function updateIncome($id, $userId, $data) {
        $sql = "UPDATE incomes SET 
                title = :title, 
                currency = :currency, 
                amount = :amount, 
                period = :period, 
                receive_date = :receive_date, 
                is_debt = :is_debt, 
                description = :description, 
                status = :status 
                WHERE id = :id AND user_id = :user_id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
            'title' => $data['title'],
            'currency' => $data['currency'],
            'amount' => $data['amount'],
            'period' => $data['period'],
            'receive_date' => $data['receive_date'],
            'is_debt' => $data['is_debt'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'active'
        ]);
    }
    
    /**
     * Gelir sil
     */
    public function deleteIncome($id, $userId) {
        $sql = "DELETE FROM incomes WHERE id = :id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
    
    /**
     * Tek gelir getir
     */
    public function getIncomeById($id, $userId) {
        $sql = "SELECT * FROM incomes WHERE id = :id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        return $stmt->fetch();
    }
    
    /**
     * Gelir istatistikleri
     */
    public function getIncomeStats($userId) {
        $sql = "SELECT 
                COUNT(*) as total_count,
                SUM(CASE WHEN period IN ('monthly', 'yearly') THEN amount ELSE 0 END) as fixed_total,
                SUM(CASE WHEN period IN ('daily', 'weekly', 'one_time') THEN amount ELSE 0 END) as extra_total,
                SUM(amount) as total_amount
                FROM incomes 
                WHERE user_id = :user_id AND status = 'active'";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }
    
    /**
     * Aylık gelir özeti
     */
    public function getMonthlyIncomeSummary($userId) {
        $sql = "SELECT 
                MONTH(receive_date) as month,
                YEAR(receive_date) as year,
                SUM(amount) as total_amount,
                COUNT(*) as income_count
                FROM incomes 
                WHERE user_id = :user_id 
                AND YEAR(receive_date) = YEAR(CURRENT_DATE())
                GROUP BY MONTH(receive_date), YEAR(receive_date)
                ORDER BY year DESC, month DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getTotalForMonth($year, $month) {
        $sql = "SELECT SUM(amount) as total FROM incomes WHERE YEAR(receive_date) = :year AND MONTH(receive_date) = :month AND status = 'active'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['year' => $year, 'month' => $month]);
        $row = $stmt->fetch();
        return $row && isset($row['total']) ? (float)$row['total'] : 0;
    }

    public function getTotalTLForMonth($year, $month, $exchangeRate) {
        $sql = "SELECT amount, currency FROM incomes WHERE YEAR(receive_date) = :year AND MONTH(receive_date) = :month AND status = 'active'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['year' => $year, 'month' => $month]);
        $rows = $stmt->fetchAll();
        $total = 0;
        foreach ($rows as $row) {
            if (strtoupper($row['currency']) === 'TL' || strtoupper($row['currency']) === 'TRY') {
                $total += (float)$row['amount'];
            } else {
                $total += (float)$row['amount'] * $exchangeRate;
            }
        }
        return $total;
    }
}