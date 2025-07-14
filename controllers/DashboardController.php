<?php

require_once 'C:/xampp/htdocs/models/Dashboard.php';

class DashboardController {
    public function index() {
        $dashboard_model = new Dashboard();

        $stats = $dashboard_model->getDashboardStats();
        $all_transactions = $dashboard_model->getRecentTransactions();
        $category_expenses = $dashboard_model->getCategoryExpenses();

        require_once 'C:/xampp/htdocs/views/dashboard.php';
    }
}