<?php

namespace App\Controllers;

use App\Interfaces\ExpenseServiceInterface;
use App\Repositories\DashboardRepository;

class ExpenseController {
    private $expenseService;
    private $dashboardRepository;

    public function __construct(
        ExpenseServiceInterface $expenseService, 
        DashboardRepository $dashboardRepository
    ) {
        $this->expenseService = $expenseService;
        $this->dashboardRepository = $dashboardRepository;
    }

    public function index() {
        $category_type = isset($_GET['category']) ? sanitize_input($_GET['category']) : null;
        $rows = $this->expenseService->listAllExpenses($category_type);

        // Harcama İstatistikleri
        $total_expenses = array_sum(array_column($rows, 'amount'));
        $expense_items_count = $this->dashboardRepository->getTotalExpenseCount();

        // Borç ve Alınacaklar İstatistikleri
        $dashboard_stats = $this->dashboardRepository->getDashboardStats();
        $total_debt_payments = $dashboard_stats['total_debt_payments'];
        $remaining_debt_count = $this->dashboardRepository->getRemainingDebtCount();
        
        $wishlist_stats = $this->dashboardRepository->getWishlistStats();
        $total_wishlist_price = $wishlist_stats['total_price'];
        $approved_wishlist_count = $wishlist_stats['approved_count'];

        // Aylık Sabit ve Tek Seferlik Harcamalar
        $current_month = date('Y-m');
        $monthly_breakdown = $this->dashboardRepository->getMonthlyExpenseBreakdown($current_month);
        $monthly_fixed_expenses = $monthly_breakdown['fixed'];
        $one_time_expenses = $monthly_breakdown['one_time'];

        $csrf_token = generate_csrf_token();

        require_once __DIR__ . '/../../views/expenses/index.php';
    }
}
