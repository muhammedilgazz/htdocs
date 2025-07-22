<?php

namespace App\Controllers;

use App\Models\PersonalDebt;

class IndividualDebtController {
    public function index() {
        $personal_debt_model = new \App\Models\PersonalDebt();
        $rows = $personal_debt_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/individual_debts/index.php';
    }
}
