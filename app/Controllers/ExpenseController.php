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

    /**
     * AJAX: Gider ekleme
     * POST: description, amount, category_type, date, csrf_token
     */
    public function ajax_add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $data = [
            'description' => sanitize_input($_POST['description'] ?? ''),
            'amount' => (float)($_POST['amount'] ?? 0),
            'category_type' => sanitize_input($_POST['category_type'] ?? ''),
            'date' => sanitize_input($_POST['date'] ?? '')
        ];
        $result = $this->expenseService->createNewExpense($data);
        if ($result) {
            return ['success' => true, 'message' => 'Gider başarıyla eklendi.', 'expense_id' => $result];
        } else {
            return ['success' => false, 'message' => 'Gider eklenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Gider bilgisi getirme
     * POST: id, csrf_token
     */
    public function ajax_get() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $expense = $this->expenseService->getExpenseById($id);
        if ($expense) {
            return ['success' => true, 'data' => $expense];
        } else {
            return ['success' => false, 'message' => 'Gider bulunamadı.'];
        }
    }

    /**
     * AJAX: Gider güncelleme
     * POST: id, description, amount, category_type, date, csrf_token
     */
    public function ajax_update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'description' => sanitize_input($_POST['description'] ?? ''),
            'amount' => (float)($_POST['amount'] ?? 0),
            'category_type' => sanitize_input($_POST['category_type'] ?? ''),
            'date' => sanitize_input($_POST['date'] ?? '')
        ];
        if ($this->expenseService->updateExistingExpense($id, $data)) {
            return ['success' => true, 'message' => 'Gider başarıyla güncellendi.'];
        } else {
            return ['success' => false, 'message' => 'Gider güncellenirken bir hata oluştu.'];
        }
    }

    /**
     * AJAX: Gider silme
     * POST: id, csrf_token
     */
    public function ajax_delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf_token($_POST['csrf_token'] ?? '')) {
            return ['success' => false, 'message' => 'Geçersiz istek.'];
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($this->expenseService->deleteExpenseById($id)) {
            return ['success' => true, 'message' => 'Gider başarıyla silindi.'];
        } else {
            return ['success' => false, 'message' => 'Gider silinirken bir hata oluştu.'];
        }
    }
}
