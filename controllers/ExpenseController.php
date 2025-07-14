<?php

require_once 'C:/xampp/htdocs/models/Expense.php';
require_once 'C:/xampp/htdocs/models/UIHelper.php';
require_once 'C:/xampp/htdocs/config/config.php';

class ExpenseController {
    public function index() {
        $expense_model = new Expense();

        $rows = $expense_model->getAll();
        $total_expenses = $expense_model->getTotalExpenses();
        $expense_items_count = $expense_model->getExpenseItemsCount();
        $total_debt_payments = $expense_model->getTotalDebtPayments();
        $remaining_debt_count = $expense_model->getRemainingDebtCount();
        $total_wishlist_price = $expense_model->getTotalWishlistPrice();
        $approved_wishlist_count = $expense_model->getApprovedWishlistCount();
        $monthly_fixed_expenses = $expense_model->getMonthlyFixedExpenses();
        $one_time_expenses = $expense_model->getOneTimeExpenses();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/expenses/index.php';
    }
}
