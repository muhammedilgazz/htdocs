<?php

namespace App\Models;

use App\Models\Database;
use Exception;

class Dashboard {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Ana sayfa için temel istatistikleri toplar.
     */
    public function getDashboardStats() {
        $current_month = date('Y-m');

        // Aylık Giderler
        $sql_expenses = "SELECT SUM(amount) FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = ?";
        $total_expenses = (float) $this->db->getDbValue($sql_expenses, [$current_month]);

        // Aylık Alınacaklar (Tüm alınacaklar, created_at sütunu olmadığı için aylık filtreleme yapılamıyor)
        $sql_wishlist = "SELECT SUM(price) FROM wishlist_items WHERE wishlist_type IN ('ihtiyac', 'alinacak', 'istek', 'hayal', 'favori')";
        $total_wishlist = (float) $this->db->getDbValue($sql_wishlist);

        // Aylık Borç Ödemeleri (Tabloların varlığını kontrol ederek)
        $total_debt_payments = 0;
        try {
            // Borç tablolarını kontrol et ve topla
            $debt_tables = [
                'tax_debts' => ['amount_field' => 'this_month_payment', 'date_field' => 'payment_due'],
                'sgk_debts' => ['amount_field' => 'this_month_payment', 'date_field' => 'payment_due'],
                'execution_debts' => ['amount_field' => 'this_month_payment', 'date_field' => 'start_date'],
                'personal_debts' => ['amount_field' => 'amount', 'date_field' => 'planned_payment_date'], // Corrected from planned_payment
                'bank_debts' => ['amount_field' => 'total', 'date_field' => 'planned_payment_date'] // Corrected from planned_payment
            ];
            
            foreach ($debt_tables as $table => $config) {
                try {
                    $sql = "SELECT SUM({$config['amount_field']}) FROM $table WHERE DATE_FORMAT({$config['date_field']}, '%Y-%m') = ?";
                    $amount = (float) $this->db->getDbValue($sql, [$current_month]);
                    $total_debt_payments += $amount;
                } catch (Exception $e) {
                    // Tablo yoksa veya sütun hatası varsa devam et
                    continue;
                }
            }
        } catch (Exception $e) {
            $total_debt_payments = 0;
        }

        // Toplam Bakiye (Bu kısım için bir balances tablosu veya mantığına ihtiyaç var, şimdilik 0 varsayalım)
        $total_balance = 0; // Bu mantığın ayrıca implemente edilmesi gerekir.

        return [
            'total_expenses' => $total_expenses,
            'total_wishlist' => $total_wishlist,
            'total_debt_payments' => $total_debt_payments,
            'total_balance' => $total_balance
        ];
    }

    /**
     * Son işlemleri (giderler ve alınacaklar) getirir.
     */
    public function getRecentTransactions() {
        $sql = "
            (SELECT 'expense' as type, description, amount, date FROM expenses ORDER BY date DESC LIMIT 5)
            UNION ALL
            (SELECT 'wishlist' as type, item_name as description, price as amount, created_at as date FROM wishlist_items ORDER BY created_at DESC LIMIT 5)
            ORDER BY date DESC
            LIMIT 5
        ";
        return $this->db->fetchAll($sql);
    }

    /**
     * Giderleri kategoriye göre gruplandırarak getirir.
     */
    public function getCategoryExpenses() {
        $sql = "SELECT category_type, SUM(amount) as total_amount, COUNT(*) as transaction_count 
                FROM expenses 
                GROUP BY category_type 
                ORDER BY total_amount DESC";
        return $this->db->fetchAll($sql);
    }
}
