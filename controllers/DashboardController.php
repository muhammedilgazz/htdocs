<?php

namespace App\Controllers;

use App\Models\Dashboard;

class DashboardController {
    public function index() {
        $dashboard_model = new Dashboard();

        $stats = $dashboard_model->getDashboardStats();
        $recent_transactions = $dashboard_model->getRecentTransactions();
        $category_expenses = $dashboard_model->getCategoryExpenses();

        // Verileri view'e aktarmak için değişkenlere ata
        $total_expenses = $stats['total_expenses'];
        $total_wishlist = $stats['total_wishlist'];
        $total_debt_payments = $stats['total_debt_payments'];
        $total_balance = $stats['total_balance'];

        // Fixed: Use absolute path instead of hard-coded Windows path
        require_once __DIR__ . '/../views/dashboard.php';
    }
}