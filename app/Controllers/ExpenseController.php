<?php

namespace App\Controllers;

use App\Interfaces\ExpenseServiceInterface;
use App\Models\Database; // Keep for now for stats queries

class ExpenseController {
    private $expenseService;

    // Inject the service via the constructor
    public function __construct(ExpenseServiceInterface $expenseService) {
        $this->expenseService = $expenseService;
    }

    public function index() {
        // The service is already available via $this->expenseService
        $db = Database::getInstance(); // TODO: Refactor stats queries into their own services/repositories

        $category_type = isset($_GET['category']) ? sanitize_input($_GET['category']) : null;
        $rows = $this->expenseService->listAllExpenses($category_type);

        // Harcama İstatistikleri
        $total_expenses = 0;
        foreach ($rows as $row) {
            $total_expenses += $row['amount'];
        }

        $expense_items_count = (int)$db->getDbValue("SELECT COUNT(*) FROM expenses");

        // Borç Ödemeleri İstatistikleri
        $current_month = date('Y-m');
        $total_debt_payments_sql = "
            SELECT 
                SUM(COALESCE(tax.this_month_payment, 0)) +
                SUM(COALESCE(sgk.this_month_payment, 0)) +
                SUM(COALESCE(exec.this_month_payment, 0)) +
                SUM(COALESCE(pers.amount, 0)) +
                SUM(COALESCE(bank.total, 0))
            FROM (
                SELECT this_month_payment, 'tax' as debt_type FROM tax_debts WHERE DATE_FORMAT(payment_due, '%Y-%m') = ?
            ) AS tax
            LEFT JOIN (
                SELECT this_month_payment, 'sgk' as debt_type FROM sgk_debts WHERE DATE_FORMAT(payment_due, '%Y-%m') = ?
            ) AS sgk ON 1=1
            LEFT JOIN (
                SELECT this_month_payment, 'execution' as debt_type FROM execution_debts WHERE DATE_FORMAT(start_date, '%Y-%m') = ?
            ) AS exec ON 1=1
            LEFT JOIN (
                SELECT amount, 'personal' as debt_type FROM personal_debts WHERE DATE_FORMAT(planned_payment_date, '%Y-%m') = ?
            ) AS pers ON 1=1
            LEFT JOIN (
                SELECT total, 'bank' as debt_type FROM bank_debts WHERE DATE_FORMAT(planned_payment_date, '%Y-%m') = ?
            ) AS bank ON 1=1
        ";
        $total_debt_payments = (float) $db->getDbValue($total_debt_payments_sql, array_fill(0, 5, $current_month));

        // Kalan Borç Sayısı (Basit bir sayım, detaylı durum takibi için daha karmaşık sorgular gerekir)
        $remaining_debt_count = (
            (int)$db->getDbValue("SELECT COUNT(*) FROM tax_debts WHERE paid < total") +
            (int)$db->getDbValue("SELECT COUNT(*) FROM sgk_debts WHERE paid < total") +
            (int)$db->getDbValue("SELECT COUNT(*) FROM execution_debts WHERE current_debt > 0") +
            (int)$db->getDbValue("SELECT COUNT(*) FROM personal_debts WHERE remaining > 0") +
            (int)$db->getDbValue("SELECT COUNT(*) FROM bank_debts WHERE total > 0")
        );

        // Alınacaklar İstatistikleri
        $total_wishlist_price = (float) $db->getDbValue("SELECT SUM(price) FROM wishlist_items WHERE wishlist_type IN ('ihtiyac', 'alinacak')");
        $approved_wishlist_count = (int) $db->getDbValue("SELECT COUNT(*) FROM wishlist_items WHERE status = 'purchased' AND wishlist_type IN ('ihtiyac', 'alinacak')");

        // Aylık Sabit ve Tek Seferlik Harcamalar
        $monthly_fixed_expenses = (float) $db->getDbValue("SELECT SUM(amount) FROM expenses WHERE category_type = 'sabit_gider' AND DATE_FORMAT(date, '%Y-%m') = ?", [$current_month]);
        $one_time_expenses = (float) $db->getDbValue("SELECT SUM(amount) FROM expenses WHERE category_type NOT IN ('sabit_gider', 'ertelenmis') AND DATE_FORMAT(date, '%Y-%m') = ?", [$current_month]);

        $csrf_token = generate_csrf_token();

        require_once __DIR__ . '/../../views/expenses/index.php';
    }
}
