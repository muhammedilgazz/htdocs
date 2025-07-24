<?php

namespace App\Repositories;

use App\Models\Database;
use Exception;

class DashboardRepository
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getDashboardStats()
    {
        $current_month = date('Y-m');

        // Aylık Giderler
        $sql_expenses = "SELECT SUM(amount) FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = ?";
        $total_expenses = (float) $this->db->getDbValue($sql_expenses, [$current_month]);

        // Aylık Alınacaklar
        $sql_wishlist = "SELECT SUM(price) FROM wishlist_items WHERE wishlist_type IN ('ihtiyac', 'alinacak', 'istek', 'hayal', 'favori')";
        $total_wishlist = (float) $this->db->getDbValue($sql_wishlist);

        // Aylık Borç Ödemeleri
        $total_debt_payments = 0;
        $debt_tables = [
            'tax_debts' => ['amount_field' => 'this_month_payment', 'date_field' => 'payment_due'],
            'sgk_debts' => ['amount_field' => 'this_month_payment', 'date_field' => 'payment_due'],
            'execution_debts' => ['amount_field' => 'this_month_payment', 'date_field' => 'start_date'],
            'personal_debts' => ['amount_field' => 'amount', 'date_field' => 'planned_payment_date'],
            'bank_debts' => ['amount_field' => 'total', 'date_field' => 'planned_payment_date']
        ];
        
        foreach ($debt_tables as $table => $config) {
            try {
                $sql = "SELECT SUM({$config['amount_field']}) FROM $table WHERE DATE_FORMAT({$config['date_field']}, '%Y-%m') = ?";
                $amount = (float) $this->db->getDbValue($sql, [$current_month]);
                $total_debt_payments += $amount;
            } catch (Exception $e) {
                continue;
            }
        }

        // Toplam Bakiye (Bu mantığın ayrıca implemente edilmesi gerekir)
        $total_balance = 0; 

        return [
            'total_expenses' => $total_expenses,
            'total_wishlist' => $total_wishlist,
            'total_debt_payments' => $total_debt_payments,
            'total_balance' => $total_balance
        ];
    }

    public function getRecentTransactions()
    {
        $sql = "
            (SELECT 'expense' as type, description, amount, date FROM expenses ORDER BY date DESC LIMIT 5)
            UNION ALL
            (SELECT 'wishlist' as type, item_name as description, price as amount, created_at as date FROM wishlist_items ORDER BY created_at DESC LIMIT 5)
            ORDER BY date DESC
            LIMIT 5
        ";
        return $this->db->fetchAll($sql);
    }

    public function getCategoryExpenses()
    {
        $sql = "SELECT category_type, SUM(amount) as total_amount, COUNT(*) as transaction_count
                FROM expenses
                GROUP BY category_type
                ORDER BY total_amount DESC";
        return $this->db->fetchAll($sql);
    }

    public function getTotalExpenseCount(): int
    {
        return (int) $this->db->getDbValue("SELECT COUNT(*) FROM expenses");
    }

    public function getWishlistStats(): array
    {
        $total_price = (float) $this->db->getDbValue("SELECT SUM(price) FROM wishlist_items WHERE wishlist_type IN ('ihtiyac', 'alinacak')");
        $approved_count = (int) $this->db->getDbValue("SELECT COUNT(*) FROM wishlist_items WHERE status = 'purchased' AND wishlist_type IN ('ihtiyac', 'alinacak')");
        return ['total_price' => $total_price, 'approved_count' => $approved_count];
    }

    public function getMonthlyExpenseBreakdown(string $current_month): array
    {
        $fixed = (float) $this->db->getDbValue("SELECT SUM(amount) FROM expenses WHERE category_type = 'sabit_gider' AND DATE_FORMAT(date, '%Y-%m') = ?", [$current_month]);
        $one_time = (float) $this->db->getDbValue("SELECT SUM(amount) FROM expenses WHERE category_type NOT IN ('sabit_gider', 'ertelenmis') AND DATE_FORMAT(date, '%Y-%m') = ?", [$current_month]);
        return ['fixed' => $fixed, 'one_time' => $one_time];
    }
    
    public function getRemainingDebtCount(): int
    {
        $count = 0;
        $debt_tables = [
            "tax_debts" => "paid < total",
            "sgk_debts" => "paid < total",
            "execution_debts" => "current_debt > 0",
            "personal_debts" => "remaining > 0",
            "bank_debts" => "total > 0"
        ];

        foreach ($debt_tables as $table => $condition) {
            try {
                $count += (int)$this->db->getDbValue("SELECT COUNT(*) FROM $table WHERE $condition");
            } catch (Exception $e) {
                continue;
            }
        }
        return $count;
    }
}