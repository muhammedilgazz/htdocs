<?php

namespace App\Controllers;

use App\Models\Expense;

class ExtraExpenseController {
    public function index() {
        $expense_model = new Expense();
        $rows = $expense_model->getAll('ani_ekstra');

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/extra_expenses/index.php';
    }
}
