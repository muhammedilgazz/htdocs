<?php

namespace App\Controllers;

use App\Models\BankDebt;

class BankController {
    public function index() {
        $bank_debt_model = new BankDebt();
        $rows = $bank_debt_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/bank/index.php';
    }
}
