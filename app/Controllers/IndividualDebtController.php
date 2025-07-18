<?php

namespace App\Controllers;

use App\Models\PersonalDebt;

class IndividualDebtController {
    public function index() {
        $personal_debt_model = new PersonalDebt();
        $rows = $personal_debt_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once 'C:/xampp/htdocs/views/individual_debts/index.php';
    }
}
