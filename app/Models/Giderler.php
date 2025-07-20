<?php

namespace App\Models;

use App\Models\Database;

class Giderler {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getConsolidatedMonthlyExpenses($filter_type = 'month') {
        $current_period = '';
        switch ($filter_type) {
            case 'month':
                $current_period = date('Y-m');
                break;
            case 'next_month':
                $current_period = date('Y-m', strtotime('+1 month'));
                break;
            case 'year':
                $current_period = date('Y');
                break;
            case 'all':
                $current_period = ''; // No date filter for all time
                break;
        }

        $sql_parts = [];
        $params = [];

        // Helper function to build conditional WHERE clauses
        $build_where_clause = function($date_column, $additional_conditions = []) use ($filter_type, $current_period, &$params) {
            $where_clauses = [];
            if ($filter_type != 'all') {
                $date_format = ($filter_type == 'month' || $filter_type == 'next_month' ? '%Y-%m' : '%Y');
                $where_clauses[] = "DATE_FORMAT($date_column, '$date_format') = ?";
                $params[] = $current_period;
            }
            foreach ($additional_conditions as $condition) {
                $where_clauses[] = $condition;
            }
            return count($where_clauses) > 0 ? "WHERE " . implode(" AND ", $where_clauses) : "";
        };

        // Harcamalar
        $sql_parts[] = "
            SELECT
                description AS description,
                amount,
                date AS created_at,
                'Harcama' AS type
            FROM expenses
            " . $build_where_clause('date') . "
        ";

        // Alınacaklar
        $sql_parts[] = "
            SELECT
                item_name AS description,
                price AS amount,
                created_at,
                'Alınacak' AS type
            FROM wishlist_items
            " . $build_where_clause('created_at', ["wishlist_type IN ('ihtiyac', 'alinacak')", "status = 'active'"]) . "
        ";

        // Banka Borçları
        $sql_parts[] = "
            SELECT
                CONCAT(bank_name, ' - ', loan_type) AS description,
                total AS amount,
                planned_payment_date AS created_at,
                'Banka Borcu' AS type
            FROM bank_debts
            " . $build_where_clause('planned_payment_date') . "
        ";

        // İcra Borçları
        $sql_parts[] = "
            SELECT
                CONCAT(owner, ' - ', execution_office) AS description,
                current_debt AS amount,
                start_date AS created_at,
                'İcra Borcu' AS type
            FROM execution_debts
            " . $build_where_clause('start_date') . "
        ";

        // Şahıs Borçları
        $sql_parts[] = "
            SELECT
                to_whom AS description,
                amount AS amount,
                planned_payment_date AS created_at,
                'Şahıs Borcu' AS type
            FROM personal_debts
            " . $build_where_clause('planned_payment_date') . "
        ";

        // SGK Borçları
        $sql_parts[] = "
            SELECT
                CONCAT(owner, ' - ', period) AS description,
                total AS amount,
                payment_due AS created_at,
                'SGK Borcu' AS type
            FROM sgk_debts
            " . $build_where_clause('payment_due') . "
        ";

        // Vergi Borçları
        $sql_parts[] = "
            SELECT
                CONCAT(owner, ' - ', period) AS description,
                total AS amount,
                payment_due AS created_at,
                'Vergi Borcu' AS type
            FROM tax_debts
            " . $build_where_clause('payment_due') . "
        ";

        $full_sql = implode(" UNION ALL ", $sql_parts) . " ORDER BY created_at DESC";

        return $this->db->fetchAll($full_sql, $params);
    }
}
